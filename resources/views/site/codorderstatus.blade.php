@extends('site.template', ['title' => __('Order Status')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Order Status</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Order Status</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="checkout__page--area">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="background-color: goldenrod; text-align: center; margin-top: 12px; padding: 15px;">
               
               @if($order->paymentmethod == 'directbank')
               <h1>Thank You for your Order</h1>
               <h4>OrderID : #{{ $order->id }}-{{ $order->code }}</h4>
               <p>
                   For Order Confirmation Please send us a bank slip to <a href="https://wa.me/60126541955" target="_bank">+60126541955</a> (whatsapp) OR email to ritzenchantress@gmail.com <br />
                   After verification you order status will be paid.
                </p>
               @else
               <h1>Some think wrong</h1>
               <h4>Payment unsuccess.</h4>
               <p><a href="{{ route('getPayment') }}">Please try again. Click this to try again.</a></p>
               @endif
            </div>
        </div>
        <div class="checkout__page--inner d-flex">
            <div class="row" style="width: 100%;">
                <div class="col-md-7">
                    <div class="main checkout__mian">
                        <main class="main__content_wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6 checkout__contendt--step section__codntact--information">
                                            <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                                <h2 class="section__header--title h3">Buyer information</h2>
                                                <!-- <p class="layout__flex--item">
                                                    Already have an account?
                                                    <a class="layout__flex--item__link" href="login.html">Log in</a>  
                                                </p> -->
                                            </div>
                                            @php
                                            if($order->buyer_country == '136'){
                                              
                                                $bcountry1 = App\Models\Country::where('id', $order->buyer_country)->limit(1)->first();
                                                $bstate1 = App\Models\State::where('id',$order->buyer_state)->limit(1)->first();
                                                $bcountry = $bcountry1->name;
                                                $bstate = $bstate1->name;
                                            }
                                            else{
                                                $bcountry1 = App\Models\Country::where('id', $order->buyer_country)->limit(1)->first();
                                                $bcountry = $bcountry1->name;
                                                $bstate = $order->buyer_state;
                                            }
                                            if($order->receiver_country == '136'){
                                                $rcountry1 = App\Models\Country::where('id', $order->receiver_country)->limit(1)->first();
                                                $rstate1 = App\Models\State::where('id',$order->receiver_state)->limit(1)->first();
                                                $rcountry = $rcountry1->name;
                                                $rstate = $rstate1->name;
                                            }
                                            else{
                                                $rcountry1 = App\Models\Country::where('id', $order->receiver_country)->limit(1)->first();
                                                $rcountry = $rcountry1->name;
                                                $rstate = $order->receiver_state;
                                            }
                                        @endphp
                                            <div class="customer__information">
                                                <div class="section__shipping--address__content">
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-12">
                                                            <div class="checkout__input--list ">
                                                                <strong><h5>{{ $order->buyer_fname }}</h5></strong>
                                                                <h5>{{ $order->buyer_address }}</h5>
                                                                <h5>{{ $order->buyer_address1 }}</h5>
                                                                <h5>{{ $bstate }}, {{ $order->buyer_city }}, {{ $bcountry }}, {{ $order->buyer_postal_code }} </h5>
                                                                <h5>{{ $order->buyer_mobile }}</h5>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md--6 checkout__contednt--step section__shdipping--address">
                                            <div class="section__header mb-25">
                                                <h3 class="section__header--title">Shipping address</h3>
                                            </div>
                                            <div class="section__shipping--address__content" style="display: flex;">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-12">
                                                        <div class="checkout__input--list ">
                                                            <h5>{{ $order->receiver_fname }} {{ $order->receiver_lname }}</h5>
                                                            <h5>{{ $order->receiver_address }}</h5>
                                                            <h5>{{ $order->receiver_address1 }}</h5>
                                                            <h5>{{ $rstate }}, {{ $order->receiver_city }}, {{ $rcountry }}, {{ $order->receiver_postal_code }}</h5>
                                                            <h5>{{ $order->receiver_mobile }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            <br /> <br />
                                            </div>
                                        </div>
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
                                    
                                    <?php 
                                            $getcartdetails = App\Models\Cart::where('code', $order->code)->get();
                                            $grandtotal = App\Models\Cart::where('code', $order->code)->sum('totalcost');
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
                                                    <!-- <span class="product__description--variant">COLOR: Blue</span> -->
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <span class="cart__price">MYR {{ $cat->cost }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
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
                                    @if(auth()->guard('agent')->check())
                                            @php $agent = App\Models\Agent::where('id', auth()->guard('agent')->user()->id)->limit(1)->first(); @endphp
                                            <tr class="checkout__total--items">
                                                <td class="checkout__total--title text-left">Agent Discount ({{ $agent->discount }}%) </td>
                                                <td class="checkout__total--amount text-right">MYR {{ $grandtotal*($agent->discount/100) }}</td>
                                            </tr>
                                            <tr class="checkout__total--items">
                                                <td class="checkout__total--title text-left">Total </td>
                                                <td class="checkout__total--amount text-right">MYR {{ $grandtotal-($grandtotal*($agent->discount/100)) }}</td>
                                            </tr>
                                        @endif
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
                                            <small>{{ $order->delivery_range }} via {{ $order->shippingcompany }}</small> <br/>
                                           
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot class="checkout__total--footer">
                                    <tr class="checkout__total--footer__items">
                                        <td class="checkout__total--footer__title checkout__total--footer__list text-left"> Grand Total </td>
                                        <td class="checkout__total--footer__amount checkout__total--footer__list text-right">MYR {{ $order->grandtotal }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                           
                        </div>
                    </aside>
                </div>
           
        
        </div>
    </div>
</div>
@stop