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
                    <li class="account__menu--list active"><a href="{{ route('getCustomerDashboard') }}">Dashboard</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerOrderHistory') }}">Order History</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerProfile') }}">Address</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerpasswordChange') }}">Password Change</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerLogOut') }}">Log Out</a></li>
                </ul>
            </div>
            <div class="account__wrapper">
                <div class="account__content">
                    <div class="row">
                        
                        <h3>Welcome to Customer Dashboard</h3>
                        <br /> <br />
                        @if(Session::get('cartcode'))
                            @php $getcartdetail = App\Models\Cart::where('code', Session::get('cartcode'))->get(); @endphp
                            @if($getcartdetail->count())
                            <div class="col-md-4" style="background-color: pink; text-align: center;">
                                <div class="" style="padding: 15px;">
                                 <a href="{{ route('getCart') }}">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewBox="0 0 14.706 13.534">
                                         <g  transform="translate(0 0)">
                                           <g >
                                             <path  data-name="Path 16787" d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z" transform="translate(0 -463.248)" fill="currentColor"/>
                                             <path  data-name="Path 16788" d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z" transform="translate(-1.191 -466.622)" fill="currentColor"/>
                                             <path  data-name="Path 16789" d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z" transform="translate(-2.875 -466.622)" fill="currentColor"/>
                                           </g>
                                         </g>
                                     </svg>
                                     <span style="display: block; color:blue">{{ $getcartdetail->count() }} item(s)</span>
                                     <span class="header__account--btn__text"> Your cart was ready for Checkout.</span>
                                    
                                 </a>
                                </div>
                             </div>
                             @endif
                        @endif
                       
                           
                            
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
