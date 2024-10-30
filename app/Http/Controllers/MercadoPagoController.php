<?php

namespace App\Http\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;
use App\Models\Imagem;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;


class MercadoPagoController extends Controller
{

    protected function authenticate()
    {
        $mpAccessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        // MercadoPagoConfig::setAccessToken($mpAccessToken);
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

    }

    public function createPaymentPreference(Request $request)
    {
        // Valida os campos de entrada
        $request->validate([
            'imagem_id' => 'required|integer',
            'valor' => 'required|numeric|min:0',
        ]);

        $this->authenticate();

        // Cria os detalhes do produto
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

        // Inclui o imagem_id como referência externa
        $requestData = $this->createPreferenceRequest($items, $payer);
        $requestData['external_reference'] = $request->imagem_id;

        $client = new PreferenceClient();

        try {
            $preference = $client->create($requestData);
            return response()->json(['init_point' => $preference->init_point]);

        } catch (MPApiException $error) {
            \Log::error('Erro ao criar preferência de pagamento: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
                'response' => $error->getResponseBody()
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
            'failure' => route('mercadopago.failure'),
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
        // Recupera o valor da imagem
        $imagem = Imagem::find($productId);
        $value = $imagem ? $imagem->valor : 0; // Se a imagem existir, pega o valor, senão coloca 0
    
        Sale::create([
            'user_id' => $userId, // Armazena o ID do usuário
            'user_name' => $userName, // Armazena o nome do usuário
            'product_id' => $productId,
            'payment_id' => $paymentId,
            'status' => $status,
            'value' => $value, // Armazena o valor da venda
        ]);
    }
    


    public function paymentSuccess(Request $request)
    {
        $payment_id = $request->query('payment_id');
        $status = $request->query('status');
        $imagem_id = $request->query('external_reference');
    
        // Recupera a imagem usando o ID
        $imagem = Imagem::find($imagem_id);
    
        if ($imagem) {
            // Salva a venda no banco de dados
            $user = Auth::user(); // Obtém o usuário autenticado
            if ($user) {
                $userName = $user->name; // Obtém o nome do usuário autenticado
                $this->saveSale($user->id, $userName, $imagem_id, $payment_id, $status);
            }
        }
    
        // Retorna a tela de sucesso com os detalhes
        return view('pagamento.success', compact('payment_id', 'status', 'imagem'));
    }
    
}
