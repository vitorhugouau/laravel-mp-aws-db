<?php

namespace App\Http\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
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

    public function createPaymentPreference(Request $request)
    {
        $request->validate([
            'imagem_id' => 'required|integer',
            'valor' => 'required|numeric|min:0',
        ]);

        $this->authenticate();

        // Produto
        $product = [
            "id" => (string) $request->imagem_id,
            "title" => "Produto " . $request->imagem_id,
            "description" => "Descrição do Produto " . $request->imagem_id,
            "currency_id" => "BRL",
            "quantity" => 1,
            "unit_price" => (float) $request->valor,
        ];

        $items = [$product];

        // Pagador
        $payer = [
            "email" => "guest" . uniqid() . "@example.com", // Email fictício
        ];

        // URLs de retorno
        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('biblioteca'),
            // 'pending' => route('mercadopago.pending'),
        ];

        // Configuração da preferência
        $preferenceData = [
            "items" => $items,
            // "payer" => $payer,
            "back_urls" => $backUrls,
            "auto_return" => "approved",
            "external_reference" => (string) $request->imagem_id,
            "payment_methods_id" => 1,
                "payer" => [
                    "email" => "cliente-email.gmail.com"
                ],
            "payment_methods" => [
                "excluded_payment_methods" => [], 
                "default_payment_method_id" => "pix",
                "installments" => 1, 
            ],

        ];

        $client = new PreferenceClient();

        try {
            $preference = $client->create($preferenceData);

            // Redirecionar para o link de pagamento
            return redirect($preference->init_point);
        } catch (MPApiException $error) {
            Log::error('Erro ao criar preferência de pagamento: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
            ]);
            return response()->json(['error' => $error->getMessage(), 'code' => $error->getCode()], 500);
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
                $this->saveSale($user->id, $user->name, $imagem_id, $payment_id, $status);
            }
        }

        return view('pagamento.success', compact('payment_id', 'status', 'imagem'));
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
}
