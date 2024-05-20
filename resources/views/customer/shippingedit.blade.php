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
                    <li class="account__menu--list active"><a href="{{ route('getCustomerProfile') }}">Address</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerpasswordChange') }}">Password Change</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerLogOut') }}">Log Out</a></li>
                </ul>
            </div>
            <div class="account__wrapper">
                <div class="account__content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact__foasdrm">
                                <h3 class="contact__form--title" style="color: orange;">Shipping Information</h3>
                                <br />
                                <form class="contact__form--inner" action="{{ route('postEditShippingInformation') }}" method="POST" autocomplete="off">
                                    @csrf()
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input1">First Name <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="firstname" id="input1" placeholder="Your First Name" type="text" value="{{ $customer->sfname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input2">Last Name <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="lastname" id="input2" placeholder="Your Last Name" type="text" value="{{ $customer->slname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">Address <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="address" id="input3" placeholder="Address" type="text" value="{{ $customer->saddress }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">Address II</label>
                                                <input class="contact__form--input" name="address2" id="input3" placeholder="Address II (optional)" type="text" value="{{ $customer->saddress2 }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <label class="contact__form--label" for="input2">Country <span class="contact__form--label__star">*</span></label>
                                            <div class="checkout__input--list checkout__input--select select">
                                                <label class="checkout__select--label" for="country">Country/region</label>
                                                <select class="checkout__input--select__field border-radius-5" required name="country" id="bcountry" style="border-color: orange; margin-bottom:10px">
                                                    @foreach($countries as $country)
                                                <option value="{{ $country->id }}" @php if($country->id == $customer->scountry){ echo 'selected';} @endphp>{{ $country->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="co-lg-6 col-md-6">
                                            <label class="contact__form--label" for="input2">State <span class="contact__form--label__star">*</span></label>
                                            <div class="bstate checkout__input--list checkout__input--select select">
                                                <label class="checkout__select--label" for="country">State</label>
                                                <select class="checkout__input--select__field border-radius-5" name="state" id="bstate" style="border-color: orange; margin-bottom:10px">
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" @php if($customer->sstate == $state->id){ echo 'selected'; } @endphp>{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input class="box1 checkout__input--field border-radius-5" placeholder="State" name="stateother" id="bstateother"  type="text" value="{{ $customer->sstate }}" style="border-color: orange;">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">City <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="city" id="input3" placeholder="City" type="text" value="{{ $customer->scity }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">Postal Code <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="postalcode" id="input3" placeholder="Postal Code" type="text" value="{{ $customer->spostal }}">
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-6 col-md-6">
                                            <div class="contact__form--list mb-20">
                                                <label class="contact__form--label" for="input3">Mobile Number <span class="contact__form--label__star">*</span></label>
                                                <input class="contact__form--input" name="mobile" id="input3" placeholder="Mobile Number" type="number" value="{{ $customer->smobile }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="contact__form--btn primary__btn" type="submit">Update</button>  
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