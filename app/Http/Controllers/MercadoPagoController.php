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

        Log::info('Back URLs configuradas:', $backUrls);


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
            $preference = $client->create($preferenceData);
            return redirect($preference->init_point);
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

            if ($payment && $payment->status === 'approved') {

                Log::info('Entrou no método paymentSuccess', $request->all());
                
                $externalReference = json_decode($payment->external_reference, true);

                if ($externalReference) {
                    $userId = $externalReference['user_id'] ?? null;
                    $userName = $externalReference['user_name'] ?? 'Desconhecido';
                    $imagemId = $externalReference['imagem_id'] ?? null;

                    if ($imagemId) {
                        $this->saveSale($userId, $userName, $imagemId, $paymentId, $payment->status);
                    }
                }

                Log::info('Pagamento aprovado via webhook: ' . $paymentId);
            } else {
                Log::info('Pagamento recebido no webhook não foi aprovado. ID: ' . $paymentId);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook: ' . $e->getMessage());
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

    // Exibir tela de sucesso
    public function proximaTela(Request $request)
    {

        
        $payment_id = $request->query('payment_id');
        $status = $request->query('status');
        $imagem_id = $request->query('imagem_id');

        Log::info('Redirecionando para pagamento.success com:', [
            'payment_id' => $payment_id,
            'status' => $status,
            'imagem_id' => $imagem_id,
        ]);        

        $imagem = ImgApi::find($imagem_id);

        return view('pagamento.success', compact('payment_id', 'status', 'imagem'));
    }
}
