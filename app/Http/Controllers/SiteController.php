<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Product;
use App\Models\Cart;
use GuzzleHttp\Client;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Dietplan;
use App\Models\Policy;
use App\Models\Shipping;
use App\Models\Country;
use App\Models\State;
use App\Models\Newsletter;
use App\Models\Customer;
use App\Models\Banner;
use App\Models\ShippingCostCalculate;
use App\Models\Coupon;
use App\Models\Slider;
use Mail;
use Auth;
use Carbon;
use URL;

class SiteController extends Controller
{
    public function getHome(){
        $data =[
        	'products' =>Product::where('active', 'Y')->get(),
			'testimonials'=>Testimonial::limit(5)->get(),
			'blogs' => Blog::all(),
			'banner'=> Banner::limit(1)->first(),
			'sliders' => Slider::all()
			
        ];
        return view('site.home', $data);
    }

	public function getStory(){
		return view('site.story');
	}
	public function getContact(){
		return view('site.contact');
	}
	public function getProducts(){
		$data =[
			'products'=>Product::where('active', 'Y')->get()
		];
		return view('site.products', $data);
	}
    public function getProductDetail($slug){
        $data =[
            'product'=>Product::where('slug', $slug)->limit(1)->first()
        ];
        return view('site.productdetail', $data);
    }

    public function postAddToCart(Request $request){
        $productid = $request->input('product_id');
    	$qty = $request->input('qty');
		
    	$product = Product::where('id', $productid)->limit(1)->first();
    	if($product->dcost == null){
    		$cost = $product->acost;
    	}
    	else{
    		$cost = $product->dcost;
    	}
		if($product->shippingfree == 'Y'){
			$shippingfree = 'Y';
		}
		else{
			$shippingfree = 'N';
		}
    	if(Session::get('cartcode')){
    		$cart_code = Session::get('cartcode');
			// check product alreay added or not
			$check = Cart::where('code', Session::get('cartcode'))->where('product_id', $productid)->count();
			
			if($check == 0){
    			DB::table('carts')->insert(
     				array(
            			'code'     =>   $cart_code,
            			'product_id'   =>   $productid,
            			'cost'   =>   $cost,
            			'qty'   =>   $qty,
						'weight' => $product->weight*$qty,
            			'totalcost'   => $qty*$cost,
            			'shippingfree' => $shippingfree
     					)
				);
			}
			else{
				return redirect()->route('getCart')->with('message', 'This item already added in your cart!');	
			}
    	}
    	else{
    		$cart_code = Str::random(5);

    		$cart = New Cart;
    		$cart->code= $cart_code;
    		$cart->product_id = $productid;
    		$cart->cost = $cost;
    		$cart->qty = $qty;
			$cart->weight = $product->weight*$qty;
    		$cart->totalcost = $qty*$cost;
			$cart->shippingfree = $shippingfree;
    		$cart->save();
    		Session::put('cartcode', $cart_code);
    	}
    	return redirect()->route('getCart');
        
    }

public function getCart(){
	
	$data =[
		'countries'=>Country::all(),
		'states' =>State::all()
	];

    return view('site.cart', $data);
	
}
public function postCheckOut(){
	if(Session::get('cartcode')){
		if(Session::get('shipping')){
		$check = Cart::where('code',Session::get('cartcode'))->count();
		if($check != 0){
			$country = Session::get('shipping')['country'];
			$state = Session::get('shipping')['state'];
			$city = Session::get('shipping')['city'];
			$postalcode = Session::get('shipping')['postalcode'];
			$cartcode = Session::get('cartcode');
			
			// get list of coriyar 
			$getShippingCosts = ShippingCostCalculate::getEasyParsals($postalcode, $state, $country, $cartcode);
			// dd($getShippingCosts);
			$data =[
				'shippers'=>$getShippingCosts,
				'countries'=>Country::all(),
				'states'=>State::all()
			];
			// dd($data);
			// $json->result[0]->rates[0]->shipment_price;
			return view('site.checkout', $data);
		}
		else{
			return abort(404);
		}
	}
	else{
		return redirect()->route('getCart')->with('status', 'Update your shipping address before checkout!');
	}
	}
    
}
public function getDeleteCart($cart){
	if(Session::get('cartcode')){
		$cartcheck = Cart::where('id', $cart)->where('code',Session::get('cartcode'))->count();
		if($cartcheck == 0){
			return abort(404);
		}
		else{
			DB::table('carts')->where('id', $cart)->delete();
			return redirect()->back()->with('message', 'Item removed from cart successfully!');
		}
	}
	else{
		return abort(404);
	}
}
public function postCheckOutTest(Request $request){
if(Session::get('cartcode') AND Session::get('shipping')){

			$buyer_fname = $request->input('bfirstname');
			$buyer_lname = $request->input('blastname');
			$buyer_address = $request->input('baddress');
			$buyer_address1 = $request->input('baddress1');
			$buyer_country = $request->input('bcountry');
				if($buyer_country == '136'){
					$buyer_state = $request->input('bstate');
				}
				else{
					$buyer_state = $request->input('bstateother');
				}
			$buyer_city = $request->input('bcity');
			$buyer_postalcode = $request->input('bpostalcode');
			$buyer_mobile = $request->input('bmobile');
			$buyer_email = $request->input('bemail');

			$receiver_fname = $request->input('firstname');
			$receiver_lname = $request->input('lastname');
			$receiver_address = $request->input('address');
			$receiver_address1 = $request->input('address1');
			$receiver_country = session()->get('shipping')['country'];
			$receiver_state = session()->get('shipping')['state'];
			$receiver_city = session()->get('shipping')['city'];
			$receiver_postalcode = session()->get('shipping')['postalcode'];
			$receiver_mobile = $request->input('mobile');

			$total_weight = Cart::where('code', Session::get('cartcode'))->sum('weight');
			$parsal_service_id = $request->input('serviceid');
			$parsalcost = $request->input('parsalcost');
			$couriername = $request->input('couriername');
			$delivery = $request->input('delivery');
			$courierlogo = $request->input('courierlogo');
			$pointid = $request->input('pointid');
			

	
	
if($parsalcost != 0){


	 
	// calculate cost
	$tax = 0;
	$totalcost = Cart::where('code',Session::get('cartcode'))->sum('totalcost');
	$grandtotal = $tax+$totalcost+$parsalcost;
	// check order already exist or not
	$ordercheck = Order::where('code', Session::get('cartcode'))->count();
	if($ordercheck == 0){
		$order = New Order;
		$order->buyer_fname = $buyer_fname;
		$order->buyer_lname = $buyer_lname;
		$order->buyer_address = $buyer_address;
		$order->buyer_address1 = $buyer_address;
		$order->buyer_state = $buyer_state;
		$order->buyer_country = $buyer_country;
		$order->buyer_city = $buyer_city;
		$order->buyer_postal_code = $buyer_postalcode;
		$order->buyer_mobile = $buyer_mobile;
		$order->buyer_email = $buyer_email;
		$order->receiver_fname = $receiver_fname;
		$order->receiver_lname = $receiver_lname;
		$order->receiver_address = $receiver_address;
		$order->receiver_address1 = $receiver_address1;
		$order->receiver_state = $receiver_state;
		$order->receiver_country = $receiver_country;
		$order->receiver_city = $receiver_city;
		$order->receiver_postal_code = $receiver_postalcode;
		$order->receiver_mobile = $receiver_mobile;
		$order->code = Session::get('cartcode');
		$order->producttotalweight = $total_weight;
		$order->producttotalcost = $totalcost;
		$order->tax = $tax;
		$order->shippingcost = $parsalcost;
		$order->grandtotal = $grandtotal;
		$order->shippingcompany = $couriername;
		$order->shippingcompanylogo = $courierlogo;
		$order->delivery_range = $delivery;
		$order->service_id = $parsal_service_id;
		$order->paymentmethod = $request->input('paymentmethod');
		$order->pointid = $request->input('pointid');
		$order->save();
	}
	else
	{
			DB::table('orders')
			->where('code', Session::get('cartcode'))
			->update([
				'buyer_fname' => $buyer_fname,
				'buyer_lname' => $buyer_lname,
				'buyer_address' => $buyer_address,
				'buyer_address1' => $buyer_address1,
				'buyer_state' => $buyer_state,
				'buyer_country' => $buyer_country,
				'buyer_city' => $buyer_city,
				'buyer_postal_code' => $buyer_postalcode,
				'buyer_mobile' => $buyer_mobile,
				'buyer_email' => $buyer_email,
				'receiver_fname' => $receiver_fname,
				'receiver_lname' => $receiver_lname,
				'receiver_address' => $receiver_address,
				'receiver_address1' => $receiver_address1,
				'receiver_state' => $receiver_state,
				'receiver_country' => $receiver_country,
				'receiver_city' => $receiver_city,
				'receiver_postal_code' => $receiver_postalcode,
				'receiver_mobile' => $receiver_mobile,
				'producttotalweight' => $total_weight,
				'producttotalcost' => $totalcost,
				'tax' => $tax,
				'shippingcost' => $parsalcost,
				'grandtotal' => $grandtotal,
				'shippingcompany' => $couriername,
				'shippingcompanylogo' =>$courierlogo,
				'delivery_range' => $delivery,
				'service_id' => $parsal_service_id,
				'paymentmethod' => $request->input('paymentmethod'),
				'pointid' => $request->input('pointid'),

				]);
	}
	return redirect()->route('getConfirm', Session::get('cartcode'));	
}
else{
	dd('shipping error');
}
}
else{
	return abort(404);
}




}
public function getConfirm($cart, Request $request){
	
	if(auth()->guard('customer')->check())
	{
		$check = Order::where('code', $cart)->where('customer_id',Auth::guard('customer')->user()->id)->get();
		
		
		if($check->count())
		{
			if($request->get('type') == 'email' || $request->get('type') == 'laterpay')
			{
			
				$order = Order::where('code', $request->get('order'))->limit(1)->first();
				Session::put('cartcode', $request->get('order'));
			}
			$order = Order::where('code', $cart)->limit(1)->first();
			
			if($order->paymentstatus == 'N')
			{
				if($order->coupon_id){
					$checkcoupon = Coupon::where('id', $order->coupon_id)->limit(1)->first();
					if($checkcoupon->expiry >= date('Y-m-d')){
						$data = [
							'order' =>Order::where('code', $cart)->limit(1)->first(),
							'carts' =>Cart::where('code', $cart)->get()
						];
						return view('site.confirm', $data);
					}
					else{
						dd('Promo Code Expired');
					}
				}
				else{
					$data = [
						'order' =>Order::where('code', $cart)->limit(1)->first(),
						'carts' =>Cart::where('code', $cart)->get()
					];
					return view('site.confirm', $data);
				}

			}
			else
			{
				dd('already paid');
			}
			
		}
		else{
			return abort(404);
			
		}
	}
	else{
		if($request->get('type') == 'email'){
		$makereturnurl = URL::full();
		//dd($makereturnurl);
		return redirect()->route('getCustomerLogin', 'returnurl='.$makereturnurl);
		}
		else{
		return redirect()->route('getCustomerLogin');
		}
	}
}

public function getSenangpayStatus(Request $request){
   
	if(Session::get('cartcode')){
		if(env('SENANGPAY_MODE') == 'LIVE'){
			$secretkey = env('SENANGPAY_LIVE_SECRETKEY');
		}
		else{
			$secretkey = env('SENANGPAY_SANDBOX_SECRETKEY');
		}
		$status_id = $request->status_id;
		$order_id = $request->order_id;
		$transaction_id= $request->transaction_id;
		$msg = $request->msg;
		$hash = $request->hash;
		$cartcode = Session::get('cartcode');
		$str = $secretkey.''.$status_id.''.$order_id.''.$transaction_id.''.$msg;
		
		$hashed_string = hash_hmac('SHA256', $str, $secretkey);
		if($hashed_string == $hash){
			if(urldecode($request->status_id) == '1'){
			   
				DB::table('orders')
					->where('code', $cartcode)
					->update([
						'paymentstatus'=> 'Y',
						'updated_at' => date('Y-m-d'),
						'payerid' => $transaction_id
					]);
				
				// sending email
				$order1 = Order::where('code', $cartcode)->limit(1)->first();

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

				if(env('RECIEVER_EMAIL_MODE') == 'LIVE'){
					$rmail = env('RECIEVER_EMAIL_LIVE');
					$data = [
					'fname' =>$order1->buyer_fname,
					'code' =>$order1->code,
					'totalcost'=> $order1->grandtotal,
					'paymentmethod'=>$order1->paymentmethod
				];
		
				//send mail to buyer
				\Mail::to($order1->buyer_email)->send(new \App\Mail\Mail($data));

				//send mail to owner
				\Mail::to($rmail)->send(new \App\Mail\Mail1($data));
				}
				else{
					$rmail = env('RECIEVER_EMAIL_SANDBOX');
				}
				
				
					
				Session::forget('cartcode');
				return redirect()->route('getOrderStatus', $cartcode)->with('message', 'Thank you for your order!');
			}
			else{
			    
				return redirect()->route('getOrderStatus', $cartcode)->with('message', 'Payment unsuccessful! Please try again. Error Code 000');
			}
		}
		else{
		    
			return redirect()->route('getOrderStatus', $cartcode)->with('message', 'Your payment did not go through! Please try a different payment method or try again later. Error Code 001');
		}
	}
	else{
		return redirect()->route('getCancelPayment');
	}
}
public function getCancelPayment(){
 
    return view('site.paymentcancel');
}
public function getSenangpayCallBack(Request $request){
	if(env('SENANGPAY_MODE') == 'LIVE'){
		$secretkey = env('SENANGPAY_LIVE_SECRETKEY');
	}
	else{
		$secretkey = env('SENANGPAY_SANDBOX_SECRETKEY');
	}
	$status_id = $request->status_id;
	$order_id = $request->order_id;
	$transaction_id= $request->transaction_id;
	$msg = $request->msg;
	$hash = $request->hash;
	// $cartcode = Session::get('cartcode');
	$str = $secretkey.''.$status_id.''.$order_id.''.$transaction_id.''.$msg;
	$hashed_string = hash_hmac('SHA256', $str, $secretkey);

	if($hashed_string == $hash){
		if(urldecode($request->status_id) == '1'){
			$orderID = explode('-', $order_id);
			 DB::table('orders')->where('code', $orderID[0])->update(['paymentstatus'=> 'Y', 'updated_at' => date('Y-m-d'), 'payerid' => $transaction_id]);
			 return 'OK';
		}
	}
		
		
}
public function getOrderStatus($cart){
    dd('hellow');
	if(auth()->guard('customer')->check()){
		$order = Order::where('code', $cart)->limit(1)->first();
	if(auth()->guard('customer')->user()->id == $order->customer_id){
	$data =[
		'order'=>$order
	];
	return view('site.orderstatus', $data);
	}
	else{
		return redirect()->route('getPermissionDenied');
	}
	}
	else{
		return redirect()->route('getCustomerLogin');
	}
}
public function getBlogDetail($slug){
	$data =[
		'blog' =>Blog::where('slug', $slug)->limit(1)->first(),
		'products' =>Product::where('active', 'Y')->get()
	];
	return view('site.blogdetail', $data);
	
}

public function getBlogs(){
	$data =[
		'blogs'=>Blog::where('type', 'B')->get()
	];
	return view('site.blogs', $data);
}
public function getNews(){
	$data =[
		'blogs'=>Blog::where('type', 'N')->get()
	];
	return view('site.news', $data);
}
public function getDietPlan(){
	$data =[
		'dietplans'=>Dietplan::all()
	];
	return view('site.dietplan', $data);
}
public function getTestimonials(){
	$data =[
	 'testimonials' => Testimonial::all(),
	 'products' => Product::where('active', 'Y')->get()
	];
	return view('site.testimonials', $data);
}
public function getFaq(){
	$data = [
		'g' => Faq::where('catagory', 'General Information')->get(),
		's' => Faq::where('catagory', 'Shipping Information')->get()
	];
	return view('site.faq', $data);
}
public function getPolicy($page){
	if($page == 'Return'){
		$title = 'Return & Refund Policy';
	}
	elseif($page == 'privacy'){
		$title = 'Privacy Policy';
	}
	else{
		$title = 'Terms & Conditions';
	}
	$data = [
		'page' => Policy::where('page', $page)->limit(1)->first(),
		'title' => $title
	];
	return view('site.policy', $data);
}
public function getAddtoCardSingle($product){
		
		$productid = $product;
    	$qty = 1;
		
		$product = Product::where('id', $productid)->limit(1)->first();
    	
    	if($product->dcost == null){
    		$cost = $product->acost;
    	}
    	else{
    		$cost = $product->dcost;
    	}
    	if(Session::get('cartcode')){
    		$cart_code = Session::get('cartcode');
			// check product alreay added or not
			$check = Cart::where('code', Session::get('cartcode'))->where('product_id', $productid)->count();
			if($check == 0){
    			DB::table('carts')->insert(
     				array(
            			'code'     =>   $cart_code,
            			'product_id'   =>   $productid,
            			'cost'   =>   $cost,
            			'qty'   =>   $qty,
            			'totalcost'   => $qty*$cost,
						'weight' => $product->weight,
						'shippingfree' => $product->shippingfree
     					)
				);
			}
			else{
				return redirect()->route('getCart')->with('message', 'This item already added in your cart!!!');	
			}
    	}
    	else{
    		$cart_code = Str::random(5);
    		$cart = New Cart;
    		$cart->code= $cart_code;
    		$cart->product_id = $productid;
    		$cart->cost = $cost;
    		$cart->qty = $qty;
    		$cart->totalcost =$qty*$cost;
			$cart->weight = $product->weight;
			$cart->shippingfree = $product->shippingfree;
    		$cart->save();
    		Session::put('cartcode', $cart_code);
    	}
    	return redirect()->route('getCart');
}
public function getCodSuccessStatus($cardcode){
	$data =[
		'order'=>Order::where('code', $cardcode)->limit(1)->first()
	];
	Session::forget('cartcode');
	return view('site.codorderstatus', $data);
}
public function getdisablepopup(){
	Session::put('newsletter', 'false');
	return redirect()->back();
}
public function getClearCarts(){
	Session::forget('cartcode');
	return redirect()->back();
}
public function getOrderConfirmInvoice($code){
	
	$data =[
		'order'=>Order::where('code', $code)->limit(1)->first()
	];
	return view('site.invoice', $data);
}
public function postEditCart(Cart $cart, Request $request){
	if(Session::get('cartcode')){
		$code = Session::get('cartcode');
		$product = Product::where('id', $cart->product_id)->limit(1)->first();
		$qty = $request->input('qty');
		$productcost = $cart->cost;
		if($cart->code == $code){
			$cart->qty = $qty;
			$cart->totalcost = $qty*$productcost;
			$cart->weight = $product->weight*$qty;
			$cart->save();
			return redirect()->back()->with('message', 'Item Quantity Updated !');
		}
		else{
			return abort(404);
		}
	}
	else{
		return abort(404);
	}
	
}
public function postShiipingAddressToSession(Request $request){
	// dd($request->all());
	$ccountry = $request->input('ccountry');
	$cstate = $request->input('cstate');
	$otherstatebox = $request->input('stateother');
	$ccity = $request->input('ccity');
	$cpostalcode = $request->input('cpostalcode');
	if($ccountry == '136' AND $cstate =='' ){
		return redirect()->back()->with('vall', 'State missing');
	}
	if($ccountry == '136'){
		$state = $cstate;
	}
	else{
		$state = $otherstatebox;
	}
	
	
	Session::put('shipping', ['country' => $ccountry, 'state' => $state, 'postalcode' => $cpostalcode, 'city' => $ccity]);
	return redirect()->back();
	
	
}
public function postAddNewsLetter(Request $request){
	$email = $request->input('email');
	// dd($email);
	$newsletter = New Newsletter;
	$newsletter->email = $email;
	$newsletter->save();
	Session::put('newsletter', 'N');
	return response()->json(['success'=>'Form is successfully submitted!']);
	
}

public function getCustomerLogin(){
	if(!auth()->guard('customer')->check()){
		
	return view('site.login');
	}
	else{
		return redirect()->route('getCustomerDashboard');
	}
}
public function postCustomerregister(request $request){
	
	$validator = Validator::make($request->all(), [
		'email' => 'required|email|max:255|unique:customers',
		'password' => 'required|min:4',
		'mobile' => 'required|min:6',
	]);

	if ($validator->fails()) {
		return redirect()->back()->withErrors($validator);
	}

	$check = Customer::where('email', $request->email)->count();
	if($check >=1){
		return redirect()->back()->with('status', 'Email already exists!!!');
	}
	else{
	$customer = New Customer;
	$fname = $request->input('fname');
	$lname = $request->input('lname');
	$email = $request->input('email');
	$mobile = $request->input('mobile');
	$password = $request->input('password');
	$returnurl = $request->input('returnurl');
	
	$customer = New Customer;
	$customer->fname = $fname;
	$customer->lname = $lname;
	$customer->email = $email;
	$customer->mobile = $mobile;
	$customer->password = Hash::make($password);
	$customer->save();
	return redirect()->route($returnurl)->with('status', 'Account register successful, Please login here');
	}
	
}

public function postCustomerLogin(Request $request){
	
	if(Auth::guard('customer')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
		
		if($request->type == 'email'){
			
			return redirect()->to($request->returnurl.'&type=email');
			
		}
		else{
			if($request->returnurl == 'back'){
				return redirect()->back()->with('status', 'Log in Success!!!');
			}
			else{
				return redirect()->route($request->input('returnurl'))->with('status', 'Log in Success!!!');
			}
		}
	}
	else{
		return redirect()->back()->with('status', 'Login details incorrect, Please try again!!!');
	}
}
public function getCustomerLogOut(){
	Auth::guard('customer')->logout();
	Session::forget('cartcode');
	return redirect()->route('getHome');
}
public function postForgotPassword(Request $request){
	$check = Customer::where('email', $request->email)->count();
	if($check >= 1){
		$customer = Customer::where('email', $request->email)->limit(1)->first();
		$password = mt_rand(10000000, 99999999).'-'.time();
		$passwordhash = md5($password);

		$link = 'https://ritzenchantress.com/resetpassword/'.$passwordhash;

		DB::table('customers')
			->where('email', $request->email)
			->update([
				'remember_token' => $passwordhash,
				'email_verified_at' => Carbon\Carbon::now()
				]);

		//send email
		if(env('RECIEVER_EMAIL_MODE') == 'LIVE'){
			$rmail = env('RECIEVER_EMAIL_LIVE');
				$data = [
				'link' =>$link,
				'name' =>$customer->fname.''.$customer->lname
			];
  
		  //send mail to buyer
		  \Mail::to($request->email)->send(new \App\Mail\MailForgotPassword($data));
		}
		return redirect()->back()->with('status', 'A rest link has been send on your email.');
	}
	else{
		return redirect()->route()->with('status', 'Email not found!!!');
	}
}
public function getResetPasswordLink($code){
	$check = Customer::where('remember_token', $code);
	$customer = Customer::where('remember_token', $code)->limit(1)->first();
	if($check->count() == 1){
		$data =[
			'code' => $code,
			'id' => $customer->id,
			'email' => $customer->email
		];
		return view('site.resetpassword', $data);
	}
	else{
		return abort(404);
	}
	
}
public function postPassportReset(Request $request){
	$validator = Validator::make($request->all(), [
		'password' => 'required| min:4|confirmed',
        'password_confirmation' => 'required| min:4' 
	]);
	if ($validator->fails()) {
		return redirect()->back()->withErrors($validator);
	}
	$check = Customer::where('id', $request->id)->limit(1)->first();

	if($check->remember_token == $request->code){
		$passwordhash = Hash::make($request->password);
		DB::table('customers')
			->where('email', $request->email)
			->where('id', $request->id)
			->update([
				'password' => $passwordhash,
				'remember_token' => ''
				]);
			return redirect()->route('getCustomerLogin')->with('status', 'Password reset, Please login with new password.');
	}
	else{
		return abort(404);
	}
	
}
public function getPermissionDenied(){
	return view('site.permissiondenied');
}
}
