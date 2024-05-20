@extends('site.template', ['title' => __('Customer Login')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Reset Password</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Reset Password</span></li>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="account__login">
                            <div class="account__login--header mb-25">
                                <h2 class="account__login--header__title h3 mb-10">Reset Password</h2>
                                <!-- <p class="account__login--header__desc">Login if you area a returning customer.</p> -->
                            </div>
                            <div class="account__login--inner">
                                <form action="{{ route('postPassportReset', $code) }}" method="POST">
                                    @csrf()
                                
                                <input class="account__login--input" placeholder="New Password" name="password" type="password" required>
                                @error('password')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="code" value="{{ $code }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input class="account__login--input" placeholder="Confirm Password" name="password_confirmation" type="password" required>
                                @error('cpassword')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                <button class="account__login--btn primary__btn" type="submit">Reset</button>
                               </form>
                               
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
      
    </div>     
</div>
@stop