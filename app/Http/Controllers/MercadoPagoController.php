<?php

namespace App\Http\Controllers;

use MercadoPago\Preference;
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
use MercadoPago\Payment;

use MercadoPago\Item;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

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

        // Autenticação com Mercado Pago
        $this->authenticate();

        // Definir os detalhes do produto
        $product = new Item();
        $product->title = 'Produto ' . $request->imagem_id;
        $product->quantity = 1;
        $product->unit_price = (float) $request->valor;
        $product->currency_id = 'BRL';

        // Obter dados do usuário autenticado
        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->name;

        // Referência externa
        $externalReference = json_encode([
            'user_id' => $userId,
            'user_name' => $userName,
            'imagem_id' => $request->imagem_id,
        ]);

        // Configurar o pagamento
        $payment = new Payment();
        $payment->transaction_amount = (float) $request->valor;
        $payment->description = 'Pagamento de Produto';
        $payment->payment_method_id = 'pix';
        $payment->back_urls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failure'),
        ];
        $payment->auto_return = 'approved';
        $payment->external_reference = $externalReference;

        try {
            // Processar o pagamento
            $payment->save();

            // Obter URL do QR Code
            if ($payment->status === 'approved') {
                $qrCodeUrl = $payment->transaction_details->qr_code;

                // Exibir a view com QR Code e URL de pagamento
                return view('mercadopago.pix', [
                    'qrCodeUrl' => $qrCodeUrl,
                    'initPoint' => $payment->init_point, // URL para redirecionamento
                ]);
            }

            // Caso o pagamento não tenha sido aprovado
            return redirect()->route('mercadopago.failure')->with('error', 'Pagamento não foi aprovado');
        } catch (\Exception $error) {
            Log::error('Erro ao criar pagamento com PIX: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
            ]);
            return response()->json(['error' => $error->getMessage(), 'code' => $error->getCode()], 500);
        }
    }
    public function showPixPaymentPage(Request $request)
    {
        $initPoint = $request->query('initPoint'); // Obtém a URL do init_point do pagamento

        return view('mercadopago.pix', [
            'initPoint' => $initPoint
        ]);
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


}