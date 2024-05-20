<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\ShippingCostCalculate;
use Mail;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageOrder(){
        $data =[
            'orders'=>Order::orderby('id', 'desc')->get()
        ];

        return view('admin.order.manage', $data);
    }

    public function getManageInvoice(Order $order){
        $data =[
            'order'=> $order,
            'cats' => Cart::where('code', $order->code)->get()
        ];
        return view('admin.order.invoice', $data);
    }
    
    public function getSendTrackCode(Order $order, Request $request){
        $code = $request->input('trackingcode');
        
        $order->trackingcode = $code;
        $order->save();
       
			 
        $data = [
           'fname' =>$order->buyer_fname,
           'code' =>$order->code,
           'totalcost'=> $order->grandtotal,
           'paymentmethod'=>$order->paymentmethod,
           'trackingcode'=>$code
         ];
 
         //send mail to buyer
         \Mail::to($order->buyer_email)->send(new \App\Mail\MailTrackingCode($data));

         
        return redirect()->back();
        
    }
    public function getDeleteOrder(Order $order){
        if($order->paymentstatus == 'N'){
            DB::table('carts')->where('code', $order->code)->delete();
            $order->delete();
            return redirect()->back()->with('status', 'Order deleted successfully!!!');
        }
        else{
            return redirect()->back()->with('status', 'Unable to delete this order. Its Paid order');
        }
    }
public function getManageCourier(Order $order){
            $country = $order->receiver_country;
			$state = $order->receiver_state;
			$city = $order->receiver_city;
			$postalcode = $order->receiver_postalcode;
			$orderid = $order->id;
			
			// get list of coriyar 
			// $manageorder = ShippingCostCalculate::getManageOrder($postalcode, $state, $country, $orderid);
            
            $data =[
                'order' =>$order,
                'carts' => Cart::where('code', $order->code)->get()
            ];
           return view('admin.courier.manage', $data);
}

public function getManagePaidOrder(){
    $data =[
        'orders' => Order::where('paymentstatus', 'Y')->orderby('id', 'desc')->paginate(10)
    ];
    return view('admin.order.paidorder', $data);

}
public function getManageUnpaidOrder(){
    $data =[
        'orders' => Order::where('paymentstatus', 'N')->orderby('id', 'desc')->paginate(10)
    ];
    return view('admin.order.unpaidorder', $data);
}
public function getOrderDetail(Order $order){
    $data =[
        'order'=>$order,
        'carts' => Cart::where('code', $order->code)->get(),
        'orders'=>Order::all()
    ];
    return view('admin.order.orderdetail', $data);
}
public function getMakeAsPaid(Order $order){
			
    $order->paymentstatus = 'Y';
    $order->updated_at = date('Y-m-d');
    $order->save();
			 
			 $data = [
				'fname' =>$order->buyer_fname,
				'code' =>$order->code,
				'totalcost'=> $order->grandtotal,
				'paymentmethod'=>$order->paymentmethod
			  ];
			  //send mail to buyer
			  \Mail::to($order->buyer_email)->send(new \App\Mail\Mail($data));

			  //send mail to owner
			  \Mail::to('ritzenchantress@gmail.com')->send(new \App\Mail\Mail1($data));
              return redirect()->route('getManagePaidOrder')->with('status', 'Order mark as a paid');
}
public function getMakeAsUnPaid(Order $order){
    $order->paymentstatus = 'N';
    $order->updated_at = date('Y-m-d');
    $order->save();
	
    return redirect()->route('getManageOrder')->with('status', 'Order mark as unpaid');
}

public function postChangeOrderStatus(Request $request){
    $status = $request->input('orderstatus');
    $sendmail = $request->input('notification');
    $orderid = $request->input('orderid');

    DB::table('orders')
			->where('id', $orderid)
			->update([
				'order_status' => $status
				]);
    if($sendmail == 'emailsend'){
        dd('send email');
    }

}
public function postAddtoCartParsal(Request $request){
    
    $parsalAddtoCart = ShippingCostCalculate::getManageOrder($request);
    
    $order_number = $parsalAddtoCart->result[0]->order_number;
    $MakeAPayment = ShippingCostCalculate::MakeAPayment($order_number);
    // dd($MakeAPayment);
    if($MakeAPayment->result[0]->messagenow == 'Payment Done'){
     // save detail to order table
    $order = Order::where('id', $request->orderid)->limit(1)->first();
    DB::table('orders')
        ->where('id', $request->orderid)
        ->update([
            'trackingcode' => $MakeAPayment->result[0]->parcel[0]->tracking_url,
            'parsal_orderno' => $MakeAPayment->result[0]->orderno,
            'parcelno' => $MakeAPayment->result[0]->parcel[0]->parcelno,
            'awb' => $MakeAPayment->result[0]->parcel[0]->awb,
            'awb_id_link' => $MakeAPayment->result[0]->parcel[0]->awb_id_link,
            'order_status' => 'Shipped'
            ]);
    if($request->trackingemailsend == 'on'){
        $data = [
        'trakinglink' => $MakeAPayment->result[0]->parcel[0]->tracking_url,
        'name' =>$request->input('name')
      ];
      //send mail to buyer
      \Mail::to($request->input('email'))->send(new \App\Mail\MailTrackingCode($data));
    }
    
    return redirect()->back()->with('status', 'Item(s) collection request successfully send to Easy Parsal');
}
else{
    dd($MakeAPayment->result[0]->messagenow);
}
    
}
public function getSendEmailFollowBack(Order $order){

    $data = [
    'fname' =>$order->buyer_fname,
    'code' =>$order->code,
    'totalcost'=> $order->grandtotal,
    'paymentmethod'=>$order->paymentmethod
  ];
  //send mail to buyer
  \Mail::to($order->buyer_email)->send(new \App\Mail\MailForFollowBack($data));

  
  return redirect()->back()->with('status', 'Continous order email has been send successfully!!!');
}
public function getAdminChangeCourier(Order $order){

    $getShippingCosts = ShippingCostCalculate::getEasyParsals($order->receiver_postal_code, $order->receiver_state, $order->receiver_country, $order->code);
    $data = [
        'order' =>$order,
        'carts' =>Cart::where('code', $order->code)->get(),
        'shippers' =>$getShippingCosts,
        'model' =>'yes'
    ];

    return view('admin.courier.modifycourier', $data);
}

}
