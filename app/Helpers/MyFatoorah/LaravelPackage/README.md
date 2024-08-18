# MyFatoorah Laravel

## Description
This is the official MyFatoorah Payment Gateway Laravel package. 
MyFatoorah Laravel is based on [myfatoorah/library](https://packagist.org/packages/myfatoorah/library) composer package. 
Both MyFatoorah Laravel and PHP library composer packages are developed by [MyFatoorah Technical Team](mailto:tech@myfatoorah.com) to handle myfatoorah API endpoints.

## Main Features

* Create MyFatoorah invoices.
* Check the MyFatoorah payment status for invoice/payment.

## Installation
1. Install the package via [myfatoorah/laravel-package](https://packagist.org/packages/myfatoorah/laravel-package) composer.

```bash
composer require myfatoorah/laravel-package
```

2. Publish the **MyFatoorah** provider using the following CLI command.

```bash
php artisan vendor:publish --provider=" Support\MyFatoorah\LaravelPackage\MyFatoorahServiceProvider" --tag="myfatoorah"
```

3. To test the payment cycle, type the below URL onto your browser. Replace only the `{example.com}` with your site domain.

```bash
https://{example.com}/myfatoorah
```

4. Customize the **app/Http/Controllers/Dashboard/MyFatoorahController.php** file as per your site needs.

<hr>

## Merchant Configurations

Edit the **config/myfatoorah.php** file with your correct vendor data.

**Demo configuration**
1. You can use the test API token key mentioned [here](https://myfatoorah.readme.io/docs/test-token).
2. Make sure the test mode is true.
3. You can use one of [the test cards](https://myfatoorah.readme.io/docs/test-cards).

**Live Configuration**
1. You can use the live API token key mentioned [here](https://myfatoorah.readme.io/docs/live-token).
2. Make sure the test mode is false.
3. Make sure to set the country ISO code as mentioned in [this link](https://myfatoorah.readme.io/docs/iso-lookups).
