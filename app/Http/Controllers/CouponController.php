<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCouponManage(){
        $data =[
            'coupons' => Coupon::orderby('id', 'desc')->get()
        ];
        return view('admin.coupon.manage', $data);
    }
    public function postCreateCoupon(Request $request){

        $code = $request->input('code');
        $amounttype = $request->input('amounttype');
        $amount = $request->input('amount');
        $expiry = $request->input('expirydate');
        $type = $request->input('type');
        $min_cost_apply = $request->input('min_cost_apply');

        $codewithourspace =str_replace(' ','',$code); 

        $check = Coupon::where('code', $codewithourspace)->count();
        if($check == 0){
            $coupon = New Coupon;
            $coupon->code = $codewithourspace;
            $coupon->amounttype = $amounttype;
            $coupon->amount = $amount;
            $coupon->expiry = $expiry;
            $coupon->onetime = $type;
            $coupon->min_cost_apply = $min_cost_apply;
            $coupon->save();
            return redirect()->back()->with('status', 'Successfully Created New Promo Code');
        }
        else{
            return redirect()->back()->with('status', 'Dublicate promo code entry');
        }
    }
    public function getDeleteCoupon(Coupon $coupon){
        $checkorderCoupon = Order::where('coupon_id', $coupon->id)->count();
        if($checkorderCoupon == 0){
            $coupon->delete();
            return redirect()->back()->with('status', 'Successfully Deleted Promo Code');
        }
        else{
            return redirect()->back()->with('status', 'This Promo Code already used by customer, unable to delete');
        }
        
    }
    public function getEditCoupon(Coupon $coupon){
        
            $data =[
                'coupon' => $coupon
            ];
        return view('admin.coupon.edit', $data);
        
    }
    public function postEditCoupon(Coupon $coupon, Request $request){
        $code = $request->input('code');
        $amounttype = $request->input('amounttype');
        $amount = $request->input('amount');
        $expiry = $request->input('expirydate');
        $type = $request->input('type');
        $min_cost_apply = $request->input('min_cost_apply');

        $codewithourspace =str_replace(' ','',$code);

        $check = Coupon::where('code', $codewithourspace)->where('id', '!=', $coupon->id)->count();
        if($check == 0){
            $coupon->code = $codewithourspace;
            $coupon->amount = $amount;
            $coupon->amounttype = $amounttype;
            $coupon->expiry = $expiry;
            $coupon->onetime = $type;
            $coupon->min_cost_apply = $min_cost_apply;
            $coupon->save();
            return redirect()->route('getCouponManage')->with('status', 'Successfully Edited Promo Code');
        }
        else{
            return redirect()->back()->with('status', 'Dublicate Promo Code entry');
        }

    }
    public function getEnableDisableCoupon(Coupon $coupon){
        if($coupon->status == 'Y'){
            $coupon->status = 'N';
            $coupon->save();
            return redirect()->back()->with('status', 'Promo Code Disable successfully');
        }
        else{
            $coupon->status = 'Y';
            $coupon->save();
            return redirect()->back()->with('status', 'Promo Code Enable successfully');
        }
        
    }
}
