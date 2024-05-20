@extends('site.template', ['title' => __('Customer Dashboard')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">My Account</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">My Account</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- my account section start -->
<section class="my__account--section section--padding">
    <div class="container">
        <div class="my__account--section__inner border-radius-10 d-flex">
            <div class="account__left--sidebar">
                <h2 class="account__content--title h3 mb-20">My Profile</h2>
                <ul class="account__menu">
                    <li class="account__menu--list"><a href="{{ route('getCustomerDashboard') }}">Dashboard</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerOrderHistory') }}">Order History</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerProfile') }}">Address</a></li>
                    <li class="account__menu--list active"><a href="{{ route('getCustomerpasswordChange') }}">Password Change</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerLogOut') }}">Log Out</a></li>
                </ul>
            </div>
            <div class="account__wrapper">
                <div class="account__content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact__foasdrm">
                                <h3 class="contact__form--title" style="color: orange;">Password Change</h3>
                                <br />
                                <form class="contact__form--inner" action="{{ route('postPasswordChange') }}" method="POST">
                                    @csrf()
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input1">New Password <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="password" id="input1" type="password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input2">Confirm Password <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="cpassword" id="input2" type="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="contact__form--btn primary__btn" type="submit">Update Password</button>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
