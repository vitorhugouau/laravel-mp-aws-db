<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Sale;
use App\Models\ImgApi;
use Illuminate\Support\Facades\Auth;

class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        // Obtém a assinatura da requisição
        $signature = $request->header('x-mercadopago-signature');

        // Calcular a assinatura esperada (substitua 'chave-secreta' pela sua chave real)
        $expectedSignature = hash_hmac('sha256', $request->getContent(), 'aacc08de693c8381265be1b4b29a830d717305fa07e2e0c5b20010d2b84d34f0');

        // Verificar se a assinatura recebida coincide com a esperada
        if (!$signature || $signature !== $expectedSignature) {
            Log::error('Assinatura inválida recebida: ' . $signature);
            return response()->json(['error' => 'Assinatura inválida'], 403);
        }

        $data = $request->all();

        // Verifica se o pagamento existe no webhook
        if (isset($data['data']['id'])) {
            $paymentId = $data['data']['id'];

            try {
                // Tenta obter o pagamento via MercadoPago API
                $client = new \MercadoPago\Client\Payment\PaymentClient();
                $payment = $client->get($paymentId);

                if ($payment->status === 'approved') {
                    $externalReference = isset($payment->external_reference) ? $payment->external_reference : null;

                    // Verifica se existe a referência externa antes de prosseguir
                    if (!$externalReference) {
                        Log::error('Falha ao obter a referência externa do pagamento: ' . $paymentId);
                        return response()->json(['error' => 'Falha ao obter a referência externa'], 400);
                    }

                    // Atualize a venda no banco de dados
                    $sale = Sale::where('payment_id', $paymentId)->first();
                    if (!$sale) {
                        $imagem = ImgApi::find($externalReference);
                        $value = $imagem ? $imagem->valor : 0;

                        Sale::create([
                            'user_id' => Auth::id(),
                            'user_name' => Auth::user()->name ?? 'Convidado',
                            'product_id' => $externalReference,
                            'payment_id' => $paymentId,
                            'status' => $payment->status,
                            'value' => $value,
                        ]);
                    }

                    Log::info('Pagamento aprovado via webhook: ' . $paymentId);
                } else {
                    Log::info('Pagamento não aprovado via webhook: ' . $paymentId . ' Status: ' . $payment->status);
                }

            } catch (\Exception $e) {
                Log::error('Erro ao processar o webhook: ' . $e->getMessage());
                return response()->json(['error' => 'Erro no processamento do pagamento'], 500);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
