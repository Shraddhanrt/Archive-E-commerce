@extends('site.template', ['title' => __('Carts')])
@section('css')
<style>
    .otherstatebox{
    display: none;
}
</style>
@stop
@section('content')
<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- cart section start -->
<section class="cart__section section--padding">
    <div class="container-fluid">
        <div class="cart__section--inner">
            @if(Session::get('cartcode'))
                <h2 class="cart__title mb-40">Shopping Cart</h2>
                @if(Session::has('message'))
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="alert alert-danger" role="alert" style="background-color: orange; padding: 15px; margin-bottom: 20px;">
                           <img src="{{ asset('site/assets/img/icon/lamp.png') }}" alt=""> {{ Session::get('message') }}
                          </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $getcarts = App\Models\Cart::where('code', Session::get('cartcode'))->get();
                        $grandtotal = App\Models\Cart::where('code', Session::get('cartcode'))->sum('totalcost');
                        ?>
                        <div class="cart__table">
                            <table class="cart__table--inner">
                                <thead class="cart__table--header">
                                    <tr class="cart__table--header__items">
                                        <th class="cart__table--header__list">Product</th>
                                        <th class="cart__table--header__list">Price</th>
                                        <th class="cart__table--header__list">Quantity</th>
                                        <th class="cart__table--header__list">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="cart__table--body">
                                    @foreach($getcarts as $cart)
                                	<?php $getproduct = App\Models\Product::where('id', $cart->product_id)->limit(1)->first(); ?>
                                    <tr class="cart__table--body__items">
                                        <td class="cart__table--body__list">
                                            <div class="cart__product d-flex align-items-center">
                                                <a href="{{ route('getDeleteCart', $cart->id) }}" class="cart__remove--btn" aria-label="search button" type="button">
                                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg>
                                                </a>
                                                <div class="cart__thumbnail">
                                                    <a href=""><img class="border-radius-5" src="{{ asset('site/uploads/products/'.$getproduct->photo) }}" alt="cart-product"></a>
                                                </div>
                                                <div class="cart__content">
                                                    <h4 class="cart__content--title"><a href="product-details.html">{{ $getproduct->name }}</a></h4>
                                                    <span class="cart__content--variant">WEIGHT: {{ $cart->weight }} Kg</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <span class="cart__price">MYR {{ $getproduct->dcost }}</span>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <div class="quantdity__box">
                                               <form action="{{ route('postEditCart', $cart->id) }}" method="POST">
                                                   @csrf()
                                                <input type="number" name="qty" class="quantity__number quickview__value--number" value="{{ $cart->qty }}" data-counter/>
                                                <input type="hidden" value="NP">
                                                <input type="submit" value="UPDATE" style="background: #db980f; border: none; color: #fff;">
                                                </form>
                                               
                                            </div>
                                        </td>
                                        <td class="cart__table--body__list">
                                            <span class="cart__price end">MYR {{ $cart->totalcost }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                            <div class="continue__shopping d-flex justify-content-between">
                                <a class="continue__shopping--link" href="{{ route('getHome') }}">Continue shopping</a>
                                <a class="continue__shopping--clear" href="{{ route('getClearCarts') }}">Clear Cart</a>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10">
                            
                           
                            <div class="cart__summary--total mb-20">
                                <table class="cart__summary--total__table">
                                    <tbody>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                            <td class="cart__summary--amount text-right">MYR {{ $grandtotal }}</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">GRAND TOTAL</td>
                                            <td class="cart__summary--amount text-right">MYR {{ $grandtotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart__summary--footer">
                                <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout</p>
                                <ul class="d-flex justify-content-between">
                                    @if($grandtotal>0)
                                    <li><a class="cart__summary--footer__btn primary__btn checkout" href="{{ route('getCheckOut') }}">Check Out</a></li>
                                    @else
                                    <li><a class="cart__summary--footer__btn primary__btn checkout" href="{{ route('getProducts') }}">Your Cart empty</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div> 
            @else
                <h3>Your Carts Empty!!!</h3>
            @endif
        </div>
    </div>     
</section>
<div class="modal" id="forgetpassword" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row">
                <div class="col">
                    <div class="account__login">
                        <div class="account__login--header mb-25">
                            <h2 class="account__login--header__title h3 mb-10">Forgot Password</h2>
                            <!-- <p class="account__login--header__desc">New password will be receive in email</p> -->
                        </div>
                        <div class="account__login--inner">
                            <form action="{{ route('postForgotPassword') }}" method="POST">
                                @csrf()
                            <input class="account__login--input" placeholder="Email Address" name="email" type="email">
                            <button class="account__login--btn primary__btn" type="submit">Login</button>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if( !auth()->guard('customer')->check())

<div class="newsletter__popup" id="login" data-animation="slideInUp">
    <div id="boxes" class="newsletter__popup--inner">
        <button class="newsletter__popup--close__btn" aria-label="search close button">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path></svg>
        </button>
        <div class="box newsletter__popup--box d-flex align-items-center">
            
            <div class="newsletter__popup--box__right" style="width: 100%;">
                <div class="newsletter__popup--content">
                    <div class="newsletter__popup--subscribe" id="frm_subscribe">
                        <div class="login__section--inner">
                            @if(Session::has('status'))
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="alert alert-danger" role="alert" style="background-color: orange; padding: 15px; margin-bottom: 20px;">
                                       <img src="{{ asset('site/assets/img/icon/lamp.png') }}" alt=""> {{ Session::get('status') }}
                                      </div>
                                </div>
                            </div>
                            @endif
                            <div class="row row-cols-md-2 row-cols-1">
                                <div class="col">
                                    <div class="account__login">
                                        <div class="account__login--header mb-25">
                                            <h2 class="account__login--header__title h3 mb-10">Customer Login</h2>
                                        </div>
                                        <div class="account__login--inner">
                                            <form action="{{ route('postCustomerLogin') }}" method="POST" autocomplete="off">
                                                @csrf()
                                            <input class="account__login--input" placeholder="Email Address" name="email" type="email">
                                            <input class="account__login--input" placeholder="Password" name="password" type="password">
                                            <input type="hidden" value="getCart" name="returnurl">
                                            <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                                <div class="account__login--remember position__relative">
                                                    <input class="checkout__checkbox--input" id="check1" type="checkbox">
                                                    <span class="checkout__checkbox--checkmark"></span>
                                                    <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                        Remember me</label>
                                                </div>
                                                <a class="account__login--forgot" href="{{ route('getCustomerLogin') }}">Forgot Your Password?</a>
                                            </div>
                                            <button class="account__login--btn primary__btn" type="submit">Login</button>
                                            
                                           </form>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="account__login register">
                                        <div class="account__login--header mb-25">
                                            <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                        </div>
                                        <div class="account__login--inner">
                                            <form action="{{ route('postCustomerRegister') }}" method="POST" autocomplete="off">
                                                @csrf()
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="account__login--input" placeholder="First Name" name="fname" type="text" required>
                                                        @error('fname')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="account__login--input" placeholder="Last Name" name="lname" type="text" required>
                                                        @error('lname')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <input class="account__login--input" placeholder="Email Address" name="email" type="email" required>
                                                        @error('email')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                <input class="account__login--input" placeholder="Password" name="password" type="password" required>
                                                    @error('password')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                <input class="account__login--input" placeholder="Mobile Number" name="mobile" type="number" required>
                                                    @error('mobile')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                <input type="hidden" name="returnurl" value="getCart">
                                                <button class="account__login--btn primary__btn mb-10" type="submit">Register</button>
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
    </div>
</div>
@endif
@if(!auth()->guard('customer')->check() || Session::get('shipping'))
<div class="modal" id="modal-shipping" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row">
                <div class="col">
                    <div class="box newsletter__popup--box d-flex align-items-center">
            
                        <div class="newsletter__popup--box__right" style="width: 100%;">
                            <h2 class="newsletter__popup--title">Confirm Your Shipping Address</h2>
                            <div class="newsletter__popup--content">
                                @if(Session::has('status'))
                                <label class="newsletter__popup--content--desc"><img src="{{ asset('site/assets/img/icon/lamp.png') }}" alt=""> {{ Session::get('status') }}</label>
                                @endif
                                <div class="newsletter__popup--subscribe" id="frm_subscribe">
                                    <form action="{{ route('postShiipingAddressToSession') }}" method="POST" class="newsletter__popup--subscribe__form">
                                        @csrf()
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="ccountry" id="bcountry" class="newsletter__popup--subscribe__input">
                                                                        @foreach($countries as $country)
                                                                        <option value="{{ $country->id }}" @php if($country->code == 'MY'){ echo 'selected'; } @endphp>{{ $country->name }}</option>
                                                                        @endforeach
                                                                        
                                                </select>
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <select name="cstate" id="bstate" class="bstate newsletter__popup--subscribe__input">
                                                                            <option value="">Select State</option>
                                                                            @foreach($states as $state)
                                                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                                            @endforeach
                                                </select>
                                                <input class="otherstatebox newsletter__popup--subscribe__input" placeholder="State" name="stateother" id="stateother"  type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="newsletter__popup--subscribe__input" name="ccity" type="text" placeholder="Shipping City" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="newsletter__popup--subscribe__input" name="cpostalcode" type="text" placeholder="Shipping Postal Code" required>
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
@endif


@stop
@section('js')
<script>
    $('#loginasguest').on('click', function(){
        var element = document.getElementById("login");
        element.classList.remove("newsletter__show");
       
    });
</script>
<script>
   
        $('#bcountry').on('change', function() {
        var optionValue = this.value;
        if(optionValue != '136' ){
            $(".otherstatebox").show();
            $(".bstate").hide();
            
            }
            else{
                $(".otherstatebox").hide();
                $(".bstate").show();
            }
});
  
    </script>
@stop