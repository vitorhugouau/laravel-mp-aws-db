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


class MercadoPagoCard extends Controller
{

    protected function authenticate()
    {
        $mpAccessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

       
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

    }

    public function createPaymentPreference(Request $request)
{
    Log::info('Iniciando criação da preferência de pagamento.');

    $validated = $request->validate([
        'imagem_id' => 'required',
        'valor' => 'required',
    ]);

    Log::info('Dados validados com sucesso.', ['validated_data' => $validated]);

    $imagemId = $validated['imagem_id'];
    $valor = (float) $validated['valor'];

    Log::info('Valores extraídos.', ['imagem_id' => $imagemId, 'valor' => $valor]);

    $this->authenticate();
    Log::info('Autenticação realizada com sucesso.');

    $user = Auth::user();
    Log::info('Usuário autenticado.', ['user_id' => $user->id, 'user_email' => $user->email]);

    $product1 = [
        "id" => (string) $request->imagem_id,
        "title" => "Produto " . $request->imagem_id,
        "description" => "Descrição do Produto " . $request->imagem_id,
        "currency_id" => "BRL",
        "quantity" => 1,
        "unit_price" => (float) $request->valor
    ];

    Log::info('Produto criado.', ['product' => $product1]);

    $items = [$product1];

    $payer = [
        "name" => $request->user()->name,
        "email" => $request->user()->email
    ];

    Log::info('Informações do comprador criadas.', ['payer' => $payer]);

    $requestData = $this->createPreferenceRequest($items, $payer);
    $requestData['external_reference'] = $request->imagem_id;

    Log::info('Dados para preferência criados.', ['request_data' => $requestData]);

    $client = new PreferenceClient();

    try {
        Log::info('Tentando criar a preferência de pagamento.');
        $preference = $client->create($requestData);
        Log::info('Preferência de pagamento criada com sucesso.', ['init_point' => $preference->init_point]);
        return redirect($preference->init_point);

    } catch (MPApiException $error) {
        Log::error('Erro ao criar preferência de pagamento.', [
            'message' => $error->getMessage(),
            'code' => $error->getCode(),
        ]);
        return response()->json(['error' => 'Erro ao criar a preferência de pagamento.'], 500);
    }
}

private function createPreferenceRequest($items, $payer): array
{
    Log::info('Criando dados da preferência para o Mercado Pago.', ['items' => $items, 'payer' => $payer]);

    $paymentMethods = [
        "excluded_payment_methods" => [],
        "installments" => 12,
        "default_installments" => 1
    ];

    $backUrls = [
        'success' => route('mercadopago.success'),
        'failure' => route('biblioteca'),
    ];

    $requestData = [
        "items" => $items,
        "payer" => $payer,
        "payment_methods" => $paymentMethods,
        "back_urls" => $backUrls,
        "statement_descriptor" => "MINHA LOJA",
        "expires" => false,
        "auto_return" => 'approved',
    ];

    Log::info('Dados da preferência criados com sucesso.', ['request_data' => $requestData]);

    return $requestData;
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
    
}