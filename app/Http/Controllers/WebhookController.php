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
        
        Log::info('Webhook recebido:', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);
        
        $signature = $request->header('x-mercadopago-signature');
        $expectedSignature = hash_hmac('sha256', $request->getContent(), env('MERCADOPAGO_SIGNATURE'));
    
        if (!$signature || $signature !== $expectedSignature) {
            Log::error('Assinatura inválida recebida: ' . $signature);
            return response()->json(['error' => 'Assinatura inválida'], 403);
        }

        $data = $request->all();

        if (isset($data['data']['id'])) {
            $paymentId = $data['data']['id'];

            try {
    
                $client = new \MercadoPago\Client\Payment\PaymentClient();
                $payment = $client->get($paymentId);

                if ($payment->status === 'approved') {
                    $externalReference = isset($payment->external_reference) ? $payment->external_reference : null;

                    if (!$externalReference) {
                        Log::error('Falha ao obter a referência externa do pagamento: ' . $paymentId);
                        return response()->json(['error' => 'Falha ao obter a referência externa'], 400);
                    }

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

