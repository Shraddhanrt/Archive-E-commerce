<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Notification;
use App\Models\Order;
use DB;
use Mail;

class PayPalController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        $totalcost = Order::where('code', Session::get('cartcode'))->limit(1)->first();
        

        $amount1 = $totalcost->grandtotal;
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('MYR')
            ->setQuantity(1)
            ->setPrice($amount1); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('MYR')
            ->setTotal($amount1);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description111111111');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('paypal/status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('paypal/status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');

    }

    public function getPaymentStatus()
    {
        
        $request=request();//try get from method
        

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        //if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        if (empty($request->PayerID) || empty($request->token)) {

            Session::put('error', 'Payment failed');
            dd('payment failed');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        //$execution->setPayerId(Input::get('PayerID'));
        $execution->setPayerId($request->PayerID);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            Session::put('success', 'Payment success');
            $code22 = Session::get('cartcode');
            //add update record for cart

            DB::table('orders')
                ->where('code', $code22)
                ->limit(1)
                ->update(array(
                    'paymentstatus' => 'Y',
                    'payerid'=>$request->paymentId
                ));

                // sending email
			$order1 = Order::where('code', $code22)->limit(1)->first();
            if($order1->coupon_id != Null){
                $checkcoupon = Coupon::where('id', $order1->coupon_id)->limit(1)->first();
                if($checkcoupon->onetime == 'Y'){
                    DB::table('coupons')
                        ->where('id', $order1->coupon_id)
                        ->update([
                            'status'=> 'N'
                        ]);
                }
            }
			 
			 $data = [
				'fname' =>$order1->buyer_lname,
				'code' =>$order1->code,
				'totalcost'=> $order1->grandtotal,
				'paymentmethod'=>$order1->paymentmethod
			  ];
	  
			  //send mail to buyer
			  \Mail::to($order1->buyer_email)->send(new \App\Mail\Mail($data));

			  //send mail to owner
			  \Mail::to('ishworchalise@gmail.com')->send(new \App\Mail\Mail1($data));
            Session::forget('cartcode');
           return redirect()->route('getCodSuccessStatus', $code22);  //back to product page

        }

        Session::put('error', 'Payment failed');
        dd('order failed');

    }


}
