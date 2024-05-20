<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Country;
use App\Models\State;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;



class CustomerController extends Controller
{
    public function __construct()
    {
       if(!auth()->guard('customer')->check()){
           return redirect()->route('getCustomerLogin');
       }
        
    }
   
    public function getCustomerDashboard(){
        if(auth()->guard('customer')->check()){
        $data =[
            'customer' => Customer::where('id',Auth::guard('customer')->user()->id)->limit(1)->first(),
            'countries' => Country::all(),
            'states' => State::all()
        ];
        return view('customer.dashboard', $data);
        }
        else{
            return redirect()->route('getCustomerLogin');
        }
    }
    public function getCustomerOrderHistory(){
        if(auth()->guard('customer')->check()){
            $customer = Customer::where('id',Auth::guard('customer')->user()->id)->limit(1)->first();
        $data =[
            'orders'=>Order::where('customer_id', $customer->id)->get()
        ];
        return view('customer.orderhistory', $data);
        }
        else{
            return redirect()->route('getCustomerLogin');
        }
    }
    public function getOrderDetailAjax(Request $request){
        if(auth()->guard('customer')->check()){
        $codeid = $request->codeid;
        $order = Order::where('code', $codeid)->limit(1)->first();
        if($order->customer_id == Auth::guard('customer')->user()->id){
            $carts = Cart::where('code', $codeid)->get();
            $cartitems ='';
            $cartitems .= "
            <table width='100%' style='border-collapse: collapse;border-bottom:1px solid #eee;'>
                <tr>
                  <td width='40%' class='column-header'>Items(s)</td>
                  <td width='20%' class='column-header'>Cost</td>
                  <td width='20%' class='column-header'>Qty</td>
                  <td width='20%' class='column-header'>Amount</td>
                </tr>
            ";
            
            foreach($carts as $item){
                $product= Product::where('id', $item->product_id)->limit(1)->first();
                $cartitems .= "
                <tr><td class='row2'><span style='color:#777;font-size:11px;'>".$item->weight."kg</span><br>".$product->name."</td>
                    <td class='row2'>".$item->cost."</td>
                    <td class='row2'>".$item->qty."</td>
                    <td class='row2'>".$item->totalcost."</td>
                  </tr>
                ";
            }
            $cartitems .= "</table>";

            $costing = "
            <table width='100%' style='background:#eee;padding:20px;'>
                <tr>
                  <td>
                    <table width='300px' style='float:right'>
                      <tr>
                        <td><strong>Sub-total:</strong></td>
                        <td style='text-align:right'>MYR".$order->producttotalcost."</td>
                      </tr>  
                      <tr>
                        <td><strong>Shipping fee:</strong></td>    
                        <td style='text-align:right'>MYR".$order->shippingcost."</td>
                      </tr>
                      <tr>
                        <td><strong>Tax:</strong></td>    
                        <td style='text-align:right'>".$order->tax."</td>
                      </tr>
                      <tr>
                        <td><strong>Discount:</strong></td>    
                        <td style='text-align:right'>".$order->discount."</td>
                      </tr>
                      
                      <tr>
                        <td><strong>Grand total:</strong></td>    
                        <td style='text-align:right'>MYR".$order->grandtotal."</td>
                      </tr>
                    </table>
                   </td>
                </tr>
              </table>
            ";
            
            $data =[
                'order'=> $order,
                'carts'=> $cartitems,
                'costing'=>$costing
             ];
             return response($data);
        }
        else{
            dd('sdfds');
        }
    }
    else{
        return redirect()->route('getCustomerLogin');
    }

    }
    public function getCustomerProfile(){
        if(auth()->guard('customer')->check()){
        $data =[
            'customer' => Customer::where('id',Auth::guard('customer')->user()->id)->limit(1)->first()
        ];
        return view('customer.profile', $data);
        }
        else{
            return redirect()->route('getCustomerLogin');
        }
    }
    public function getBuyerInformationEdit(){
        if(auth()->guard('customer')->check()){
        $buyer = Customer::where('id', Auth::guard('customer')->user()->id)->limit(1)->first();
        if(Auth::guard('customer')->user()->id == $buyer->id){
            $data =[
            'customer' => $buyer,
            'countries' => Country::all(),
            'states' => State::all()
        ];
        return view('customer.buyeredit', $data);
        }
        else{
            return abort(404);
        }
    }
    else{
        return redirect()->route('getCustomerLogin');
    }
       
    }
    public function postEditBuyerInformation(Request $request){
        if(auth()->guard('customer')->check()){
        $buyer = Customer::where('id', Auth::guard('customer')->user()->id)->limit(1)->first();
        
        if($request->input('country') == '136'){
            $state = $request->input('state');
        }
        else{
            $state = $request->input('stateother');
        }
        DB::table('customers')
			->where('id', Auth::guard('customer')->user()->id)
			->update([
				'fname' => $request->input('firstname'),
				'lname' => $request->input('lastname'),
				'address' => $request->input('address'),
				'address2' => $request->input('address2'),
				'country' => $request->input('country'),
				'city' => $request->input('city'),
				'postalcode' => $request->input('postalcode'),
				'mobile' => $request->input('mobile'),
				'state' => $state
                ]);
                if($request->shippingaddresssame == 'on'){
                    DB::table('customers')
                        ->where('id', Auth::guard('customer')->user()->id)
                        ->update([
                        'sfname' => $request->input('firstname'),
                        'slname' => $request->input('lastname'),
                        'saddress' => $request->input('address'),
                        'saddress2' => $request->input('address2'),
                        'scountry' => $request->input('country'),
                        'scity' => $request->input('city'),
                        'spostal' => $request->input('postalcode'),
                        'smobile' => $request->input('mobile'),
                        'sstate' => $state
                        ]);
                }
                if($request->shippingaddresssame != 'on'){
                    return redirect()->route('getShippingInformationEdit')->with('status', 'Please update your Shipping Information.');
                }
                else{
                    if(Session::get('cartcode')){
                        return redirect()->route('getCart');
                    }
                    else{
                        return redirect()->route('getCustomerProfile')->with('status', 'Shipping Information updated!!!');
                    }
                    
                }
            }
            else{
                return redirect()->route('getCustomerLogin');
            }
        
    }
    public function getShippingInformationEdit(Request $request){
        if(auth()->guard('customer')->check()){
        $buyer = Customer::where('id', Auth::guard('customer')->user()->id)->limit(1)->first();
        if(Auth::guard('customer')->user()->id == $buyer->id){
            $data =[
            'customer' => $buyer,
            'countries' => Country::all(),
            'states' => State::all()
        ];
        return view('customer.shippingedit', $data);
        }
        else{
            return abort(404);
        }
    }
    else{
        return redirect()->route('getCustomerLogin');
    }
    }
    public function postEditShippingInformation(Request $request){
        if(auth()->guard('customer')->check()){
        //dd($request->input('sstateother'));
        $buyer = Customer::where('id', Auth::guard('customer')->user()->id)->limit(1)->first();
        if($request->input('country') == '136'){
            $state = $request->input('state');
        }
        else{
            $state = $request->input('stateother');
        }
        //dd($state);
        DB::table('customers')
			->where('id', Auth::guard('customer')->user()->id)
			->update([
				'sfname' => $request->input('firstname'),
				'slname' => $request->input('lastname'),
				'saddress' => $request->input('address'),
				'saddress2' => $request->input('address2'),
				'scountry' => $request->input('country'),
				'scity' => $request->input('city'),
				'spostal' => $request->input('postalcode'),
				'smobile' => $request->input('mobile'),
				'sstate' => $state
                ]);
        if($buyer->address == null AND $buyer->country == null AND $buyer->state == null AND $buyer->mobile == null AND $buyer->postalcode == null){
            return redirect()->route('getBuyerInformationEdit')->with('status', 'Please update your Buyer Information.');
        }
        else{
            return redirect()->route('getCustomerProfile')->with('status', 'Shipping Information updated!!!');
        }
    }
    else{
        return redirect()->route('getCustomerLogin');
    }
            
        
    }
    public function getCustomerpasswordChange(){
        if(auth()->guard('customer')->check()){
            return view('customer.passwordchange');
        }
        else{
            return redirect()->route('getCustomerLogin');
        }
    }
    public function postPasswordChange(Request $request){
        if(auth()->guard('customer')->check()){
        DB::table('customers')
			->where('id', Auth::guard('customer')->user()->id)
			->update([
                'password' =>Hash::make($request->input('password'))
                ]);
            return redirect()->back()->with('status', 'Password Changed!!');
        }
        else{
            return redirect()->route('getCustomerLogin');
        }

    }
    public function ajaxPostCheckCoupon(Request $request){
        $code = $request->input('code');
        $buying_amount = $request->input('totalcost11');

        $checkcode = Coupon::where('code', $code)->where('status', 'Y')->limit(1)->first();
        if($checkcode){
            if($checkcode->status == 'N'){
                $status = 'Promo Code Disable.';
                $msg ='';
                $codeamount = 0;
                $amounttype = 0;
                $min_cost_apply = $checkcode->min_cost_apply;
            }
            else{
                if($checkcode->expiry >= date('Y-m-d')){
                    $status = '';
                    $amounttype = $checkcode->amounttype;
                    $min_cost_apply = $checkcode->min_cost_apply;
                    if($amounttype == 'percentage'){
                        if($buying_amount >= $checkcode->min_cost_apply){
                            $codeamount = $checkcode->amount;
                            $msg = 'Promo Code Discount '.$codeamount.'%';
                            
                        }
                        else{
                            $msg = 'This Promo Code use only with min spend of RM'.$checkcode->min_cost_apply.'.';
                            $codeamount = 0;
                        }
                    }
                    else{
                        if($buying_amount >= $checkcode->min_cost_apply){
                            $codeamount = $checkcode->amount;
                            $msg = 'Promo code Discount MYR'.$codeamount;
                           
                        }
                        else{
                            $msg = 'This Promo Code use only with min spend of RM'.$checkcode->min_cost_apply.'.';
                            $codeamount = 0;
                        }
                    }
                }
                else{
                    $status = 'Promo Code expired.';
                    $codeamount = 0;
                    $amounttype = 'none';
                    $msg ='';
                    $min_cost_apply = $checkcode->min_cost_apply;
                }
            }
        }
        else{
            $status = 'Invalid Promo Code';
            $codeamount = 0;
            $amounttype = 'none';
            $msg ='';
            $min_cost_apply = 0;
        }
        return response()->json([
        'msg'=>$msg,
        'codeamount'=>$codeamount,
        'amounttype' =>$amounttype,
        'status' =>$status,
        'min_cost_apply' => $min_cost_apply
        ]);
        
    }
}
