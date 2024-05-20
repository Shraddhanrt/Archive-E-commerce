@extends('site.template', ['title' => __('Confirm Order')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Confirm Order</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Confirm Order</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="checkout__page--area">
    <div class="container">
        <div class="checkout__page--inner d-flex">
            <div class="row" style="width: 100%;">
                <div class="col-md-7">
                    <div class="main checkout__mian">
                        <main class="main__content_wrapper">
                                <div class="checkout__content--step section__contact--information">
                                    <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                        <h2 class="section__header--title h3">Buyer information</h2>
                                        <!-- <p class="layout__flex--item">
                                            Already have an account?
                                            <a class="layout__flex--item__link" href="login.html">Log in</a>  
                                        </p> -->
                                    </div>
                                    <div class="customer__information">
                                        <div class="section__shipping--address__content">
                                            <div class="row">
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list ">
                                                        @php
                                                            $bcountry1 = App\Models\Country::where('id', $order->buyer_country)->limit(1)->first();
                                                            $scountry1 = App\Models\Country::where('id', $order->receiver_country)->limit(1)->first();
                                                            $bstate2 = App\Models\State::where('id', $order->buyer_state)->limit(1)->first();
                                                            $sstate2 = App\Models\State::where('id', $order->receiver_state)->limit(1)->first();
                                                        @endphp
                                                        <strong><h5>{{ $order->buyer_fname }} {{ $order->buyer_lname }}</h5></strong>
                                                        <h5>{{ $order->buyer_address }}</h5>
                                                        <h5>{{ $order->buyer_address1 }}</h5>

                                                        <h5>{{ $bstate2->name }}, {{ $order->buyer_city }}, {{ $bcountry1->name }}<br />{{ $order->buyer_postal_code }} </h5>
                                                        <h5>{{ $order->buyer_mobile }}</h5>
                                                        <h5>{{ $order->buyer_email }}</h5>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="checkout__content--step section__shipping--address">
                                    <div class="section__header mb-25">
                                        <h3 class="section__header--title">Shipping address</h3>
                                    </div>
                                    <div class="section__shipping--address__content">
                                        <div class="row">
                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list ">
                                                    <h5>{{ $order->receiver_fname }} {{ $order->receiver_lname }}</h5>
                                                    <h5>{{ $order->receiver_address }}</h5>
                                                    <h5>{{ $order->receiver_address1 }}</h5>
                                                    <h5>{{ $sstate2->name }}, {{ $order->receiver_city }}, {{ $scountry1->name }}<br />{{ $order->receiver_postal_code }}</h5>
                                                    <h5>{{ $order->receiver_mobile }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    <br /> <br />
                                    </div>
                                </div>
                        </main>
                    </div>
                </div>
                <div class="col-md-5">
                    <aside class="checkout__sidebar sidebar">
                        <div class="cart__table checkout__product--table">
                            <table class="cart__table--inner">
                                <tbody class="cart__table--body">
                                    @if(Session::get('cartcode'))
                                    <?php 
                                            $getcartdetails = App\Models\Cart::where('code', Session::get('cartcode'))->get();
                                            $grandtotal = App\Models\Cart::where('code', Session::get('cartcode'))->sum('totalcost');
                                            ?>
                                    @foreach($getcartdetails as $cat)
                                    <?php $getproductC = App\Models\Product::where('id', $cat->product_id)->limit(1)->first(); ?>
                                    <tr class="cart__table--body__items">
                                        <td class="cart__table--body__list">
                                            <div class="product__image two  d-flex align-items-center">
                                                <div class="product__thumbnail border-radius-5">
                                                    <a href=""><img class="border-radius-5" src="{{ asset('site/uploads/products/'.$getproductC->photo) }}" alt="cart-product"></a>
                                                    <span class="product__thumbnail--quantity">{{ $cat->qty }}</span>
                                                </div>
                                                <div class="product__description">
                                                    <h3 class="product__description--name h4"><a href="">{{ $getproductC->name }}</a></h3>
                                                    <span class="product__description--variant">Weight: {{ $getproductC->weight }} kg</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <span class="cart__price">MYR {{ $cat->cost }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table> 
                        </div>
                        <div class="checkout__total">
                            <table class="checkout__total--table">
                                <tbody class="checkout__total--body">
                                    <tr class="checkout__total--items">
                                        <td class="checkout__total--title text-left">Subtotal </td>
                                        <td class="checkout__total--amount text-right">MYR {{ $grandtotal }}</td>
                                    </tr>
                                    <tr class="checkout__total--items">
                                        <td class="checkout__total--title text-left">Tax</td>
                                        <td class="checkout__total--calculated__text text-right">MYR 0.00</td>
                                    </tr>
                                    <tr class="checkout__total--items">
                                        <td class="checkout__total--title text-left">Shipping</td>
                                        <td class="checkout__total--calculated__text text-right">
                                            MYR {{ $order->shippingcost }} <br />
                                        </td>
                                    </tr>
                                    <tr class="checkout__total--items">
                                        <td class="checkout__total--title text-left"></td>
                                        <td class="checkout__total--calculated__text text-right">
                                            <small>{{ $order->delivery_range }} delivery duration</small><br/>
                                            <img src="{{ $order->shippingcompanylogo }}" alt="" width="100">
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot class="checkout__total--footer">
                                    <tr class="checkout__total--footer__items">
                                        <td class="checkout__total--footer__title checkout__total--footer__list text-left"> </td>
                                        <td class="checkout__total--footer__amount checkout__total--footer__list text-right">MYR {{ $order->grandtotal }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            @if($order->paymentmethod == 'online')
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <hr />
                                            <div class="guarantee__safe--checkout">
                                                <!-- <h5 class="guarantee__safe--checkout__title">Guaranteed Safe Checkout</h5> -->
                                                <img class="guarantee__safe--checkout__img" src="{{ asset('site/assets/img/other/onlinepayment.jpg') }}" alt="Payment Image" style="margin-top: 5px;">
                                            </div>
                                    </div>
                                    @php
                                        $order = App\Models\Order::where('code', Session::get('cartcode'))->limit(1)->first();
                                        if(env('SENANGPAY_MODE') == 'LIVE'){
                                            $merchant_id = env('SENANGPAY_LIVE_MERCHANT_ID');
                                            $secretkey = env('SENANGPAY_LIVE_SECRETKEY');
                                            $payment_url = 'https://app.senangpay.my/payment/'.$merchant_id;
                                        }
                                        else{
                                            $merchant_id = env('SENANGPAY_SANDBOX_MERCHANT_ID');
                                            $secretkey = env('SENANGPAY_SANDBOX_SECRETKEY');
                                            $payment_url = 'https://sandbox.senangpay.my/payment/'.$merchant_id;
                                        }
                                        $detail = 'Shopping';
                                        $amount = $order->grandtotal;
                                        $order_id = $order->id.'-'.$order->code;
                                        $str = $secretkey.''.$detail.''.$amount.''.$order_id;
                                    
                                        $hashed_string = hash_hmac('SHA256', $str, $secretkey);
                                    
                                    @endphp
                                    @if($order->paymentstatus == 'N')
                                    <form action="{{ $payment_url }}" method="POST">
                                        <input type="hidden" name="detail" value="Shopping">
                                        <input type="hidden" name="amount" value="{{ $amount }}">
                                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                                        <input type="hidden" name="hash" value="{{ $hashed_string }}">
                                        <input type="hidden" name="name" value="{{ $order->buyer_fname }}">
                                        <input type="hidden" name="email" value="{{ $order->buyer_email }}">
                                        <input type="hidden" name="phone" value="{{ $order->buyer_mobile }}">
                                        <input type="submit" class="btn primary__btn" style="width: 100%; text-align: center; margin-top: 15px;" value="Pay Now">
                                    </form>
                                    @else
                                        <a href="" class="btn primary__btn" style="width: 100%; text-align: center; margin-top: 15px;">Already Paid</a>
                                    @endif
                                    <br /> <br />
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <hr />
                                            <div class="guarantee__safe--checkout">
                                                <!-- <h5 class="guarantee__safe--checkout__title">Guaranteed Safe Checkout</h5> -->
                                                <img class="guarantee__safe--checkout__img" src="{{ asset('site/images/paypal.png') }}" alt="Payment Image" style="margin-top: 5px;" width="200">
                                            </div>
                                    </div>
                                    <a href="{{ route('payWithpaypal') }}" class="btn primary__btn" style="width: 100%; text-align: center; margin-top: 15px;">Pay Now</a>
                                    <br /> <br />
                                </div>
                            </div>
                            @endif
                        </div>
                    </aside>
                </div>
            </div>
        
        </div>
    </div>
</div>
@stop