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
                    <li class="account__menu--list active"><a href="{{ route('getCustomerprofile') }}">Address</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerpasswordChange') }}">Password Change</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerLogOut') }}">Log Out</a></li>
                </ul>
            </div>
            <div class="account__wrapper">
                <div class="account__content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact__foasdrm">
                                <h3 class="contact__form--title" style="color: orange;">Buyer Information</h3>
                                <strong>{{ $customer->fname }} {{ $customer->lname }}</strong> <br />
                                    {{ $customer->address }} <br />
                                    @php $bcountry = App\Models\Country::where('id', $customer->country)->limit(1)->first(); @endphp
                                    {{ $bcountry->name}} <br />
                                    {{ $customer->email }}<br />
                                    {{ $customer->mobile }} <br />
                                    <a href="{{ route('getBuyerInformationEdit') }}" class="contact__form--btn primary__btn">Edit Buyer Information</a>
                                    @if($customer->fname == null AND $customer->lname == null AND $customer->address == null AND $customer->state == null AND $customer->city == null AND $customer->postalcode == null AND $customer->mobile == null)
                                        <br /><small>Your Profile not updated.</small>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact__foasdrm">
                                <h3 class="contact__form--title" style="color: orange;">Default Shipping Address</h3>
                                <strong>{{ $customer->sfname }} {{ $customer->slname }}</strong> <br />
                                    {{ $customer->saddress }} <br />
                                    @php $scountry = App\Models\Country::where('id', $customer->scountry)->limit(1)->first(); @endphp
                                    {{ $scountry->name }} <br /> <br />
                                    {{ $customer->smobile }} <br />
                                    <a href="{{ route('getShippingInformationEdit') }}" class="contact__form--btn primary__btn">Edit Shipping Information</a>
                                    @if($customer->sfname == null AND $customer->slname == null AND $customer->saddress == null AND $customer->sstate == null AND $customer->scity == null AND $customer->spostal == null AND $customer->smobile == null)
                                        <br /><small>Your Shipping information not updated.</small>
                                    @endif
                            </div>
                   
                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('js')
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
@stop