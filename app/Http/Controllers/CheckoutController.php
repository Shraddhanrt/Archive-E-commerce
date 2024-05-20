<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Country;
use App\Models\State;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ShippingCostCalculate;
use App\Models\Coupon;
use Session;
use DB;

class CheckoutController extends Controller
{
    public function getCheckOut(){
        if(Session::get('cartcode'))
        {
            if(auth()->guard('customer')->check())
            {
                $customer = Customer::where('id',auth()->guard('customer')->user()->id)->limit(1)->first();
                // dd($customer->sstate);
                if($customer->address != NULL AND $customer->country != NULL AND $customer->state != NULL AND $customer->city != NULL AND $customer->postalcode != NULL AND $customer->saddress != NULL AND $customer->scountry != NULL AND $customer->sstate != NULL AND $customer->scity != NULL AND $customer->spostal != NULL AND $customer->smobile != NULL ){
                    //dd($customer);
                    
                    if(auth()->guard('customer')->check())
                {
                    $customer = Customer::where('id', auth()->guard('customer')->user()->id)->limit(1)->first();
                    $postalcode = $customer->spostal;
                    $send_state = $customer->sstate;
                    $send_country =$customer->scountry;
                }
                else
                {
                    $postalcode = Session::get('shipping.postalcode');
                    $send_state =Session::get('shipping.state');
                    $send_country =Session::get('shipping.country');
                }
                $check = Cart::where('code',Session::get('cartcode'))->count();
                $checkFreeShippingCount = Cart::where('code',Session::get('cartcode'))->where('shippingfree', 'Y')->get();
                $checkPaidShippingCount = Cart::where('code',Session::get('cartcode'))->where('shippingfree', 'N')->get();
                if($check == 0){
                    dd('your cart was empty! Go back and select any product(s).');
                }

               if($checkFreeShippingCount->count()){
                    if($checkPaidShippingCount->count()){
                        $shippers1 = ShippingCostCalculate::getEasyParsals($postalcode, $send_state, $send_country, Session::get('cartcode'));
                        
                        if($shippers1 == ''){
                            $shippers = "<option value='0?0?0?0?0?0'>Unable be shipped to your location</option>";
                            $checkout = 'N';
                        }
                        else{
                            $shippers = $shippers1;
                            $checkout = 'Y';
                        }
                    }
                    else{
                        $shippers = "<option value='0?0?0?0?0?0'>Free Shipping</option>";
                        $checkout = 'Y';
                    }
               }
               else{
                    $shippers1 = ShippingCostCalculate::getEasyParsals($postalcode, $send_state, $send_country, Session::get('cartcode'));
                        
                        if($shippers1 == ''){
                            $shippers = "<option value='0?0?0?0?0?0'>Unable be shipped to your location</option>";
                            $checkout = 'N';
                        }
                        else{
                            $shippers = $shippers1;
                            $checkout = 'Y';
                        }
               }
                
                
                if($check != 0)

                {
                    $data=[
                        'countries' => Country::all(),
                        'states' => State::all(),
                        'shippers' => $shippers,
                        'checkout' => $checkout
                    ];
                    return view('site.checkout', $data);
                }
                else
                {
                return redirect()->route('getHome');
                
                }
                }
                else{
                    return redirect()->route('getBuyerInformationEdit')->with('status', 'Please check & comfirm your buyer/shipping information before checkout.');
                }
            }
            else
            {
                return redirect()->route('postCustomerLogin');
            }
        }
        else
        {
            return abort(404);
        }
    }
    public function postCheckOut(Request $request){
      
        if(Session::get('cartcode')){
            if(auth()->guard('customer')->check()){
                $customer = Customer::where('id', Auth()->guard('customer')->user()->id)->limit(1)->first();
                
                $total_weight = Cart::where('code', Session::get('cartcode'))->sum('weight');
                $totalcost = Cart::where('code', Session::get('cartcode'))->sum('totalcost');
                $tax = 0;
                $parsalcost = $request->parsalcost;
                $coupon = $request->input('couponcode');
                if($customer->agent == 'N'){
                    if($coupon){
                        $checkcoupon = Coupon::where('code', $coupon)->where('status', 'Y')->limit(1)->first();
                        if($checkcoupon){
                           
                            if($checkcoupon->status = 'Y'){
                                
                                if($checkcoupon->expiry >= date('Y-m-d')){
                                    if($checkcoupon->min_cost_apply == 0){
                                        if($checkcoupon->amounttype == 'percentage'){
                                            $discount_amount = $totalcost*($checkcoupon->amount/100);
                                            $discount_type = 'Promo Code Discount';
                                            $coupon_id = $checkcoupon->id;
                                        }
                                        else{
                                            $discount_amount = $checkcoupon->amount;
                                            $discount_type = 'Promo Code Discount';
                                            $coupon_id = $checkcoupon->id;
                                        }
                                    }
                                    else{
                                        if($checkcoupon->min_cost_apply < $totalcost){
                                            if($checkcoupon->amounttype == 'percentage'){
                                                $discount_amount = $totalcost*($checkcoupon->amount/100);
                                                $discount_type = 'Promo Code Discount';
                                                $coupon_id = $checkcoupon->id;
                                            }
                                            else{
                                                $discount_amount = $checkcoupon->amount;
                                                $discount_type = 'Promo Code Discount';
                                                $coupon_id = $checkcoupon->id;
                                            }
                                        }
                                        else{
                                            
                                            $discount_amount = 0;
                                            $discount_type = Null;
                                            $coupon_id = Null;
                                        }
                                    }
                                   
                                }
                                else{
                                $discount_amount = 0;
                                $discount_type = Null;
                                $coupon_id = Null;
                                }
                                
                                
                            }
                            else{
                                $discount_amount = 0;
                                $discount_type = Null;
                                $coupon_id = Null;
                            }
                        }
                        else{
                            $discount_amount = 0;
                            $discount_type = Null;
                            $coupon_id = Null; 
                        }
                    }
                    else{
                        $discount_amount = 0;
                        $discount_type = Null;
                        $coupon_id = Null;
                    }
                }
                else{
                    $discount = $customer->discount;
                    $discount_amount = $totalcost*($discount/100);
                    $discount_type = 'Agent Discount';
                    $coupon_id = Null;

                }

            $grandtotal = ($totalcost+$tax+$parsalcost)-$discount_amount;

            $ordercheck = Order::where('code', Session::get('cartcode'))->count();

            if($ordercheck == 0){
                
                $order = New Order;
                $order->customer_id = Auth()->guard('customer')->user()->id;
                $order->buyer_fname = $customer->fname;
                $order->buyer_lname = $customer->lname;
                $order->buyer_address = $customer->address;
                $order->buyer_address1 = $customer->address2;
                $order->buyer_state = $customer->state;
                $order->buyer_country = $customer->country;
                $order->buyer_city = $customer->city;
                $order->buyer_postal_code = $customer->postalcode;
                $order->buyer_mobile = $customer->mobile;
                $order->buyer_email = $customer->email;
                $order->receiver_fname = $customer->sfname;
                $order->receiver_lname = $customer->slname;
                $order->receiver_address = $customer->saddress;
                $order->receiver_address1 = $customer->saddress2;
                $order->receiver_state = $customer->sstate;
                $order->receiver_country = $customer->scountry;
                $order->receiver_city = $customer->scity;
                $order->receiver_postal_code = $customer->spostal;
                $order->receiver_mobile = $customer->smobile;
                $order->code = Session::get('cartcode');
                $order->producttotalweight = $total_weight;
                $order->producttotalcost = $totalcost;
                $order->tax = $tax;
                $order->shippingcost = $parsalcost;
                $order->discount = $discount_amount;
                $order->discount_type = $discount_type;
                $order->coupon_id = $coupon_id;
                $order->grandtotal = $grandtotal;
                $order->shippingcompany = $request->couriername;
                $order->shippingcompanylogo = $request->courierlogo;
                $order->delivery_range = $request->delivery;
                $order->service_id = $request->serviceid;
                $order->pointid = $request->pointid;
                $order->paymentmethod = $request->input('paymentmethod');
                $order->save();
            }
            else{
                //if Promo have check validaty
                $order2 = Order::where('code', Session::get('cartcode'))->limit(1)->first();
                if($order2->coupon_id){
                    
                    $couponcheck1 = Coupon::where('id', $order2->coupon_id)->limit(1)->first();
                    
                    if($couponcheck1 >= date('Y-m-d')){
                        DB::table('orders')
                        ->where('code', Session::get('cartcode'))
                        ->update([
                            'buyer_fname' => $customer->fname,
                            'buyer_lname' => $customer->lname,
                            'buyer_address' => $customer->address,
                            'buyer_address1' => $customer->address2,
                            'buyer_state' => $customer->state,
                            'buyer_country' => $customer->country,
                            'buyer_city' => $customer->city,
                            'buyer_postal_code' => $customer->postalcode,
                            'buyer_mobile' => $customer->mobile,
                            'buyer_email' => $customer->email,
                            'receiver_fname' => $customer->sfname,
                            'receiver_lname' => $customer->slname,
                            'receiver_address' => $customer->saddress,
                            'receiver_address1' => $customer->saddress2,
                            'receiver_state' => $customer->sstate,
                            'receiver_country' => $customer->scountry,
                            'receiver_city' => $customer->scity,
                            'receiver_postal_code' => $customer->spostal,
                            'receiver_mobile' => $customer->smobile,
                            'producttotalweight' => $total_weight,
                            'producttotalcost' => $totalcost,
                            'tax' => $tax,
                            'shippingcost' => $parsalcost,
                            'discount' => $discount_amount,
                            'grandtotal' => $grandtotal,
                            'shippingcompany' => $request->couriername,
                            'shippingcompanylogo' => $request->courierlogo,
                            'delivery_range' => $request->delivery,
                            'service_id' => $request->serviceid,
                            'pointid' => $request->pointid,
                            'paymentmethod' => $request->input('paymentmethod'),
                        ]);
                    }
                    else{
                        dd('promo code exiprry');
                    }
                } 
            }
            return redirect()->route('getConfirm', Session::get('cartcode'));

            }
            else{
                return redirect()->route('getHome');
            }
        }
        else{
            return abort(404);
        }
    }
    public function getDirectBankTransfer(){
        $code = Session::get('cartcode');
        
        if(Session::get('cartcode')){
           
        $order = order::where('code', $code)->limit(1)->first();
        $data=[
            'order'=>$order
        ];
        // check coupon
        
        if($order->coupon_id != NULL){
            
            $checkcoupon = Coupon::where('id', $order->coupon_id)->limit(1)->first();
            
            if($checkcoupon->onetime == 'Y'){
               
                DB::table('coupons')
                        ->where('id', $order->coupon_id)
                        ->update([
                            'status'=> 'N'
                        ]);
            }
        }
        Session::forget('cartcode');
        return view('site.codorderstatus',$data);
    }
    else{
        abort('404');
    }
    }
}
