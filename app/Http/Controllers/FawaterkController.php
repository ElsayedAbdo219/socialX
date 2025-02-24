<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Services\FawaterkService;
use Illuminate\Http\Request;

class FawaterkController extends Controller
{
    protected $fawaterkService;

    public function __construct(FawaterkService $fawaterkService)
    {
        $this->fawaterkService = $fawaterkService;
    }

    public function createInvoice(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'country' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Get the student information
        $student = User::find($request->student_id);
    
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
    
        // Split the full name into first and second name
        $fullName = explode(' ', $student->name);
        $firstName = $fullName[0];
        $lastName = isset($fullName[1]) ? $fullName[1] : '';
    
        // Get currency based on the country
        $currency = $this->getCurrencyByCountry($request->country);
    
        // Prepare data for the API request
        $postData = [
            'cartTotal' => $request->amount,
            'currency' => $currency,
            'customer' => [
                'first_name' => $firstName, // Using the extracted first name
                'last_name' => $lastName, // Using the extracted last name
                'email' => $student->email,
                'phone' => $student->phone,
                'address' => $student->address
            ],
            'redirectionUrls' => [
                'successUrl' => url("/payment/success"),
                'failUrl' => url("/payment/fail"),
                'pendingUrl' => url("/payment/pending")
            ],
            'cartItems' => [
                [
                    'name' => 'hafazny program',
                    'price' => $request->amount,
                    'quantity' => 1
                ]
            ]
        ];
    
        // Initialize cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://staging.fawaterk.com/api/v2/createInvoiceLink',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer 3b0e2ea6330eca65eb3ae2e6a00aa05c097158a1cab873a7ac'
            ],
        ]);
    
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get HTTP status code
        curl_close($curl);
    
        // Check if API response was successful
        $responseArray = json_decode($response, true);
    
        if ($httpStatus === 200 && isset($responseArray['data']['invoiceId'])) {
            // Save the invoice in the database
            $invoice = new Invoice();
            $invoice->student_id = $student->id;
            $invoice->invoice_id = $responseArray['data']['invoiceId'];
            $invoice->amount = $request->amount;
            $invoice->payment_url = $responseArray['data']['url'];
            $invoice->save();
    
            return response()->json(['message' => 'Invoice created successfully', 'data' => $responseArray], 201);
        } else {
            return response()->json(['error' => 'Invoice creation failed', 'details' => $responseArray], 400);
        }
    }
    
    
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        if ($payload['status'] == 'paid') {
            $invoice = Invoice::where('invoice_id', $payload['invoiceId'])->first();
            if ($invoice) {
                $invoice->update(['status' => 'paid']);
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }


    // دالة للحصول على العملة بناءً على الدولة
private function getCurrencyByCountry($country)
{
    $currencies = [
        'Egypt' => 'EGP',   // مصر
        'Saudi Arabia' => 'SAR',  // السعودية
        'USA' => 'USD',  // الولايات المتحدة
        'UAE' => 'AED',  // الإمارات
        'Kuwait' => 'KWD',  // الكويت
        'Qatar' => 'QAR',  // قطر
        'Bahrain' => 'BHD',  // البحرين
    ];

    // إرجاع العملة بناءً على الدولة، الافتراضي هو الدولار
    return $currencies[$country] ?? 'EGP';
}


     public function success()
    {
        return view('payment.success');
    }

    public function fail()
    {
        return view('payment.fail');
    }

    public function pending()
    {
        return view('payment.pending');
    }





}
