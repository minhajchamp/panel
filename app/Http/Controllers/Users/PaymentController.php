<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceEmail;
use Illuminate\Http\Request;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentMethods;
use App\Models\User;
use App\Models\Brands;
use App\Models\Clients;
use App\Models\SMTPSettings;
use Mail;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    const BASE_URL = 'https://api.stripe.com';
    const SECRET_KEY = 'sk_test_51LN1ReAR94nIP5zpkqkZePTpslQD8qzEZyyM3LxI2S9Ky4xfN8nFfIt4NwiVTDZy1lrZVmfcXIUIIpse9chSL4g600dqxT1pYT';


    public function create()
    {
        $clients = User::where('role_id', 2)->get();
        $brands = Brands::where('brand_status', 1)->get();
        $payment_methods = PaymentMethods::where('method_status', 1)->get();
        return view('admin.payment.add', with(compact('payment_methods', 'clients', 'brands')));
    }

    public function create_payment_link(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|string|max:50',
            'brands' => 'required',
            'clients' => 'required',
            'payment_methods' => 'required',
            'email' => 'required',
            'user_currency' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)
                ->withInput();
        }

        $smtp_data  = SMTPSettings::where('brand_id', $request->brands)->first();
        $brands     = Brands::where('id', $request->brands)->first();
        $get_client = User::where('id', $request->clients)
            ->where('brand_id', $request->brands)
            ->first();
        $email_from = $smtp_data->smtp_from_address ?? "info@bytrix.com";
        dd($smtp_data);
        if ($smtp_data->count() > 0) {

            config(['mail.driver' => $smtp_data->smtp_driver]); //works.
            config(['mail.host' => $smtp_data->smtp_host]);
            config(['mail.port' => $smtp_data->smtp_port]);
            config(['mail.username' => $smtp_data->smtp_username]);
            config(['mail.password' => $smtp_data->smtp_password]);
            config(['mail.encryption' => $smtp_data->smtp_encryption]);
            config(['mail.from.address' => $smtp_data->smtp_from_address]);
        } else {

            config(['mail.driver' => 'smtp']); //works.
            config(['mail.host' => 'smtp.gmail.com']);
            config(['mail.port' => '587']);
            config(['mail.username' => 'minhaj123technado@gmail.com']);
            config(['mail.password' => 'pqgdkpgmlbhexnxj']);
            config(['mail.encryption' => 'tls']);
            config(['mail.from.address' => 'minhaj123technado@gmail.com']);
        }
        // $name = 'Cloudways';
        // $to_name = 'RECEIVER_NAME';
        // $to_email = 'RECEIVER_EMAIL_ADDRESS';
        // $data = array('name' => 'Cloudways (sender_name)', 'body' => 'A test mail');

        // Mail::send('admin.emails.invoice_admin', $data, function ($message) use ($to_name, $to_email) {
        //     $message->to('minhaj@bytrix.com', 'ss')
        //         ->subject('Laravel Test Mail');
        // });
        // config(['mail.driver'=>'smtp']); //works.
        // config(['mail.host'=>'mail.app.bytrix.com']);
        // config(['mail.port'=>'465']);
        // config(['mail.username'=>'tesla@app.bytrix.com']);
        // config(['mail.password'=>'pqgdkpgmlbhexnxj']);
        // config(['mail.encryption'=>'tls']);
        // config(['mail.from.address'=>'tesla@app.bytrix.com']); 
        try {
            Mail::to($get_client->email)->send(new InvoiceEmail($email_from));
            DB::beginTransaction();
            $token = substr(md5(uniqid($get_client->email)), 0, 12);
            DB::table('invoice')->upsert([
                [
                    'invoice_token' => $token,
                    'invoice_sent_cl' => 1,
                    'invoice_sent_emp' => 1,
                    'invoice_is_seen' => 0,
                    'invoice_status' => 'unpaid',
                    'invoice_sent_at' => date('Y-m-d h:i:s'),
                    'invoice_details' => ''
                ],
            ], ['invoice_token', 'payment_id']);
            DB::commit();
            return redirect()->back()->with('success', "Payment Link Created and Sent");
        } catch (\Exception $ex) {
            return redirect()->back()->with('danger', $ex->getMessage());
        }
    }

    public function get_clients($brand_id)
    {
        $users = User::where('brand_id', $brand_id)->get();
        return response()->json($users);
    }

    public function get_client($client_id)
    {
        $users = User::where('id', $client_id)->first();
        return response()->json($users);
    }

    /**
     * show payment page
     *
     * @return void
     */
    public function form()
    {
        return view('payment.show');
    }
    /**
     * submit payment page
     *
     * @return void
     */
    public function submit(Request $request)
    {
        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'line1' => 'required',
            'postal_code' => 'required',
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'amount' => 'required',
            'currency' => 'required',
        ]);

        $input['transaction_id'] = \Str::random(18); // random string for transaction id

        // save to database
        // it is recomended to save before sending data to stripe server
        // so we can verify after return from 3ds page
        // \DB::table('transactions')
        //     ->insert($input);

        // create payment method request
        // see documentation below for options
        // https://stripe.com/docs/api/payment_methods/create
        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][city]' => $input['city'],
            'billing_details[address][state]' => $input['state'],
            'billing_details[address][country]' => $input['country'],
            'billing_details[address][line1]' => $input['line1'],
            'billing_details[address][postal_code]' => $input['postal_code'],
            'billing_details[email]' => $input['email'],
            'billing_details[name]' => $input['first_name'] . ' ' . $input['last_name'],
            'billing_details[phone]' => $input['phone'],
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::SECRET_KEY
        ];

        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);

        // create payment intent request if payment method response contains id
        // see below documentation for options
        // https://stripe.com/docs/api/payment_intents/create
        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $input['amount'] * 100, // multiply amount with 100
                'currency' => $input['currency'],
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('stripeResponse', $input['transaction_id']),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::SECRET_KEY
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('stripeResponse', $input['transaction_id'])->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('stripeResponse', $input['transaction_id'])->with('error', $response_data['error']['message']);
            } else {

                return redirect()->route('stripeResponse', $input['transaction_id'])->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('stripeResponse', $input['transaction_id'])->with('error', $payment_response['error']['message']);
        }
    }

    /**
     * create curl request
     * we have created seperate method for curl request
     * instead of put code at every request
     *
     * @return Stripe response
     */
    private function curlPost($url, $data, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * response from 3ds page
     *
     * @return Stripe response
     */
    public function response(Request $request, $transaction_id)
    {
        $request_data = $request->all();

        // if only stripe response contains payment_intent
        if (isset($request_data['payment_intent']) && $request_data['payment_intent'] != null) {

            // here we will check status of the transaction with payment_intents from stripe server
            $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];

            $get_headers = [
                'Authorization: Bearer ' . self::SECRET_KEY
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $get_response = curl_exec($ch);

            curl_close($ch);

            $get_data = json_decode($get_response, 1);

            // get record of transaction from database
            // so we can verify with response and update the transaction status
            // $input = \DB::table('transactions')
            //     ->where('transaction_id', $transaction_id)
            //     ->first();

            // here you can check amount, currency etc with $get_data
            // which you can check with your database record
            // for example amount value check
            if ($input['amount'] * 100 == $get_data['amount']) {
                // nothing to do
            } else {
                // something wrong has done with amount
            }

            // succeeded means transaction success
            if (isset($get_data['status']) && $get_data['status'] == 'succeeded') {

                return view('payment.show')->with('success', 'Payment success.');

                // update here transaction for record something like this
                // $input = \DB::table('transactions')
                //     ->where('transaction_id', $transaction_id)
                //     ->update(['status' => 'success']);

            } elseif (isset($get_data['error']['message']) && $get_data['error']['message'] != null) {

                return view('payment.show')->with('error', $get_data['error']['message']);
            } else {

                return view('payment.show')->with('error', 'Payment request failed.');
            }
        } else {

            return view('payment.show')->with('error', 'Payment request failed.');
        }
    }
}
