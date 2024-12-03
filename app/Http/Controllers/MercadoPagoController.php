<?php

namespace App\Http\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;
use App\Models\Imagem;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use App\Models\ImgApi;
use Illuminate\Support\Facades\Log;


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

    public function createPaymentPreference(Request $request)
    {
      
        $request->validate([
            'imagem_id' => 'required|integer',
            'valor' => 'required|numeric|min:0',
        ]);

        $this->authenticate();

      
        $product1 = [
            "id" => (string) $request->imagem_id,
            "title" => "Produto " . $request->imagem_id,
            "description" => "Descrição do Produto " . $request->imagem_id,
            "currency_id" => "BRL",
            "quantity" => 1,
            "unit_price" => (float) $request->valor
        ];

        $items = [$product1];

        $payer = [
            "name" => "Vitor",
            "surname" => "Hugo",
            "email" => "nicolas@gmail.com"
        ];

       
        $requestData = $this->createPreferenceRequest($items, $payer);
        $requestData['external_reference'] = $request->imagem_id;

        $client = new PreferenceClient();

        try {
            $preference = $client->create($requestData);
            return redirect($preference->init_point);

        } catch (MPApiException $error) {
            Log::error('Erro ao criar preferência de pagamento: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
                
            ]);
            return response()->json(['error' => 'Erro ao criar a preferência de pagamento.'], 500);
        }
    }

    private function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('biblioteca'),
        ];

        return [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "MINHA LOJA",
            "external_reference" => "1234567890",
            "expires" => false,
            "auto_return" => 'approved',
        ];
    }

    public function getPreferenceById($preferenceId)
    {
        $this->authenticate();

        $client = new PreferenceClient();

        try {
            $preference = $client->get($preferenceId);

            return response()->json($preference);
        } catch (MPApiException $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    public function saveSale($userId, $userName, $productId, $paymentId, $status)
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
    
    public function paymentSuccess(Request $request)
    {
        $payment_id = $request->query('payment_id');
        $status = $request->query('status');
        $imagem_id = $request->query('external_reference');
    
        $imagem = ImgApi::find($imagem_id);
    
        if ($imagem) {
            $user = Auth::user();
            if ($user) {
                $userName = $user->name;
                $this->saveSale($user->id, $userName, $imagem_id, $payment_id, $status);
            }
        }
        
        return view('pagamento.success', compact('payment_id', 'status', 'imagem'));
    }

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
        $client = new \MercadoPago\Client\Payment\PaymentClient();
        $payment = $client->get($paymentId);

        if ($payment && $payment->status === 'approved') {
            $externalReference = $payment->external_reference;
            $sale = Sale::where('payment_id', $paymentId)->first();

            if (!$sale) {
                $imagem = ImgApi::find($externalReference);
                $value = $imagem ? $imagem->valor : 0;

                // Tentar recuperar o usuário logado (se houver)
                if ($user = Auth::user()) {
                    // Criar a venda com os dados do usuário logado
                    Sale::create([
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'product_id' => $externalReference,
                        'payment_id' => $paymentId,
                        'status' => $payment->status,
                        'value' => $value,
                    ]);

                    Log::info('Pagamento aprovado via webhook: ' . $paymentId);
                    return response()->json(['status' => 'success'], 200);
                } else {
                    Log::error('Usuário não autenticado para o pagamento ID: ' . $paymentId);
                    return response()->json(['error' => 'Usuário não autenticado'], 401); // Erro 401 se não estiver logado
                }
            } else {
                Log::info('Venda já registrada para o pagamento ID: ' . $paymentId);
                return response()->json(['status' => 'ignored'], 200); // Pagamento já foi processado
            }
        } else {
            Log::info('Pagamento recebido no webhook não foi aprovado. ID: ' . $paymentId);
            return response()->json(['status' => 'ignored'], 200); // Pagamento não aprovado
        }

    } catch (\Exception $e) {
        Log::error('Erro ao processar webhook: ' . $e->getMessage());
        return response()->json(['error' => 'Erro ao processar o pagamento'], 500);
    }
}
    
}
