<?php

namespace App\Services;

use OpenPay;

class OpenPayService
{
    protected $openpay;

    public function __construct()
    {
        OpenPay::setId(config('openpay.merchant_id'));
        OpenPay::setApiKey(config('openpay.private_key'));
        OpenPay::setProductionMode(config('openpay.production', false));
    }

    public function createCustomer(array $data)
    {
        try {
            $customerData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'] ?? null,
            ];

            $customer = OpenPay::getInstance('customers', null)->create($customerData);

            return $customer;
        } catch (\Exception $e) {
            throw new \Exception('Error al crear cliente en OpenPay: ' . $e->getMessage());
        }
    }

    public function createSubscription(array $data)
    {
        try {
            $customer = OpenPay::getInstance('customers', null)->get($data['customer_id']);

            $subscriptionData = [
                'plan_id' => $data['plan_id'],
                'card' => $data['card'],
            ];

            $subscription = $customer->subscriptions->create($subscriptionData);

            return $subscription;
        } catch (\Exception $e) {
            throw new \Exception('Error al crear suscripción en OpenPay: ' . $e->getMessage());
        }
    }

    public function cancelSubscription($subscriptionId)
    {
        try {
            // Necesitas obtener el customer_id asociado a la suscripción
            // Esto requiere una búsqueda o almacenar el customer_id en la base de datos
            
            // Ejemplo básico (necesitarás adaptar según tu estructura)
            $subscription = OpenPay::getInstance('customers', $customerId)
                ->subscriptions->get($subscriptionId);

            $subscription->delete();

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error al cancelar suscripción en OpenPay: ' . $e->getMessage());
        }
    }

    public function getSubscription($subscriptionId, $customerId)
    {
        try {
            $subscription = OpenPay::getInstance('customers', $customerId)
                ->subscriptions->get($subscriptionId);

            return $subscription;
        } catch (\Exception $e) {
            throw new \Exception('Error al obtener suscripción en OpenPay: ' . $e->getMessage());
        }
    }

    public function createCharge(array $data)
    {
        try {
            $customer = OpenPay::getInstance('customers', null)->get($data['customer_id']);

            $chargeData = [
                'method' => 'card',
                'source_id' => $data['token_id'],
                'amount' => $data['amount'],
                'description' => $data['description'] ?? 'Pago de membresía',
                'currency' => 'MXN',
            ];

            $charge = $customer->charges->create($chargeData);

            return $charge;
        } catch (\Exception $e) {
            throw new \Exception('Error al procesar pago en OpenPay: ' . $e->getMessage());
        }
    }
}

