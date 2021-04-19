<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class PaymentController extends Controller
{
    protected $client;
    protected $controllerFunction;

    public function __construct()
    {
        $this->middleware(['auth', 'twostep']);
        // Creating an environment
        $clientId = config('app.CLIENT_ID', 'true');// ?: "PAYPAL-SANDBOX-CLIENT-ID";
        $clientSecret = config('app.CLIENT_SECRET', 'true');// ?: "PAYPAL-SANDBOX-CLIENT-SECRET";

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
        $this->controllerFunction = new PublicControllerFunction();
    }

    /**
     * go to PayPal client transaction page
     */
    public function payment(Request $request)
    {
        $pay_information = $this->get_paynent_information($request);
        if (!$pay_information) abort(401,'Parameters is invalid!');
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = array(
            "intent" => "CAPTURE",
            "purchase_units" => array(
                array(
                    "reference_id" => $current_user->user_profileid . '_' . time(),
                    "amount" => array(
                        "value" => $pay_information['price'],
                        "currency_code" => $pay_information['currency']
                    )
                ),
            ),
            "application_context" => array(
                "cancel_url" => url('/payment/cancel'),
                "return_url" => url('/payment/return')
            )
        );

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);
            $redirect_url = $response->result->links[1]->href;

            $item = new \App\Transaction();
            $item->user_profileid = $current_user->user_profileid;
            $item->transaction_name = $pay_information['name'];
            $item->orderid = $response->result->id;
            $item->status = 'pending';
            $item->price = $pay_information['price'];
            $item->save();
            return redirect()->to($redirect_url);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }

    /**
     * Returns PayPal HTTP client to success transaction
     */
    public function return(Request $request)
    {
        $_request = new OrdersCaptureRequest($request->token); //"APPROVED-ORDER-ID"
        $_request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($_request);
            $transactionid = $response->result->purchase_units[0]->payments->captures[0]->id;
            $status = $response->result->purchase_units[0]->payments->captures[0]->status;

            /* save Transaction */
            $item = \App\Transaction::where('orderid', $response->result->id)->first() ?? abort(404);
            $item->paypal_transactionid = $transactionid;
            $item->status = $status;
            $item->paypal_description = json_encode($response);
            $item->save();

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            $response_accept = $this->update_transaction_payment($item->transaction_name, $status);
            
            if ($response_accept){
                return redirect()->to('/all-project');
            }
            else{
                abort(500,'Wrong to payment!');
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }

    /**
     * Returns PayPal HTTP client to cancel transaction
     */
    public function cancel()
    {
        dd('Cancel');
    }

    /**
     * get PayPal request array
     */
    public function get_paynent_information($request)
    {
        $response = false;
        if ($request->milestonid && $request->bid_id) {
            $project_payment = new ProjectDetailController();
            $response = $project_payment->payment_milestone($request);
        }
        return $response;
    }

    /**
     * update transaction payment information
     */
    public function update_transaction_payment($transaction_name, $status)
    {
        $response = false;
        if ($status == 'COMPLETED') {
            $project_payment = new ProjectDetailController();
            $response = $project_payment->payment_accepted($transaction_name);
        }
        else{
            abort(500,'Wrong to payment!');
        }
        return $response;
    }
}
