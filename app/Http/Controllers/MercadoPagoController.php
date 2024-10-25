<?php

namespace App\Http\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
    // Função para autenticar o Mercado Pago
    protected function authenticate()
{
    // Obtém o access token do arquivo .env
    $mpAccessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
    
    // Configura o token no SDK do Mercado Pago
    MercadoPagoConfig::setAccessToken($mpAccessToken);
    
    // Remover a linha do ambiente
    // MercadoPagoConfig::setRuntimeEnvironment(MercadoPagoConfig::LOCAL); // Remova esta linha
}

    // Função para criar uma nova preferência de pagamento
    public function createPaymentPreference(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'imagem_id' => 'required|integer',
            'valor' => 'required|numeric|min:0',
        ]);
    
        // Chama a função para autenticar o SDK do Mercado Pago
        $this->authenticate();
    
        // Define o item (produto) usando o valor recebido
        $product1 = [
            "id" => (string) $request->imagem_id,
            "title" => "Produto " . $request->imagem_id,
            "description" => "Descrição do Produto " . $request->imagem_id,
            "currency_id" => "BRL",
            "quantity" => 1,
            "unit_price" => (float) $request->valor
        ];
    
        // Definir os itens da compra
        $items = [$product1];
    
        // Definir o pagador (cliente)
        $payer = [
            "name" => "Vitor",
            "surname" => "Hugo",
            "email" => "nicolas@gmail.com"
        ];
    
        // Monta a requisição
        $requestData = $this->createPreferenceRequest($items, $payer);
        
        // Inicializa o cliente de preferências
        $client = new PreferenceClient();
    
        try {
            // Cria a preferência e obtém o link de pagamento
            $preference = $client->create($requestData);
    
            // Retorna o link de pagamento como resposta JSON
            return response()->json(['init_point' => $preference->init_point]);

        } catch (MPApiException $error) {
            // Registra o erro e retorna uma mensagem
            \Log::error('Erro ao criar preferência de pagamento: ', [
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
                'response' => $error->getResponseBody() // Registra a resposta completa
            ]);
            return response()->json(['error' => 'Erro ao criar a preferência de pagamento.'], 500);
        }
    }

    // Função para criar o array de requisição para a preferência
    private function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('biblioteca'),
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

    // Função para recuperar uma preferência pelo ID
    public function getPreferenceById($preferenceId)
    {
        // Autentica o SDK
        $this->authenticate();

        $client = new PreferenceClient();

        try {
            // Recupera a preferência pelo ID
            $preference = $client->get($preferenceId);

            // Retorna os detalhes da preferência
            return response()->json($preference);
        } catch (MPApiException $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
