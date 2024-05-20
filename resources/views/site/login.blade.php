@extends('site.template', ['title' => __('Customer Login')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Customer Login/Register</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Login/Register</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- Start login section  -->
<div class="login__section section--padding">
    <div class="container">
        
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
                                <h2 class="account__login--header__title h3 mb-10">Account Login</h2>
                                <!-- <p class="account__login--header__desc">Login if you area a returning customer.</p> -->
                            </div>
                            <div class="account__login--inner">
                                <form action="{{ route('postCustomerLogin') }}" method="POST" autocomplete="off">
                                    @csrf()
                                <input class="account__login--input" placeholder="Email Address" name="email" type="email">
                                <input class="account__login--input" placeholder="Password" name="password" type="password">
                                @if(isset($_GET['returnurl']))
                                        <input type="hidden" name="returnurl" value="<?php echo $_GET['returnurl']; ?>">
                                        <input type="hidden" name="type" value="email">
                                        @else
                                        <input type="hidden" name="returnurl" value="getCustomerDashboard">
                                        <input type="hidden" name="type" value="none">
                                        @endif
                                
                                <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                    <div class="account__login--remember position__relative">
                                        <input class="checkout__checkbox--input" id="check1" type="checkbox">
                                        <span class="checkout__checkbox--checkmark"></span>
                                        <label class="checkout__checkbox--label login__remember--label" for="check1">
                                            Remember me</label>
                                    </div>
                                    <a class="account__login--forgot" data-open="forgetpassword" href="javascript:void(0)">Forgot Your Password?</a>
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
                                <p class="account__login--header__desc">Place orders quickly and easily.</p>
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
                                    <input type="hidden" name="returnurl" value="getCustomerLogin">
                                    <button class="account__login--btn primary__btn mb-10" type="submit">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      
    </div>     
</div>
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
                            <button class="account__login--btn primary__btn" type="submit">Submit</button>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop