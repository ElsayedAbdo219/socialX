<?php

use App\Actions\Transaction\MyFatoorahAction;
use App\Enum\Transaction\PaymentMethodsEnum;
use App\Enum\Transaction\TransactionReasonEnum;
use App\Mail\OTPMail;
use App\Models\Coupon;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('getLocales')) {
    /**
     * @return array array of supported locales
     */
    function getLocales($forSeeder = false)
    {
        return $forSeeder ? ['ar' => 'ar_EG', 'en' => 'en_US'] : ['ar', 'en'];
    }
}

if (!function_exists('activeGuard')) {

    function activeGuard(): int|string|null
    {

        foreach (array_keys(config('auth.guards')) as $guard) {

            if (auth()->guard($guard)->check()) {
                return $guard;
            }

        }
        return null;
    }
}

if (!function_exists('get_current_lang')) {
    function get_current_lang()
    {
        return App::getLocale();
    }
}

if (!function_exists('dynamicMultiLangValidationRules')) {
    /**
     * @param $attributesAndRules array array of multilang fileds as keys and their validation rules as values
     * @param $bindOtherAttibutesRules array|null array of other fields as keys and theris validation roles as values
     * @return array
     */
    function dynamicMultiLangValidationRules($attributesAndRules, $bindOtherAttibutesRules = null)
    {
        $validationRules = array();
        foreach (getLocales() as $locale) {
            foreach ($attributesAndRules as $attribute => $rules) {
                $validationRules[$attribute . '.' . $locale] = $rules;
            }
        }
        if (is_array($bindOtherAttibutesRules)) {
            foreach ($bindOtherAttibutesRules as $attribute => $rules) {
                $validationRules[$attribute] = $rules;
            }
        }
        return $validationRules;
    }
}

if (!function_exists('formattedCreatedAt')) {
    /**
     * @return string formated date
     */
    function formattedCreatedAt($created_at, $shouldParse = false)
    {
        if ($shouldParse) {
            $created_at = Carbon::parse($created_at);
        }
        return $created_at->toDayDateTimeString() . ' - ' . $created_at->diffForHumans();
    }
}

if (!function_exists('retrieveFromCache')) {
    function retrieveFromCache(string $key, $model = null, $quries = null, $relations = null, $order = "ASC", $isCollection = true)
    {
        return cache()->rememberForever($key, function () use ($model, $quries, $relations, $order, $isCollection) {
            if ($model == null) {
                return null;
            }
            $records = $model::query();
            if ($relations != null) {
                $records = $records->with($relations);
            }
            if (is_array($quries)) {
                foreach ($quries as $query) {
                    if (array_key_exists('attr', $query)) {
                        $records = $records->{$query['fn']}($query['attr']);
                    } else {
                        $records = $records->{$query['fn']}();
                    }
                }
            }
            if ($order != "ASC") {
                $records = $records->latest();
            }
            if (!$isCollection) {
                return $records->first();
            }
            return $records->get();
        });
    }
}

if (!function_exists('removeFromCache')) {
    function removeFromCache(string $key)
    {
        cache()->forget($key);
    }
}

if (!function_exists('reCache')) {
    function reCache(string $key, $model = null, $relations = null, $order = "ASC", $isCollection = true)
    {
        removeFromCache($key);
        return retrieveFromCache($key, $model, $relations, $order, $isCollection);
    }
}

if (!function_exists('prepareQueryCache')) {
    function prepareQueryCache(string $fn, $attr = null)
    {
        return is_null($attr) ? ['fn' => $fn] : ['fn' => $fn, 'attr' => $attr];
    }
}

if (!function_exists('encryptData')) {
    /**
     * @param $data string raw data to encrypt
     * @return string encrypted data
     */
    function encryptData($data, $key)
    {
        $encrypter = new Encrypter($key, Config::get('app.cipher'));
        return $encrypter->encrypt($data);
    }
}

if (!function_exists('decryptData')) {
    /**
     * @param $data string encrypted data to decrypt
     * @return string decrypt data
     */
    function decryptData($data, $key)
    {
        $encrypter = new Encrypter($key, Config::get('app.cipher'));
        return $encrypter->decrypt($data);
    }
}

if (!function_exists('randomCode')) {
    /**
     * @param $length int size of randomly generated number max size 100
     * @param $type int 0 for alphanumeric , 1  for numeric only, 2 for alphapitical only
     * @return mixed
     */
    function randomCode($length, $type = 0)
    {
        $min_lenght = 1;
        $max_lenght = 100;
        $bigL = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $smallL = "abcdefghijklmnopqrstuvwxyz";
        $number = "123456789";
        $bigB = str_shuffle($bigL);
        $smallS = str_shuffle($smallL);
        $numberS = str_shuffle($number);
        $subA = substr($bigB, 0, 5);
        $subB = substr($bigB, 6, 5);
        $subC = substr($bigB, 10, 5);
        $subD = substr($smallS, 0, 5);
        $subE = substr($smallS, 6, 5);
        $subF = substr($smallS, 10, 5);
        $subG = substr($numberS, 0, 5);
        $subH = substr($numberS, 6, 5);
        $subI = substr($numberS, 9, 5);
        switch ($type) {
            case 1:
                $RandCode1 = str_shuffle($subG . $subH . $subI);
                break;
            case 2:
                $RandCode1 = str_shuffle($subA . $subD . $subB . $subF . $subC . $subE);
                break;
            default:
                $RandCode1 = str_shuffle($subA . $subD . $subB . $subF . $subC . $subE . $subG . $subH . $subI);
                break;
        }
        $RandCode2 = str_shuffle($RandCode1);
        $RandCode = $RandCode1 . $RandCode2;

        if ($length > $min_lenght && $length < $max_lenght) {
            $CodeEX = substr($RandCode, 0, $length);
        } else {
            $CodeEX = $RandCode;
        }
        return $CodeEX;
    }
}

if (!function_exists('zipFiles')) {
    /**
     * @param $folder string output folder name
     * @param $files array array of files
     * @return void
     */
    function zipFiles($folder, $files)
    {
        $zip = new ZipArchive();
        if ($zip->open(public_path($folder), ZipArchive::CREATE | ZipArchive::OVERWRITE) == true) {
            foreach ($files as $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }
    }
}

if (!function_exists('generateAPIKey')) {
    function generateAPIKey()
    {
        $data['api_key'] = encryptData(Config::get('global.root_key'), Config::get('global.private_key'));
        Storage::disk('local')->put('api_key.json', json_encode($data));
    }
}

if (!function_exists('readAPIKey')) {
    function readAPIKey()
    {
        $apiKey = json_decode(Storage::disk('local')->get('api_key.json'), true);
        return $apiKey['api_key'] ?: 1234;
    }
}

if (!function_exists('diffInMinutesFormated')) {
    function diffInMinutesFormated($start, $end)
    {
        $diffInMinutes = $start->diffInMinutes($end);
        $minutes = floor($diffInMinutes);
        $seconds = ($diffInMinutes - $minutes) * 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}

if (!function_exists('searchMultipleLanguages')) {
    /**
     * search multi language database columns
     *
     * @param mixed $query elquent query builder
     * @param mixed $field database column
     * @param mixed $seach search value
     * @return mixed
     */
    function searchMultipleLanguages($query, $field, $search)
    {
        return $query->where(function ($query) use ($field, $search) {
            $locales = getLocales();
            if (!empty($locales)) {
                $query->where($field . '->' . $locales[0], 'LIKE', '%' . $search . '%');
                if (!empty(array_slice($locales, 1))) {
                    foreach (array_slice($locales, 1) as $locale) {
                        $query->orWhere($field . '->' . $locale, 'LIKE', '%' . $search . '%');
                    }
                }
            }
        });
    }
}

# Send SMS
if (!function_exists('sendSMS')) {
    function sendSMS($message, $mobile)
    {
        // $authdata = "username:pass:accountid";
        // $authdata = "11019383830476:gs2v;B(D_3/Bdkhu:871519";
        // base64 RFC 2045
        $encodedauthdata = "MTEwMTkzODA0NzY6Z3MydjtCKERfMy9CaHU6MTUxOQ==";
        $result = ['sms' => true];

        if (!config('global.sms') == "local") {
            $guzzelClient = new Client();
            $response = $guzzelClient->request('POST', 'http://weapi.connekio.com/sms/single', [
                'json' => [
                    "account_id" => 151915,
                    "text" => "{$message}",
                    "msisdn" => "2{$mobile}",
                    // "mnc" => "1",
                    // "mcc" => "602",
                    "sender" => "masdfjsdfnjs",
                ],
                [
                    'connect_timeout' => 30
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . $encodedauthdata,
                ]
            ]);

            $sms = false;
            if ($response->getStatusCode() === 200) {
                $data = json_decode((string)$response->getBody(), true);
                $sms = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
            }

            $result["sms"] = $sms;
        }

        return $result;
    }
}

# Send OTP Mail
if (!function_exists('sendOtpMail')) {
    function sendOtpMail($code, $email)
    {

        try {
            Mail::to($email)->send(new OTPMail($code));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

# HANDLE IMAGES
if (!function_exists('uploadImage')) {
    function uploadImage($name, $file, ?Model $model)
    {
        if ($file instanceof UploadedFile) {
            $model?->clearMediaCollection($name);

            return $model->addMedia($file)->toMediaCollection($name);
        }
    }
}

if (!function_exists('moveTempImage')) {
    function moveTempImage($collections_name, ?Model $toModel, $newCollectionName, $disk = 'public', $clearOld = false)
    {

        if ($clearOld) {
            $toModel?->clearMediaCollection($newCollectionName);
        }
        if (is_array($collections_name)) {
            foreach ($collections_name as $collection_name) {
                $array_id_collection = explode('|', $collection_name);
                if (is_array($array_id_collection) && count($array_id_collection) === 2) {
                    $fromModel = TemporaryUpload::findOrFail($array_id_collection[0]);
                    $mediaItem = $fromModel->getMedia($array_id_collection[1])->first();
                    $mediaItem && $mediaItem->move($toModel, $newCollectionName, $disk);
                    $mediaItem && $fromModel->clearMediaCollection($collection_name);
                }
            }
        }
        if (is_string($collections_name)) {
            $array_id_collection = explode('|', $collections_name);
            if (is_array($array_id_collection) && count($array_id_collection) === 2) {
                $fromModel = TemporaryUpload::findOrFail($array_id_collection[0]);
                $mediaItem = $fromModel->getMedia($array_id_collection[1])->first();
                $mediaItem && $mediaItem->move($toModel, $newCollectionName, $disk);
                $mediaItem && $fromModel->clearMediaCollection($collections_name);
            }
        }
    }
}


# Handle Select2
if (!function_exists('toMap')) {
    function toMap(Traversable $iterator, string $key = 'id', string $value = 'name'): array
    {
        $result = [];
        foreach ($iterator as $item) {
            $result[] = ['id' => $item[$key],'name' => $item[$value]];
        }

        return $result;
    }
}

# Remove Style From HTML Element
if (!function_exists('remove_style')) {
    function remove_style($data)
    {
        return preg_replace('/(<[^>]+) style=".*?"/i', '$1', strip_tags($data));
    }
}

# Handle Set And Get Setting
if (!function_exists('setting')) {
    function setting($key, $value = null, $default = null)
    {
        if ($value) {
            return $key == 'general' ? (double)data_get((new \App\Helpers\Setting())->{$key}, $value, $default)
                : data_get((new \App\Helpers\Setting())->{$key}, $value, $default);
        }

        return (new \App\Helpers\Setting())->{$key};
    }
}

# Start Transaction
if (!function_exists('myFatoorahTransaction')) {
    function myFatoorahTransaction(array $data, float|int $amount)
    {
        $transaction = getTransaction(
            transactionData: $data,
            amount: $amount
        );

        $myFatoorah = MyFatoorahAction::instance();
        [$status, $response] = $myFatoorah->makeInvoice($transaction);

        return $response;
    }
}

if (!function_exists('getTransaction')) {

    function getTransaction(array $transactionData, float|int $amount)
    {
        $invoice_number = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        $transactionData['invoice_number'] = $invoice_number;

        return auth(activeGuard())->user()?->transactions()->create([
            'data' => $transactionData,
            'pay_id' => Str::uuid(),
            'payment_method' => PaymentMethodsEnum::ONLINE,
            'amount' => $amount,
            'transaction_reasons' => $transactionData['transaction_reason'] ?? null,
        ]);
    }
}

if (!function_exists('prepareNotification')) {
    function prepareNotification($title, $body = null, $replace = []): array
    {
        return [
            'title' => json_encode(['en' => __($title, $replace, 'en'), 'ar' => __($title, $replace, 'ar')]),
            'body' => json_encode($body ?? $title),
            
        ];
    }
}

if (!function_exists('getAddress')) {
    function getAddress($latLng)
    {
        //google map api url
        $url = "https://maps.google.com/maps/api/geocode/json?latlng={$latLng}&key=" . config('general.google_map_key') . "&language=ar";
        try {
            $geocode = file_get_contents($url);
            $json = json_decode($geocode);
            foreach ($json->results[0]->address_components as $n) {
                if ($n->types[0] == "locality" && $n->types[1] == "political") {
                    $city = $n->long_name;
                }
                if ($n->types[0] == "country" && $n->types[1] == "political") {
                    $country = $n->long_name;
                }
            }
            return $json->results[0]->formatted_address;
        } catch (Exception $ex) {
            return '';
        }
    }
}

if (!function_exists('calcDistance')) {

    function calcDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km'): array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?key=' . config('general.google_map_key') . '&origins=' . $lat1 . ',' . $lon1 . '&destinations=' . $lat2 . ',' . $lon2 . '&language=en-EN&sensor=false&units=' . $unit)->json();
        if ($response['status'] == "OK" && $response['rows'][0]['elements'][0]["status"] == "OK") {
            $data['distance'] = round($response['rows'][0]['elements'][0]['distance']['value'] / 1000, 2);
            $data['duration'] = round($response['rows'][0]['elements'][0]['duration']['value'] / 60, 2);
        } else {
            $data['distance'] = 1;
            $data['duration'] = 1;
        }
        return $data;
    }
}

if (!function_exists('calcMapBoxDistance')) {

    function calcMapBoxDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km'): array
    {
        $response = Http::get('https://api.mapbox.com/directions/v5/mapbox/driving-traffic/31.8671075,31.1752971;31.9287465,31.1606048?access_token=' . config('general.map_box_key') . '&origins=' . $lat1 . ',' . $lon1 . '&destinations=' . $lat2 . ',' . $lon2 . '&language=en-EN&sensor=false&units=' . $unit)->json();
        if ($response['status'] == "OK" && $response['rows'][0]['elements'][0]["status"] == "OK") {
            $data['distance'] = round($response['rows'][0]['elements'][0]['distance']['value'] / 1000, 2);
            $data['duration'] = round($response['rows'][0]['elements'][0]['duration']['value'] / 60, 2);
        } else {
            $data['distance'] = 1;
            $data['duration'] = 1;
        }
        return $data;
    }
}

if (!function_exists('couponValidation')) {
    function couponValidation($coupon): string|null
    {
        if (!$coupon) {
            return __('coupon is invalid');
        }

        if (!$coupon->is_active) {
            return __('coupon is invalid');
        }

        if ($coupon->date_from > Carbon::today() || $coupon->date_to < Carbon::today()) {
            return __('coupon is invalid');
        }

        if (auth('api')->user()->couponsUsages()
                ->wherePivot("coupon_id", $coupon->id)->count() >= $coupon->using_number) {
            return __('coupon is invalid');
        }

        return null;
    }
}

if (!function_exists('getTranslation')) {
    function getTranslation($model, $filed, $lang)
    {
        return $model->getTranslations($filed)[$lang];
    }
}
