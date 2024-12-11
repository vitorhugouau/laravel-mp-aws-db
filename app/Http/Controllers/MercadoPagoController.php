<?php

namespace App\Http\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ImgApi;
use App\Models\Sale;
use App\Models\Payments;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Http;
class MercadoPagoController extends Controller
{
    protected function authenticate()
    {
        $mpAccessToken = config('services.mercadopago.access_token');

        if (!$mpAccessToken) {
            throw new \Exception("Token de acesso do Mercado Pago não configurado.");
        }

        MercadoPagoConfig::setAccessToken($mpAccessToken);
    }

    // Criar preferência de pagamento
    public function createPaymentPreference(Request $request)
    {
        $request->validate([
            'imagem_id' => 'required|integer',
            'valor' => 'required|numeric|min:0',
        ]);

        $this->authenticate();

        $product = [
            "id" => (string) $request->imagem_id,
            "title" => "Produto " . $request->imagem_id,
            "description" => "Descrição do Produto " . $request->imagem_id,
            "currency_id" => "BRL",
            "quantity" => 1,
            "unit_price" => (float) $request->valor,
        ];

        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->name;

        $externalReference = json_encode([
            'user_id' => $userId,
            'user_name' => $userName,
            'imagem_id' => $request->imagem_id,
        ]);

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failure'),
        ];

        $preferenceData = [
            "items" => [$product],
            "back_urls" => $backUrls,
            "auto_return" => "approved",
            "external_reference" => $externalReference,
            "payment_methods" => [
                "excluded_payment_methods" => [],
                "default_payment_method_id" => "pix",
                "installments" => 1,
            ],
        ];

        $client = new PreferenceClient();

        try {
            // Cria a preferência de pagamento
            $preference = $client->create($preferenceData);

            // Obtém o ponto de inicialização da URL de pagamento
            $initPoint = $preference->init_point; // Esta URL redireciona para a página de pagamento com o QR Code

            return view('mercadopago.pix', [
                'initPoint' => $initPoint
            ]);
        } catch (MPApiException $error) {
            Log::error('Erro ao criar preferência de pagamento: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
            ]);
            return response()->json(['error' => $error->getMessage(), 'code' => $error->getCode()], 500);
        }
    }

    // Sucesso no pagamento
    public function paymentSuccess(Request $request)
    {
        Log::info('Entrou no método paymentSuccess', $request->all());


        $payment_id = $request->query('payment_id');
        $status = $request->query('status');
        $external_reference = json_decode($request->query('external_reference'), true);

        if (!$external_reference) {
            return redirect()->route('mercadopago.failure')->with('error', 'Referência externa inválida.');
        }

        $userId = $external_reference['user_id'] ?? null;
        $userName = $external_reference['user_name'] ?? 'Desconhecido';
        $imagem_id = $external_reference['imagem_id'] ?? null;

        $imagem = ImgApi::find($imagem_id);

        if ($status === 'approved' && $imagem && $userId) {
            $this->saveSale($userId, $userName, $imagem_id, $payment_id, $status);

            return redirect()->route('pagamento.success', [
                'payment_id' => $payment_id,
                'status' => $status,
                'imagem_id' => $imagem_id,
            ]);
        }

        return redirect()->route('mercadopago.failure')->with('error', 'Pagamento não foi aprovado ou imagem inválida.');
    }

    // Processar o webhook
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (!isset($data['data']['id'])) {
            Log::error('Webhook recebido sem ID de pagamento.');
            return response()->json(['error' => 'Dados inválidos'], 400);
        }

        $this->authenticate();

        // Recebe o ID do pagamento a partir da notificação do Mercado Pago
        $data = $request->all();
        $paymentId = $data['data']['id'];
        $externalReference = $data['data']['external_reference'] ?? null;

        if ($externalReference) {
            $payment = Payments::where('external_reference', $externalReference)->first();

            if ($payment) {
                $payment->update(['status' => $data['data']['status']]);
                Log::info("Pagamento atualizado com sucesso.", ['payment_id' => $paymentId]);
            } else {
                Log::warning("Pagamento com referência externa não encontrado.", ['external_reference' => $externalReference]);
            }
        }

        try {
            // Cria o cliente do Mercado Pago
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            // Verifica se o pagamento foi encontrado
            if (!$payment) {
                Log::warning("Pagamento com ID {$paymentId} não encontrado no Mercado Pago.");
                return response()->json(['error' => 'Pagamento não encontrado'], 404);
            }

            // Estrutura os dados do pagamento
            $paymentData = [
                'id' => $payment->id,
                'status' => $payment->status,
                'transaction_amount' => $payment->transaction_amount,
                'currency_id' => $payment->currency_id,
                'payer_name' => $payment->payer->first_name ?? 'Nome Desconhecido',
                'payer_email' => $payment->payer->email ?? 'email@desconhecido.com',
                'external_reference' => $payment->external_reference ?? null,
            ];

            Log::info('Detalhes do pagamento recebido:', $paymentData);

            $externalReference = $paymentData['external_reference'];

            if (strpos($externalReference, '{') === 0) {
                // Trata como JSON e decodifica
                $decodedReference = json_decode($externalReference, true);
            } else {
                // Trata como string simples
                $decodedReference = [
                    'user_id' => null,
                    'user_name' => 'Desconhecido',
                    'imagem_id' => $externalReference, // Usa o valor direto
                ];
            }

            // Verifica se a referência foi decodificada corretamente
            if (!$decodedReference) {
                Log::warning('Referência externa inválida ou não decodificada corretamente.', [
                    'external_reference' => $externalReference,
                ]);
                return response()->json(['error' => 'Referência externa inválida'], 400);
            }

            // Log da referência decodificada
            Log::info('Referência externa decodificada com sucesso.', $decodedReference);

            Log::info('Dados do pagamento antes de salvar:', [
                'external_reference' => $paymentData['external_reference'],
                'transaction_amount' => $paymentData['transaction_amount'],
                'status' => $paymentData['status'],

            ]);

            // Atualiza ou cria o registro do pagamento no banco
            $paymentRecord = Payments::updateOrCreate(
                ['external_reference' => $paymentData['external_reference']],
                [
                    'transaction_amount' => $paymentData['transaction_amount'],
                    'description' => 'Pagamento de imagem',
                ]
            );

            Log::info('Pagamento registrado/atualizado no banco.', $paymentRecord->toArray());

            // Verifica o status do pagamento
            if ($paymentData['status'] === 'approved') {
                // Log de pagamento aprovado
                Log::info("Pagamento aprovado, processando informações.", [
                    'payment_id' => $paymentId,
                ]);

                // Extrair o external_reference
                $externalReference = $paymentData['external_reference'];

                // Buscar o pagamento na tabela 'payments' usando o external_reference
                $paymentRecord = Payments::where('external_reference', $externalReference)->first();

                Log::info('Pagamento encontrado:', [
                    'user_id' => $paymentRecord->user_id,
                    'payer_name' => $paymentRecord->payer_name,
                    'imagem_id' => $paymentRecord->imagem_id,
                ]);

                if ($paymentRecord) {
                    // Se o pagamento foi encontrado, obtenha os dados
                    $userName = $paymentRecord->payer_name;
                    $userEmail = $paymentRecord->payer_email;
                    $imagemId = $paymentRecord->imagem_id;

                    // Buscar o user_id baseado no payer_email da tabela 'payments'
                    $user = Usuarios::where('email', $paymentRecord->payer_email)->first();

                    $userId = $user->id;  // Pegando o ID do usuário
                    $userName = $user->name;
                    $userEmail = $user->email;
                    $imagemId = $paymentRecord->imagem_id;

                    // Log dos dados extraídos
                    Log::info('Dados extraídos do pagamento:', [
                        'user_id' => $userId,
                        'user_name' => $userName,
                        'user_email' => $userEmail,
                        'imagem_id' => $imagemId,
                    ]);

                    // Log dos dados do pagamento antes de salvar a venda
                    Log::info('Dados extraídos do pagamento:', [
                        'user_id' => $userId,
                        'user_name' => $userName,
                        'user_email' => $userEmail,
                        'imagem_id' => $imagemId,
                    ]);

                    Log::info('Imagem ID antes de passar para a view:', ['imagem_id' => $paymentRecord->imagem_id]);


                    // Criar a venda usando os dados extraídos
                    $this->saveSale($userId, $userName, $imagemId, $paymentRecord->id, $paymentData['status']);

                    Log::info('Venda criada com sucesso.', [
                        'payment_id' => $paymentRecord->id,
                    ]);

                } else {
                    // Caso o pagamento não seja encontrado
                    Log::error("Pagamento não encontrado para o external_reference: " . $externalReference);
                }

            } else {
                Log::info("Pagamento com ID {$paymentId} não foi aprovado. Status: {$paymentData['status']}");
            }
        } catch (\Exception $e) {
            // Log de erro ao processar webhook
            Log::error('Erro ao processar webhook.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_id' => $paymentId ?? 'desconhecido',
            ]);
            return response()->json(['error' => 'Erro interno ao processar pagamento'], 500);
        }



        return response()->json(['status' => 'success'], 200);
    }

    // Salvar uma venda
    protected function saveSale($userId, $userName, $productId, $paymentId, $status)
    {
        Log::info('Iniciando o processo de salvar a venda.', [
            'user_id' => $userId,
            'product_id' => $productId,
            'payment_id' => $paymentId,
            'status' => $status,
        ]);

        // Verificando se já existe uma venda com o mesmo payment_id
        $existingSale = Sale::where('payment_id', $paymentId)->first();

        // Adicionando log para verificar se o código entrou na verificação de venda existente
        if ($existingSale) {
            Log::info('Venda já existente. Nenhuma ação realizada.', [
                'payment_id' => $paymentId,
            ]);
            return;  // Retorna sem fazer nada se a venda já existir
        } else {
            Log::info('Nenhuma venda existente encontrada, procedendo com a criação.');
        }

        // Recuperando os dados da imagem associada ao productId
        $imagem = ImgApi::find($productId);
        $value = $imagem ? $imagem->valor : 0;

        try {
            // Criando a nova venda no banco de dados
            Sale::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'product_id' => $productId,
                'payment_id' => $paymentId,
                'status' => $status,
                'value' => $value,
            ]);

            Log::info('Venda salva com sucesso.', [
                'payment_id' => $paymentId,
                'user_id' => $userId,
                'product_id' => $productId,
            ]);

            // return view('pagamento.success', [
            //     'payment_id' => $paymentId,  
            //     'status' => $status,
            //     'imagem_id' => $imagem,   
            // ]);



        } catch (\Exception $e) {
            // Log para captura de erro ao tentar salvar a venda
            Log::error('Erro ao salvar venda.', [
                'message' => $e->getMessage(),
                'payment_id' => $paymentId,
                'exception' => $e->getTraceAsString(),
            ]);
        }
    }


    public function testPixPayment(Request $request)
    {
        Log::info('Método testPixPayment iniciado');


        $validated = $request->validate([
            'imagem_id' => 'required',
            'valor' => 'required',
        ]);

        $imagemId = $validated['imagem_id'];
        $valor = (float) $validated['valor']; // Convertendo para float


        $imagemId = $validated['imagem_id']; // Acessando os dados validados
        $valor = $validated['valor']; // Acessando os dados validados

        Log::info('Dados recebidos do formulário:', ['imagem_id' => $imagemId, 'valor' => $valor]);

        // Gerando um ID único para o cabeçalho X-Idempotency-Key
        $idempotencyKey = uniqid('payment_', true);
        Log::info('ID de Idempotência Gerado:', ['idempotencyKey' => $idempotencyKey]);

        $user = Auth::user(); // Obtém o usuário autenticado

        if ($user) {
            Log::info('Usuário autenticado', [
                'id' => $user->id,
                'first_name' => $user->name,
                'email' => $user->email,
            ]);
        }

        if (!$user) {
            Log::error('Usuário não autenticado ao tentar iniciar o pagamento.');
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $userId = $user->id;

        // Construção do externalReference
        $externalReference = json_encode([
            'user_id' => $userId,
            'imagem_id' => $imagemId,
        ]);

        Log::info('Usuário autenticado e externalReference gerado:', [
            'user_id' => $userId,
            'external_reference' => $externalReference,
        ]);

        $paymentData = [
            'transaction_amount' => (float) $valor,
            'payment_method_id' => 'pix',
            'description' => 'Pagamento de imagem ID: ' . $imagemId,
            'payer' => [
                'first_name' => $request->user()->name ?? 'Nome de Teste',
                'email' => $request->user()->email ?? 'teste@exemplo.com',
            ],
            'notification_url' => 'https://90f9-2804-391c-20-2000-26c2-dfbd-f20b-e5ee.ngrok-free.app/webhook',
            'external_reference' => 'Pagamento_' . uniqid(),
        ];

        Log::info('Dados do pagamento preparados:', $paymentData);

        $status = 'pending';

        $payment = Payments::create([
            'transaction_amount' => $paymentData['transaction_amount'],
            'payment_method_id' => $paymentData['payment_method_id'],
            'description' => $paymentData['description'],
            'payer_name' => $paymentData['payer']['first_name'],
            'payer_email' => $paymentData['payer']['email'],
            'notification_url' => $paymentData['notification_url'],
            'external_reference' => $paymentData['external_reference'],
            'imagem_id' => $imagemId,
        ]);

        if ($payment) {
            Log::info('Pagamento criado no banco com sucesso:', [
                'payment_id' => $payment->id,
                'payment' => $payment,
            ]);
        }

        Log::info('Pagamento criado e dados armazenados:', [
            'payment_id' => $paymentData,
            'payer_name' => $paymentData['payer']['first_name'],
            'payer_email' => $paymentData['payer']['email'],
            'external_reference' => $paymentData['external_reference'],
        ]);

        try {
            $accessToken = config('services.mercadopago.access_token');
            Log::info('Access Token Mercado Pago obtido.');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'X-Idempotency-Key' => $idempotencyKey,
            ])->post('https://api.mercadopago.com/v1/payments', $paymentData);

            Log::info('Resposta da API Mercado Pago recebida.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                Log::error('Erro na requisição ao Mercado Pago', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('mercadopago.failure')
                    ->with('error', 'Erro ao processar pagamento via Pix.');
            }

            $responseData = $response->json();
            Log::info('Resposta decodificada da API Mercado Pago:', ['response' => $responseData]);

            if (!isset($responseData['point_of_interaction']['transaction_data'])) {
                Log::error('Erro ao gerar QR Code: Dados de transação ausentes.', ['response' => $responseData]);
                return redirect()->route('mercadopago.failure')
                    ->with('error', 'Erro ao gerar QR Code.');
            }

            $transactionData = $responseData['point_of_interaction']['transaction_data'];
            Log::info('Dados de transação encontrados:', ['transactionData' => $transactionData]);


            session([
                'qrCode' => $transactionData['qr_code'],
                'qrCodeBase64' => $transactionData['qr_code_base64'],
                'ticketUrl' => $transactionData['ticket_url'],
                'externalReference' => $paymentData['external_reference'],
                'external_Reference' => $externalReference,
            ]);


            Log::info('Redirecionando para /mercadopago/pix');
            return redirect()->route('mercadopago.pix');


        } catch (\Exception $e) {

            Log::error('Erro inesperado ao processar pagamento', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('mercadopago.failure')
                ->with('error', 'Erro inesperado ao processar pagamento.');
        }
    }

    public function showPixPayment()
    {
        Log::info('Método showPixPayment iniciado');

        $qrCode = session('qrCode');
        $qrCodeBase64 = session('qrCodeBase64');
        $ticketUrl = session('ticketUrl');
        $externalReference = session('externalReference');

        Log::info('Exibindo tela com QR Code. Dados da sessão:', [
            'qrCode' => $qrCode,
            'qrCodeBase64' => $qrCodeBase64,
            'ticketUrl' => $ticketUrl,
            'externalReference' => $externalReference,
        ]);

        if (!$qrCode || !$qrCodeBase64 || !$ticketUrl || !$externalReference) {
            Log::error('Dados da sessão incompletos para exibir QR Code', [
                'qrCode' => $qrCode,
                'qrCodeBase64' => $qrCodeBase64,
                'ticketUrl' => $ticketUrl,
                'externalReference' => $externalReference,
            ]);
        }

        Log::info('Dados da sessão antes de retornar a view:', [
            'qrCode' => $qrCode,
            'qrCodeBase64' => $qrCodeBase64,
            'ticketUrl' => $ticketUrl,
            'externalReference' => $externalReference,
        ]);


        return view('mercadopago.pix', compact('qrCode', 'qrCodeBase64', 'ticketUrl', 'externalReference'));
    }

    public function checkPaymentStatus($externalReference)
    {
        try {
            $accessToken = config('services.mercadopago.access_token');
            $url = "https://api.mercadopago.com/v1/payments/search?external_reference=" . $externalReference;

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            // Verifica se a resposta foi bem-sucedida
            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);

                if (!empty($body['results'])) {
                    // Retorna o status do pagamento
                    $status = $body['results'][0]['status'];

                    // Verifica se o status é encontrado corretamente
                    return response()->json(['status' => $status]);
                } else {
                    // Pagamento não encontrado
                    return response()->json(['status' => 'not_found'], 404);
                }
            } else {
                // Erro na requisição
                Log::error('Erro ao chamar API do Mercado Pago.', [
                    'status_code' => $response->getStatusCode(),
                    'external_reference' => $externalReference
                ]);
                return response()->json(['status' => 'error'], 500);
            }
        } catch (\Exception $e) {
            // Erro na comunicação ou processamento
            Log::error('Erro ao verificar status do pagamento', [
                'message' => $e->getMessage(),
                'external_reference' => $externalReference
            ]);
            return response()->json(['status' => 'error'], 500);
        }
    }



}