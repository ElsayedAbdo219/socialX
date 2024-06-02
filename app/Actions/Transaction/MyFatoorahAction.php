<?php

namespace App\Actions\Transaction;

use App\Helpers\MyFatoorah\Library\PaymentMyfatoorahApiV2;
use App\Models\Transaction;

class MyFatoorahAction extends PaymentMyfatoorahApiV2
{
    protected array $orderSetting;

    public static function instance(): MyFatoorahAction
    {
        defined('MYFATOORAH_LARAVEL_PACKAGE_VERSION') or define('MYFATOORAH_LARAVEL_PACKAGE_VERSION', '2.0.2');

        return new self(
            config('myfatoorah.api_key'),
            config('myfatoorah.country_iso'),
            config('myfatoorah.test_mode')
        );
    }

    public function makeInvoice(Transaction $transaction): array
    {

        $callbackURL =  route('payment.callback-pay-invoice');

        $curlData = [
            'CustomerName'       => request('customer.name', 'test'),
            'InvoiceValue'       => $transaction->amount,
            'DisplayCurrencyIso' => 'SAR', //TODO:: get from setting or config
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => '+966',
            'Language'           => get_current_lang(),
            'CustomerReference'  => $transaction->pay_id,
            'SourceInfo'         => 'Laravel '.app()::VERSION.' - MyFatoorah Package '.MYFATOORAH_LARAVEL_PACKAGE_VERSION,
        ];

        try {
            $paymentMethodId = 0; // 0 for MyFatoorah invoice or 1 for Knet in test mode

            return [200, $this->getInvoiceURL($curlData, $paymentMethodId)];
        } catch (\Exception $e) {
            return [400, $e->getMessage()];
        }
    }
}
