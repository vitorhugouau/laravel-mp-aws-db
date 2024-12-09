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

        $paymentId = $data['data']['id'];


        try {
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            if ($payment) {
                // Log para identificar o status do pagamento retornado
                Log::info("Pagamento recebido com ID {$paymentId} e status {$payment->status}");

                if ($payment->status === 'approved') {
                    // Log de entrada no bloco de pagamento aprovado
                    Log::info('Pagamento aprovado, processando informações.', ['payment_id' => $paymentId]);

                    $externalReference = json_decode($payment->external_reference, true);

                    if ($externalReference) {
                        // Log de external_reference decodificado
                        Log::info('External reference decodificado.', $externalReference);

                        $userId = $externalReference['user_id'] ?? null;
                        $userName = $externalReference['user_name'] ?? 'Desconhecido';
                        $imagemId = $externalReference['imagem_id'] ?? null;

                        if ($imagemId) {
                            // Log antes de salvar a venda
                            Log::info('Salvando venda com os dados recebidos.', [
                                'user_id' => $userId,
                                'user_name' => $userName,
                                'imagem_id' => $imagemId,
                                'payment_id' => $paymentId,
                                'status' => $payment->status,
                            ]);

                            $this->saveSale($userId, $userName, $imagemId, $paymentId, $payment->status);

                            // Log após salvar a venda
                            Log::info('Venda salva com sucesso.', [
                                'payment_id' => $paymentId,
                                'user_id' => $userId,
                                'imagem_id' => $imagemId,
                            ]);
                        } else {
                            // Log caso imagem_id esteja ausente
                            Log::warning('Imagem ID não encontrada no external_reference.', $externalReference);
                        }
                    } else {
                        // Log caso external_reference seja inválido ou ausente
                        Log::warning('External reference ausente ou inválido.', ['payment_id' => $paymentId]);
                    }
                } else {
                    // Log para pagamentos com status diferente de "approved"
                    Log::info("Pagamento com ID {$paymentId} não foi aprovado. Status: {$payment->status}");
                }
            } else {
                // Log caso o pagamento não seja encontrado
                Log::error("Pagamento com ID {$paymentId} não encontrado ou retorno inválido.");
            }
        } catch (\Exception $e) {
            // Log para erros gerais ao processar o webhook
            Log::error('Erro ao processar webhook.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_id' => $paymentId ?? 'desconhecido',
            ]);
        }


        return response()->json(['status' => 'success'], 200);
    }

    // Salvar uma venda
    protected function saveSale($userId, $userName, $productId, $paymentId, $status)
    {
        $existingSale = Sale::where('payment_id', $paymentId)->first();

        if (!$existingSale) {
            $imagem = ImgApi::find($productId);
            $value = $imagem ? $imagem->valor : 0;

            Sale::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'product_id' => $productId,
                'payment_id' => $paymentId,
                'status' => $status,
                'value' => $value,
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


        // Dados do pagamento
        $paymentData = [
            'transaction_amount' => (float) $valor, // Valor capturado do formulário
            'payment_method_id' => 'pix', // Método de pagamento
            'description' => 'Pagamento de imagem ID: ' . $imagemId,
            'payer' => [
                'first_name' => $request->user()->name ?? 'Nome de Teste', // Nome do usuário autenticado ou valor padrão
                'email' => $request->user()->email ?? 'teste@exemplo.com', // Email do usuário autenticado ou valor padrão
            ],
            'notification_url' => 'https://a11f-2604-980-900b-1000-86fc-3e41-71af-9f2b.ngrok-free.app/mercadopago/webhook', // URL dinâmica para notificações
            'external_reference' => 'Pagamento_' . time(),
        ];

        Log::info('Dados do pagamento preparados:', $paymentData);

        // Tentando acessar a API do Mercado Pago
        try {
            $accessToken = config('services.mercadopago.access_token'); // Access Token Mercado Pago
            Log::info('Access Token Mercado Pago obtido.');

            // Requisição para criar pagamento via Pix
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'X-Idempotency-Key' => $idempotencyKey,
            ])->post('https://api.mercadopago.com/v1/payments', $paymentData);

            Log::info('Resposta da API Mercado Pago recebida.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Verificando o status da requisição
            if ($response->failed()) {
                Log::error('Erro na requisição ao Mercado Pago', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('mercadopago.failure')
                    ->with('error', 'Erro ao processar pagamento via Pix.');
            }

            // Verificando a resposta
            $responseData = $response->json();
            Log::info('Resposta decodificada da API Mercado Pago:', ['response' => $responseData]);

            // Verificando se o QR Code foi gerado corretamente
            if (!isset($responseData['point_of_interaction']['transaction_data'])) {
                Log::error('Erro ao gerar QR Code: Dados de transação ausentes.', ['response' => $responseData]);
                return redirect()->route('mercadopago.failure')
                    ->with('error', 'Erro ao gerar QR Code.');
            }

            // Extraindo dados do QR Code
            $transactionData = $responseData['point_of_interaction']['transaction_data'];
            Log::info('Dados de transação encontrados:', ['transactionData' => $transactionData]);

            // Armazenando os dados na sessão
            session([
                'qrCode' => $transactionData['qr_code'],
                'qrCodeBase64' => $transactionData['qr_code_base64'],
                'ticketUrl' => $transactionData['ticket_url'],
                'externalReference' => $paymentData['external_reference'],
            ]);

            // Redirecionar para a tela do Pix
            Log::info('Redirecionando para /mercadopago/pix');
            return redirect()->route('mercadopago.pix');


        } catch (\Exception $e) {
            // Capturando exceções inesperadas
            Log::error('Erro inesperado ao processar pagamento', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('mercadopago.failure')
                ->with('error', 'Erro inesperado ao processar pagamento.');
        }
    }

    public function handleWebhook(Request $request)
    {
        // Log para visualizar as informações da notificação
        Log::info('Notificação recebida do Mercado Pago:', $request->all());

        // Lógica para processar a notificação (verificar status do pagamento, etc.)
        $paymentData = $request->all();

        // Exemplo de verificação de status de pagamento
        if (isset($paymentData['status']) && $paymentData['status'] === 'approved') {
            // Lógica para processar pagamento aprovado
        }

        // Retornar resposta para o Mercado Pago
        return response()->json(['status' => 'success']);
    }

    public function showPixPayment()
    {
        Log::info('Método showPixPayment iniciado');
        // Recuperar os dados da sessão
        $qrCode = session('qrCode');
        $qrCodeBase64 = session('qrCodeBase64');
        $ticketUrl = session('ticketUrl');
        $externalReference = session('externalReference');

        // Log detalhado para verificar os dados recuperados da sessão
        Log::info('Exibindo tela com QR Code. Dados da sessão:', [
            'qrCode' => $qrCode,
            'qrCodeBase64' => $qrCodeBase64,
            'ticketUrl' => $ticketUrl,
            'externalReference' => $externalReference,
        ]);

        // Se não houver dados de QR Code, logar um erro (caso necessário)
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


        // Retornar a view com os dados
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

            $body = json_decode($response->getBody(), true);

            if (!empty($body['results'])) {
                $status = $body['results'][0]['status'];

                // Retorna o status do pagamento
                return response()->json(['status' => $status]);
            } else {
                return response()->json(['status' => 'not_found']);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao verificar status do pagamento', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error']);
        }
    }


}