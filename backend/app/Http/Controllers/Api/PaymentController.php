<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Membership;
use App\Models\ArtistMembership;
use App\Models\Payment;
use App\Services\OpenPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $openPayService;

    public function __construct(OpenPayService $openPayService)
    {
        $this->openPayService = $openPayService;
    }

    public function subscribe(Request $request)
    {
        $artist = $request->user()->artist;
        $membership = Membership::findOrFail($request->membership_id);

        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'payment_method' => 'required|array',
            'payment_method.token_id' => 'required|string',
        ]);

        try {
            // Crear cliente si no existe
            if (!$artist->openpay_customer_id) {
                $this->createOpenPayCustomer($artist);
            }

            // Crear suscripción en OpenPay
            // NOTA: Necesitas crear planes en OpenPay primero y guardar el plan_id en la membresía
            $subscription = $this->openPayService->createSubscription([
                'customer_id' => $artist->openpay_customer_id,
                'plan_id' => $membership->openpay_plan_id ?? 'plan_' . $membership->id, // Ajustar según tu configuración
                'card' => $request->payment_method['token_id'],
            ]);

            // Crear membresía
            $artistMembership = ArtistMembership::create([
                'artist_id' => $artist->id,
                'membership_id' => $membership->id,
                'openpay_subscription_id' => $subscription->id,
                'status' => 'active',
                'started_at' => now(),
                'expires_at' => now()->addDays($membership->duration_days),
                'auto_renew' => true,
            ]);

            // Crear registro de pago
            Payment::create([
                'artist_id' => $artist->id,
                'artist_membership_id' => $artistMembership->id,
                'membership_id' => $membership->id,
                'openpay_transaction_id' => $subscription->id,
                'openpay_subscription_id' => $subscription->id,
                'amount' => $membership->price,
                'status' => 'completed',
                'type' => 'subscription',
                'payment_method' => 'card',
                'paid_at' => now(),
            ]);

            return response()->json([
                'membership' => $artistMembership->load('membership'),
                'message' => 'Suscripción activada exitosamente',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar el pago: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cancelSubscription(Request $request)
    {
        $artist = $request->user()->artist;
        $membership = $artist->membership;

        if (!$membership) {
            return response()->json([
                'message' => 'No tienes una suscripción activa',
            ], 404);
        }

        try {
            // Cancelar en OpenPay
            $this->openPayService->cancelSubscription($membership->openpay_subscription_id);

            // Actualizar en base de datos
            $membership->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'auto_renew' => false,
            ]);

            return response()->json([
                'message' => 'Suscripción cancelada exitosamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cancelar la suscripción: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        // Procesar webhooks de OpenPay
        $event = $request->all();

        // Validar firma del webhook (importante para seguridad)
        // Implementar validación según documentación de OpenPay

        switch ($event['type']) {
            case 'charge.succeeded':
                // Actualizar estado de pago
                break;
            case 'subscription.cancelled':
                // Cancelar membresía
                break;
            case 'subscription.expired':
                // Marcar membresía como expirada
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    private function createOpenPayCustomer(Artist $artist)
    {
        // Crear cliente en OpenPay
        $customer = $this->openPayService->createCustomer([
            'name' => $artist->user->name,
            'email' => $artist->user->email,
            'phone_number' => $artist->user->phone,
        ]);

        // Guardar customer_id en el artista
        $artist->update(['openpay_customer_id' => $customer->id]);

        return $customer->id;
    }
}

