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
        // Get the student information
        $student = User::where('id', $request->student_id)->first();
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://staging.fawaterk.com/api/v2/createInvoiceLink',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "cartTotal": "25",
                "currency": "USD",
                "customer": {
                    "first_name": "mohammad", 
                    "last_name": "hamza",
                    "email": "test@fawaterk.com",
                    "phone": "011252523655",
                    "address": "test address"
                },
                "redirectionUrls": {
                     "successUrl" : "https://dev.fawaterk.com/success",
                     "failUrl": "https://dev.fawaterk.com/fail",
                     "pendingUrl": "https://dev.fawaterk.com/pending"   
                },
                "cartItems": [
                    {
                        "name": "this is test oop 112252",
                        "price": "25",
                        "quantity": "1"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 3b0e2ea6330eca65eb3ae2e6a00aa05c097158a1cab873a7ac'
            ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);
    
        // Decode response to access invoice data
        // $response = json_decode($response);

        $response = json_decode($response, true);

// Accessing the fields in the response
        $invoice_id = $response['data']['invoiceId'];

        // echo $invoice_id ;
    //             echo $student ;

        if (isset($response['data']['invoiceId'])) {

            // echo $student ;
            $invoice = new Invoice();
            $invoice->student_id = $student->id;
            $invoice->invoice_id = $response['data']['invoiceId'];
            $invoice->amount = $request->amount;
            $invoice->payment_url = $response['data']['url'];
            $invoice->save(); 
    
            return response()->json($response);
         } else {
            return response()->json(['error' => 'Invoice creation failed'], 400);
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
}
