@extends('site.template', ['title' => __('Checkout')])
@section('css')
<style>
    .box1{
    display: none;
}
.boxmodify{
    display: none;
}
.shippingotherstate{
    display: none;
}
* {
  user-select: none;
}

*:focus {
  outline: none;
}


#info {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  color: #2d3667;
  font-size: 16px;
  text-align: center;
  padding: 14px;
  background-color: #f3f9f9;
}

#app-cover {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  width: 300px;
  height: 42px;
  margin: 100px auto 0 auto;
  z-index: 1;
}

#select-button {
  position: relative;
  height: 16px;
  padding: 12px 14px;
  background-color: #fff;
  border-radius: 4px;
  cursor: pointer;
}

#options-view-button {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  margin: 0;
  opacity: 0;
  cursor: pointer;
  z-index: 3;
}

#selected-value {
  font-size: 16px;
  line-height: 1;
  margin-right: 26px;
}

.option i {
  width: 16px;
  height: 16px;
}

.option,
.label {
  color: #2d3667;
  font-size: 16px;
}

#chevrons {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 12px;
  padding: 9px 14px;
}

#chevrons i {
  display: block;
  height: 50%;
  color: #d1dede;
  font-size: 12px;
  text-align: right;
}

#options-view-button:checked + #select-button #chevrons i {
  color: #2d3667;
}

.options {
  position: absolute;
  left: 0;
  width: 250px;
}

#options {
  position: absolute;
  top: 42px;
  right: 0;
  left: 0;
  width: 298px;
  margin: 0 auto;
  background-color: #fff;
  border-radius: 4px;
}

#options-view-button:checked ~ #options {
  border: 1px solid #e2eded;
  border-color: #eaf1f1 #e4eded #dbe7e7 #e4eded;
}

.option {
  position: relative;
  line-height: 1;
  transition: 0.3s ease all;
  z-index: 2;
}

.option i {
  position: absolute;
  left: 14px;
  padding: 0;
  display: none;
}

#options-view-button:checked ~ #options .option i {
  display: block;
  padding: 12px 0;
}

.label {
  display: none;
  padding: 0;
  margin-left: 27px;
}

#options-view-button:checked ~ #options .label {
  display: block;
  padding: 12px 14px;
}

.s-c {
  position: absolute;
  left: 0;
  width: 100%;
  height: 50%;
}

.s-c.top {
  top: 0;
}

.s-c.bottom {
  bottom: 0;
}

input[type="radio"] {
  /* position: absolute;
  right: 0;
  left: 0;
  width: 100%;
  height: 50%;
  margin: 0;
  opacity: 0;
  cursor: pointer; */
}

.s-c:hover ~ i {
  color: #fff;
  opacity: 0;
}

.s-c:hover {
  height: 100%;
  z-index: 1;
}

.s-c.bottom:hover + i {
  bottom: -25px;
  animation: moveup 0.3s ease 0.1s forwards;
}

.s-c.top:hover ~ i {
  top: -25px;
  animation: movedown 0.3s ease 0.1s forwards;
}

@keyframes moveup {
  0% {
    bottom: -25px;
    opacity: 0;
  }
  100% {
    bottom: 0;
    opacity: 1;
  }
}

@keyframes movedown {
  0% {
    top: -25px;
    opacity: 0;
  }
  100% {
    top: 0;
    opacity: 1;
  }
}

.label {
  transition: 0.3s ease all;
}

.opt-val {
  position: absolute;
  left: 14px;
  width: 217px;
  height: 21px;
  opacity: 0;
  background-color: #fff;
  transform: scale(0);
}

.option input[type="radio"]:checked ~ .opt-val {
  opacity: 1;
  transform: scale(1);
}

.option input[type="radio"]:checked ~ i {
  top: 0;
  bottom: auto;
  opacity: 1;
  animation: unset;
}

.option input[type="radio"]:checked ~ i,
.option input[type="radio"]:checked ~ .label {
  color: #fff;
}

.option input[type="radio"]:checked ~ .label:before {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
}

#options-view-button:not(:checked)
  ~ #options
  .option
  input[type="radio"]:checked
  ~ .opt-val {
  top: -30px;
}

.option:nth-child(1) input[type="radio"]:checked ~ .label:before {
  background-color: #000;
  border-radius: 4px 4px 0 0;
}

.option:nth-child(1) input[type="radio"]:checked ~ .opt-val {
  top: -31px;
}

.option:nth-child(2) input[type="radio"]:checked ~ .label:before {
  background-color: #ea4c89;
}

.option:nth-child(2) input[type="radio"]:checked ~ .opt-val {
  top: -71px;
}

.option:nth-child(3) input[type="radio"]:checked ~ .label:before {
  background-color: #0057ff;
}

.option:nth-child(3) input[type="radio"]:checked ~ .opt-val {
  top: -111px;
}

.option:nth-child(4) input[type="radio"]:checked ~ .label:before {
  background-color: #32c766;
}

.option:nth-child(4) input[type="radio"]:checked ~ .opt-val {
  top: -151px;
}

.option:nth-child(5) input[type="radio"]:checked ~ .label:before {
  background-color: #f48024;
}

.option:nth-child(5) input[type="radio"]:checked ~ .opt-val {
  top: -191px;
}

.option:nth-child(6) input[type="radio"]:checked ~ .label:before {
  background-color: #006400;
  border-radius: 0 0 4px 4px;
}

.option:nth-child(6) input[type="radio"]:checked ~ .opt-val {
  top: -231px;
}

.option .fa-codepen {
  color: #000;
}

.option .fa-dribbble {
  color: #ea4c89;
}

.option .fa-behance {
  color: #0057ff;
}

.option .fa-hackerrank {
  color: #32c766;
}

.option .fa-stack-overflow {
  color: #f48024;
}

.option .fa-free-code-camp {
  color: #006400;
}

#option-bg {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 40px;
  transition: 0.3s ease all;
  z-index: 1;
  display: none;
}

#options-view-button:checked ~ #options #option-bg {
  display: block;
}

.option:hover .label {
  color: #fff;
}

.option:nth-child(1):hover ~ #option-bg {
  top: 0;
  background-color: #000;
  border-radius: 4px 4px 0 0;
}

.option:nth-child(2):hover ~ #option-bg {
  top: 40px;
  background-color: #ea4c89;
}

.option:nth-child(3):hover ~ #option-bg {
  top: 80px;
  background-color: #0057ff;
}

.option:nth-child(4):hover ~ #option-bg {
  top: 120px;
  background-color: #32c766;
}

.option:nth-child(5):hover ~ #option-bg {
  top: 160px;
  background-color: #f48024;
}

.option:nth-child(6):hover ~ #option-bg {
  top: 200px;
  background-color: #006400;
  border-radius: 0 0 4px 4px;
}
.box{
    display: none;
}

</style>
@stop
@section('content')
<?php
if(auth()->guard('customer')->check()){
    
    $customer = App\Models\Customer::where('id', auth()->guard('customer')->user()->id)->limit(1)->first();
    
    $bfname = $customer->fname;
    $blname = $customer->lname;
    $baddress = $customer->address;
    $baddress2 = $customer->address2;
    $bcountry = $customer->country;
    $bstate = $customer->state;
    $bcity = $customer->city;
    $bpostal = $customer->postalcode;
    $bemail = $customer->email;
    $bmobile = $customer->mobile;

    $sfname = $customer->sfname;
    $slname = $customer->slname;
    $saddress = $customer->saddress;
    $saddress2 = $customer->saddress2;
    $scountry = $customer->scountry;
    $sstate = $customer->sstate;
    $scity = $customer->scity;
    $spostal = $customer->spostal;
    $smobile = $customer->smobile;
}else{
    $bfname = '';
    $blname = '';
    $baddress = '';
    $baddress2 = '';
    $bcountry = session()->get('shipping')['country'];
    $bstate = session()->get('shipping')['state'];
    $bcity = session()->get('shipping')['city'];
    $bpostal = session()->get('shipping')['postalcode'];
    $bemail = '';
    $bmobile = '';

    $sfname = '';
    $slname = '';
    $saddress = '';
    $saddress2 = '';
    $scountry = session()->get('shipping')['country'];
    $sstate = session()->get('shipping')['state'];
    $scity = session()->get('shipping')['city'];
    $spostal = session()->get('shipping')['postalcode'];
    $smobile = '';
}
?>
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Checkout</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="checkout__page--area">
    <div class="container">
        <div class="checkout__page--inner">
            <form action="{{ route('postCheckOut') }}" method="POST" style="display: inherit">
                @csrf()
                <div class="row">
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
                                                    <div class="col-md-12">
                                                        <strong>{{$bfname}} {{$blname}}</strong> <br />
                                                        {{$baddress}} <br />
                                                        @if($baddress2)
                                                        {{ $baddress2 }} <br />
                                                        @endif
                                                        @php
                                                            $bcountyinfo = App\Models\Country::where('id', $bcountry)->limit(1)->first();
                                                            if($bcountry == '136'){
                                                                $bstateinfo = App\Models\State::where('id', $bstate)->limit(1)->first();
                                                                $bstatename = $bstateinfo->name;
                                                            }
                                                            else{
                                                                $bstatename = $bstate;
                                                            }
                                                        @endphp
                                                        {{ $bpostal }} {{ $bcity }}, {{ $bstatename }}, {{$bcountyinfo->name}} <br />
                                                        {{ $bmobile}} <br />
                                                        {{ $bemail}} <br />
                                                        <a href="{{route('getBuyerInformationEdit')}}" class="cart__summary--footer__btn primary__btn">Edit Buyer Address</a>

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
                                                <div class="col-md-12">
                                                    <strong>{{ $sfname }} {{ $slname }}</strong> <br />
                                                    {{ $saddress }} <br />
                                                    @if($saddress2)
                                                    {{ $saddress2 }} <br />
                                                    @endif
                                                    @php
                                                        $scountyinfo = App\Models\Country::where('id', $scountry)->limit(1)->first();
                                                        if($scountry == '136'){
                                                            $sstateinfo = App\Models\State::where('id', $sstate)->limit(1)->first();
                                                            $sstatename = $sstateinfo->name;
                                                        }
                                                        else{
                                                            $sstatename = $sstate;
                                                        }
                                                    @endphp
                                                    {{ $spostal }} {{ $scity }}, {{ $sstatename }}, {{$scountyinfo->name}} <br />
                                                    {{ $smobile }} <br />
                                                    <a href="{{ route('getShippingInformationEdit') }}" class="cart__summary--footer__btn primary__btn">Edit Shipping Address</a>
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
                                <h4>Your Carts</h4>
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
                                                        <h3 class="product__description--name h4"><a href="">{{ $getproductC->name }}</a>
                                                          <small style="display:block;">
                                                            @if($getproductC->shippingfree == 'Y')
                                                            Free Shipping
                                                            @endif
                                                          </small>
                                                        </h3>
                                                        <span class="product__description--variant">Weight :{{ $getproductC->weight }}KG</span>
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
                                            
                                            <td class="checkout__total--amount text-right">
                                                <h6 class="checkout__total--title"><strong>Subtotal </strong></h6>
                                                MYR {{ $grandtotal }}</td>
                                        </tr>
                                        @if(auth()->guard('customer')->check())
                                            @php $customer = App\Models\Customer::where('id', auth()->guard('customer')->user()->id)->limit(1)->first(); @endphp
                                            @if($customer->agent == 'Y' AND $customer->discount != Null)
                                            <tr class="checkout__total--items">
                                                
                                                <td class="checkout__total--amount text-right">
                                                    <h6 class="checkout__total--title text-right"><strong>Agent Discount ({{ $customer->discount }}%)</strong> </h6>
                                                    MYR {{ $grandtotal*($customer->discount/100) }}</td>
                                            </tr>
                                            <tr class="checkout__total--items">
                                                
                                                <td class="checkout__total--amount text-right">
                                                    <h6 class="checkout__total--title text-right"><strong>Total</strong></h6>
                                                    MYR {{ $grandtotal-($grandtotal*($customer->discount/100)) }}
                                                </td>
                                            </tr>
                                            @endif
                                        @endif
                                        <tr class="checkout__total--items">
                      
                                            <td class="checkout__total--calculated__text text-right">
                                                <div class="checkout__input--list checkout__input--select select">
                                                    <h6 class="checkout__total--title text-right"><strong>Shipping</strong></h6>
                                                    
                                                <select class="checkout__input--select__field border-radius-5" name="selectedagent" id="selectedagent" style="border-color: orange;">
                                                    {!! $shippers !!}
                                                </select>
                                                </div>
                                            </td>
                                        </tr>
                                       @if(auth()->guard('customer')->user()->agent == 'N')
                                        <tr>
                                            
                                            <td class="">
                                                
                                                   <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-9">
                                                        <input class="checkout__input--field border-radius-5" name="couponcode" type="text" placeholder="Promo Code" id="couponcode">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a class="btn primary__btn" id="usedcoupon" style="">Apply</a>
                                                    </div>
                                                   </div>
                                                    <span id="couponmsg" style="color:red;"></span>
                                                    <span id="costmsg" style="color:red;"></span>
                                                
                                            </td>
                                           
                                        </tr>
                                    @endif
                                        
                                    </tbody>
                                    <tfoot class="checkout__total--footer">
                                        <tr class="checkout__total--footer__items">
                                           
                                            <td class="checkout__total--footer__amount checkout__total--footer__list text-right">
                                                <h6 class="checkout__total--title text-right"><strong>Grand Total</strong></h6>
                                                MYR <span id="grandtotal"></span>
                                            </td>
                                            @if(auth()->guard('customer')->check())
                                            <input type="hidden" value="{{ $grandtotal-($grandtotal*($customer->discount/100)) }}" name="totaltotal" id="totaltotal">
                                            @else
                                            <input type="hidden" value="{{ $grandtotal }}" name="totaltotal" id="totaltotal">
                                            @endif
                                            <input type="hidden" value="" name="serviceid" id="serviceid">
                                            <input type="hidden" value="" name="parsalcost" id="parsalcost">
                                            <input type="hidden" value="" name="couriername" id="couriername">
                                            <input type="hidden" value="" name="delivery" id="delivery">
                                            <input type="hidden" value="" name="courierlogo" id="courierlogo">
                                            <input type="hidden" value="" name="pointid" id="pointid">
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <hr />
                                            <ul>
                                              <li style="border-bottom: 1px solid #999; line-height: 40px;"><input type="radio" name="paymentmethod" value="esewa" required>eSewa
                                                    <div class="esewa box">
                                                        <img class="guarantee__safe--checkout__img" src="{{ asset('site/assets/img/other/onlinepayment.jpg') }}" alt="Payment Image" style="margin-top: 5px;" width="200">
                                                    </div>
                                                </li>
                                                <li style="border-bottom: 1px solid #999; line-height: 40px;"><input type="radio" name="paymentmethod" value="online" required>Online Payment
                                                    <div class="online box">
                                                        <img class="guarantee__safe--checkout__img" src="{{ asset('site/assets/img/other/onlinepayment.jpg') }}" alt="Payment Image" style="margin-top: 5px;" width="200">
                                                    </div>
                                                </li>
                                                
                                                <li style="border-bottom: 1px solid #999; line-height: 40px;"><input type="radio" name="paymentmethod" value="paypal" required> Paypal
                                                    <div class="paypal box">
                                                        <img class="guarantee__safe--checkout__img" src="{{ asset('site/images/paypal.png') }}" alt="Payment Image" width="200" style="margin-top: 5px;">
                                                    </div>
                                                </li>
                                                <li style="border-bottom: 1px solid #999; line-height: 40px;"><input type="radio" name="paymentmethod" value="directbank" required> Direct Bank Transfer
                                                    <div class="directbank box">
                                                        <p>
                                                            Bank name: <strong>Maybank</strong> <br />
                                                            Account Number: <strong>557401547777</strong> <br />
                                                            Beneficiery Name: <strong>PMA SME FIRST</strong>
                                                        </p>
                                                        <p style="line-height:20px; color:red;">Note: For Order Confirmation after successfully bank transfer please send your bank slip to +6012 654 1955</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        @if($checkout == 'Y')
                                            <input type="submit" class="btn primary__btn" style="width: 100%; text-align: center; margin-top: 15px;" value="Confirm">
                                        @else
                                        <input type="submit" class="btn primary__btn" style="width: 100%; text-align: center; margin-top: 15px;" value="Confirm" disabled>
                                        <small>Unable be shipped to your location. Please change your shipping location.</small>
                                        @endif
                                            <br /> <br />
                                        
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            
        </form>
        </div>
    </div>
</div>
<div class="modal" id="modal-123" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row row-cols-lg-12 row-cols-md-12">
                <div class="col">
                    <div class="quickview__info">
                        <div class="newsletter__popup--box__right" style="width: 100%;">
                            <h2 class="newsletter__popup--title">Modify Your Shipping Address</h2>
                            <div class="newsletter__popup--content">
                                @if(Session::has('status'))
                                <label class="newsletter__popup--content--desc"><img src="{{ asset('site/assets/img/icon/lamp.png') }}" alt=""> {{ Session::get('status') }}</label>
                                @endif
                                <div class="newsletter__popup--subscribe" id="frm_subscribe">
                                    <form action="{{ route('postShiipingAddressToSession') }}" method="POST" class="newsletter__popup--subscribe__form">
                                        @csrf()
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="ccountry" id="modifycountry" class="newsletter__popup--subscribe__input">
                                                    @php $countryS = App\Models\Country::where('id', $scountry)->limit(1)->first(); @endphp
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" @php if($country->id == $countryS->id ){ echo 'selected'; } @endphp>{{ $country->name }}</option>
                                                        @endforeach                      
                                                </select>
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <select name="cstate" id="modifystate" class="modifystate newsletter__popup--subscribe__input">
                                                    @foreach($states as $state1)
                                                        <option value="{{ $state1->id }}" @php if($sstate == $state1->id){ echo 'selected'; } @endphp>{{ $state1->name }}</option>
                                                    @endforeach
                                                     <input class="boxmodify newsletter__popup--subscribe__input" placeholder="State" name="stateother" id="stateother" type="text" value="{{ $sstate }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="newsletter__popup--subscribe__input" name="ccity" type="text" placeholder="Shipping City" value="{{ $scity }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="newsletter__popup--subscribe__input" name="cpostalcode" type="text" placeholder="Shipping Postal Code" value="{{ $spostal }}" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="newsletter__popup--subscribe__btn">Confirm</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".box").not(targetBox).hide();
            $(targetBox).show();
        });
    });
    </script>
<script>
    function doit() {
        document.getElementById("firstname").value = document.getElementById("bfirstname").value;
        document.getElementById("lastname").value = document.getElementById("blastname").value;
        document.getElementById("address").value = document.getElementById("baddress").value;
        document.getElementById("address1").value = document.getElementById("baddress1").value;
        document.getElementById("shippingmobile").value = document.getElementById("bmobile").value;
        }
</script>
<script>
    $(document).ready(function(){
        var optionValue1 = document.getElementById("bcountry").value;
        if(optionValue1 != '136'){
            $(".box1").show();
            $(".bstate").hide();
        }
        else{
                $(".box1").hide();
                $(".bstate").show();
            }

        $('#bcountry').on('change', function() {
        var optionValue = this.value;
        if(optionValue != '136' ){
            $(".box1").show();
            $(".bstate").hide();
            
            }
            else{
                $(".box1").hide();
                $(".bstate").show();
            }
});
    });
</script>
<script>
    $(document).ready(function(){
        var shippingcountry = document.getElementById("shippingcountry").value;
       
        if(shippingcountry != '136'){
            $(".shippingotherstate").show();
            $(".shippingstate").hide();
        }
        else{
                $(".shippingstate").show();
                $(".shippingotherstate").hide();
            }

        $('#bcountry').on('change', function() {
        var shippingcountry2 = this.value;
        if(shippingcountry2 != '136' ){
            $(".shippingotherstate").show();
            $(".shippingstate").hide();
            
            }
            else{
                $(".shippingstate").show();
                $(".shippingotherstate").hide();
            }
});
    });
</script>
<script> 
    $(document).ready(function(){
        var optionValue1 = document.getElementById("modifycountry").value;
        if(optionValue1 != '136'){
            $(".boxmodify").show();
            $(".modifystate").hide();
        }
        else{
                $(".boxmodify").hide();
                $(".modifystate").show();
            }

        $('#modifycountry').on('change', function() {
        var optionValue = this.value;
        if(optionValue != '136' ){
            $(".boxmodify").show();
            $(".modifystate").hide();
            
            }
            else{
                $(".boxmodify").hide();
                $(".modifystate").show();
            }
});
    });
    </script>
    <script>
         $(document).ready(function(){
            var selectedagenct = document.getElementById("selectedagent").value;
            // alert(selectedagenct);
            var splid = selectedagenct.split("?");
            var serviceid =splid[0];
            var shippingcost = splid[1];
            var couriername = splid[2];
            var delivery = splid[3];
            var courierlogo = splid[4];
            var pointid = splid[5];

            
            var totalcost = document.getElementById("totaltotal").value;
            
            
            // alert(selectedagenct);
            var totalcost = parseFloat(shippingcost)+parseFloat(totalcost);
            document.getElementById("grandtotal").innerHTML = totalcost;
            document.getElementById("serviceid").value = serviceid;
            document.getElementById("parsalcost").value = shippingcost;
            document.getElementById("couriername").value = couriername;
            document.getElementById("delivery").value = delivery;
            document.getElementById("courierlogo").value = courierlogo;
            document.getElementById("pointid").value = pointid;
            $('#selectedagent').on('change', function() {
                
                var selectedagenct = document.getElementById("selectedagent").value;
                    var splid = selectedagenct.split("?");
                    var shippingcost = splid[1];
                    var serviceid =splid[0];
                var totalcost = document.getElementById("totaltotal").value;
                var totalcost1 = parseFloat(shippingcost)+parseFloat(totalcost);
                document.getElementById("grandtotal").innerHTML = totalcost1;
                document.getElementById("serviceid").value = serviceid;
                document.getElementById("parsalcost").value = shippingcost;
                document.getElementById("couriername").value = couriername;
                document.getElementById("delivery").value = delivery;
                document.getElementById("courierlogo").value = courierlogo;
            });
            $('#usedcoupon').on('click', function() {
                let code = document.getElementById("couponcode").value;
                let totalcost11 = document.getElementById("totaltotal").value;
                
                $.ajax({
                url: "/customer/ajax/checkcoupon",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    code:code,
                    totalcost11:totalcost11
                },
                success:function(response){
                    var selectedagenct = document.getElementById("selectedagent").value;
                    var splid = selectedagenct.split("?");
                    var shippingcost = splid[1];
                    var serviceid =splid[0];
                    var codeamount1 = response.codeamount;
                    var amounttype = response.amounttype;
                    var min_cost_apply = response.min_cost_apply;
                    var totalcost = document.getElementById("totaltotal").value;
                    if(totalcost >= min_cost_apply){
                        if(amounttype === 'percentage'){
                            var codeamounttocost =  (totalcost*codeamount1)/100;
                            var totalcost1 = (parseFloat(shippingcost)+parseFloat(totalcost))-parseFloat(codeamounttocost);
                        }
                        else{
                            var totalcost1 = (parseFloat(shippingcost)+parseFloat(totalcost))-parseFloat(codeamount1);
                        }
                    }
                    else{
                        var totalcost1 = (parseFloat(shippingcost)+parseFloat(totalcost));
                    }
               
                
                document.getElementById("grandtotal").innerHTML = totalcost1;
                document.getElementById("serviceid").value = serviceid;
                document.getElementById("parsalcost").value = shippingcost;
                document.getElementById("couriername").value = couriername;
                document.getElementById("delivery").value = delivery;
                document.getElementById("courierlogo").value = courierlogo;
                document.getElementById("couponmsg").innerHTML = response.status;
                document.getElementById("costmsg").innerHTML = response.msg;
                  
                   
                   
                },
      
      });
            });
         });
    </script>

@endsection