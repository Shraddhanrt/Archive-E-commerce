<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Xentixar\EsewaSdk\Esewa;
use Session;
use DB;

class EsewaController extends Controller
{
    public function getPayWithEsewa(Order $order)
    {

        $esewa = new Esewa();
        $esewa->config('http://localhost:8000/esewa-success', 'http://localhost:8000/esewa-fail', $order->grandtotal);
        $esewa->init();
    }
    public function getEsewaPaymentSuccess()
    {
        $sessioncode = Session::get('cartcode');
        DB::table('orders')
            ->where('code', $sessioncode)
            ->limit(1)
            ->update(array('paymentstatus' => 'Y'));

        dd('your payment recieved successfully');
    }
}
