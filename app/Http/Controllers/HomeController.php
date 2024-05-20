<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Cart;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data =[
            'countpaidsales' => Order::where('paymentstatus', 'Y')->count(),
            'countpaidsalestotal' => Order::where('paymentstatus', 'Y')->whereDate('created_at', Carbon::today())->count(),
            'countunpaidsales' => Order::where('paymentstatus', 'N')->count(),
            'countunpaidsalestotal' => Order::where('paymentstatus', 'N')->whereDate('created_at', Carbon::today())->count(),
            'salestotal' => Order::where('paymentstatus', 'Y')->sum('grandtotal'),
            'todaysalestotal' => Order::where('paymentstatus', 'Y')->whereDate('created_at', Carbon::today())->sum('grandtotal'),
            'totalproducts'=>Product::count(),
            'paidorders' =>Order::where('paymentstatus', 'Y')->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->get(),
            'unpaidorders' =>Order::where('paymentstatus', 'N')->whereDate('created_at', Carbon::today())->orderby('id', 'desc')->get(),
            'onlineamount' =>Order::where('paymentstatus', 'Y')->where('paymentmethod', 'online')->whereMonth('created_at', date('m'))->sum('grandtotal'),
            'paypalamount' =>Order::where('paymentstatus', 'Y')->where('paymentmethod', 'paypal')->whereMonth('created_at', date('m'))->sum('grandtotal'),
            'monthlytotalamount' =>Order::where('paymentstatus', 'Y')->whereMonth('created_at', date('m'))->sum('grandtotal')
        ];
        return view('dashboard', $data);
    }

    public function getManageCategory(){
        if(auth()->user()->role == 'A'){
            return view('admin.catagory.manage');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getAllCustomer(){
        
            $data =[
            'customers'=>Customer::orderby('id', 'desc')->get()
        ];
        return view('admin.customers', $data);
        
        
    }
    public function getListofCustomerOrder(Request $request){
        $customerid = $request->customerid;
        $orders = Order::where('customer_id', $customerid)->get();
        $customer = Customer::where('id',$customerid)->limit(1)->first();
        
        $orderitems ='';
        $orderitems .="<table class='table' width='100%'>";
            foreach($orders as $order){
                $cartscount = Cart::where('code', $order->code)->count();
                
                    $carts = Cart::where('code', $order->code)->get();
                    $productlist = '';
                    foreach($carts as $cartitem){
                        $product = Product::where('id', $cartitem->product_id)->limit(1)->first();
                        $productlist .= $product->name.',';
                    }
                    $orderitems .= "
                    <tr>
                        <td>".$order->created_at."</td>
                        <td>".$cartscount."(items) <br /><small>".$productlist."</small></td>
                        <td>MYR".$order->grandtotal."</td>
                        <td>".$order->order_status."</td>
                    </tr>
                ";
            }
            $orderitems .="</table>";
        $data =[
            'orders' =>$orderitems,
            'customer' => $customer
        ];
        return response($data);
    }
public function postUpdateAsAAgent(Request $request){
    if(auth()->user()->role == 'A'){
    $customerid = $request->input('customerid');
    $discount = $request->input('discount');
    DB::table('customers')
    ->where('id', $customerid)
    ->update([
        'discount' => $discount,
        'agent' => 'Y',
        ]);
        return redirect()->back();
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
}
public function getAdminRemoveAgent(Customer $customer){
    if(auth()->user()->role == 'A'){
    $customer->agent = 'N';
    $customer->discount = '0.00';
    $customer->save();
    return redirect()->back()->with('status', 'Agent Removed!!!');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
}
public function AminPostModifyCourier(Request $request)
{
    $data = $request->input('selectedagent');

    $eorder = explode('?', $data);
    $service_id = $eorder[0];
    $shipment_price = $eorder[1];
    $courier_name = $eorder[2];
    $delivery = $eorder[3];
    $courier_logo = $eorder[4];
    $pointid = $eorder[5];

    DB::table('orders')
    ->where('id', $request->orderid)
    ->update([
        'service_id' => $service_id,
        'shippingcompany' => $courier_name,
        'delivery_range' => $delivery,
        'shippingcompanylogo' => $courier_logo,
        'pointid' => $pointid,
        ]);
        return redirect()->route('getManageCourier', $request->orderid)->with('message', 'Courier Agent modified!!!');
}
}
