@extends('site.template', ['title' => __('Customer Order History')])
@section('css')
<style>

.logotype{background:#000;color:#fff;width:75px;height:75px;  line-height: 75px; text-align: center; font-size:11px;}
.column-title{background:#eee;text-transform:uppercase;padding:15px 5px 15px 15px;font-size:11px}
.column-detail{border-top:1px solid #eee;border-bottom:1px solid #eee;}
.column-header{background:#eee;text-transform:uppercase;padding:15px;font-size:11px;border-right:1px solid #eee;}
.row2{padding:7px 14px;border-left:1px solid #eee;border-right:1px solid #eee;border-bottom:1px solid #eee;}
.alert{background: #ffd9e8;padding:20px;margin:20px 0;line-height:22px;color:#333}
.socialmedia{background:#eee;padding:20px; display:inline-block}
</style>
@stop
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">My Order History</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">My Orders</span></li>
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
                    <li class="account__menu--list active"><a href="{{ route('getCustomerOrderHistory') }}">Order History</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerprofile') }}">Address</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerpasswordChange') }}">Password Change</a></li>
                    <li class="account__menu--list"><a href="{{ route('getCustomerLogOut') }}">Log Out</a></li>
                </ul>
            </div>
            <div class="account__wrapper">
                <div class="account__content">
                    <div class="row">
                        <table class="account__table">
                            <thead class="account__table--header">
                              <tr class="account__table--header__child">
                                <th class="account__table--header__child--items">Date</th>
                                <th class="account__table--header__child--items">Receiver Name</th>
                                <th class="account__table--header__child--items">Total Cost</th>
                                <th class="account__table--header__child--items">Status</th>
                                <th class="account__table--header__child--items"></th>
                              </tr>
                            </thead>
                            <tbody class="account__table--body">
                              @if($orders->count())
                                @foreach($orders as $order)
                              <tr class="account__table--body__child">
                                <td class="account__table--body__child--items">{{ $order->created_at->format('d M, Y') }}</td>
                                <td class="account__table--body__child--items">{{ $order->receiver_fname }} {{ $order->receiver_lname }}</td>
                                <td class="account__table--body__child--items">MYR {{ $order->grandtotal }}</td>
                                <td class="account__table--body__child--items">
                                  @if($order->paymentstatus == 'Y')
                                    Paid  
                                     <!-- | {{ $order->order_status }} -->
                                  @else
                                    Unpaid | <a href="{{ route('getConfirm', $order->code.'?type=laterpay&order='.$order->code) }}"><u><b>Pay Now</b></u></a>
                                  @endif
                                  </td>
                                <!-- <td class="account__table--body__child--items"><a class="contact__form--btn primary__btn" id="order-details11" data-open="order-detail2" href="javascript:void(0)">View Detail</a></td> -->
                                <td class="account__table--body__child--items"><button class="contact__form--btn primary__btn order-details" data-id="{{ $order->code }}" id="order-details">View Detail</button></td>
                              </tr>
                            @endforeach
                            @else
                            <tr class="account__table--body__child">
                              <td colspan="5" class="account__table--body__child--items" style="text-align:center;">No order </td>
                            </tr>
                            @endif
                            </tbody>
                          </table>
                          
                          
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal" id="order-detail2" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row">
                <div class="col">
                    <div class="box newsletter__popup--box d-flex align-items-center">
            
                        <div class="container">

                            <table width="100%">
                              <tr>
                                <td width="100px"><div class="logotype"><img src="{{ asset('site/assets/img/logo/newlogo1.jpg') }}" alt=""></div></td>
                                <td width="300px"><div style="background: #ffd9e8;border-left: 15px solid #fff;padding-left: 30px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 73px;line-height: 75px;">Order invoice</div></td>
                                <td></td>
                              </tr>
                            </table> 
                            <br><br>
                            
                            <table width="100%" style="border-collapse: collapse;">
                              <tr>
                                <td widdth="50%" style="background:#eee;padding:20px;">
                                  <strong>Order Date:</strong> <span id="orderdate"></span><br>
                                  <strong>Payment type:</strong> <span id="orderpaymenttype"></span><br>
                                  
                                </td>
                                <td style="background:#eee;padding:20px;">
                                  <strong>Order-nr:</strong> <span id="ordernumber"></span>-<span id="ordercode"></span><br>
                                  <strong>Delivery Agent:</strong> <span id="ordershipping"></span><br>
                                  <small><span id="delivery_range"></span></small>
                                </td>
                              </tr>
                            </table><br>
                            <table width="100%">
                              <tr>
                                <td>
                                  <table>
                                    <tr>
                                      <td style="vertical-align: text-top;">
                                        <div style="background: #ffd9e8 url(https://cdn0.iconfinder.com/data/icons/commerce-line-1/512/comerce_delivery_shop_business-07-128.png);width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 42px;"></div>   
                                      </td>
                                      <td>
                                        <strong>Buyer Information</strong><br>
                                        <span id="buyer_fname"></span> <span id="buyer_lname"></span><br>
                                        <span id="buyer_address"></span><br>
                                        <span id="buyer_mobile"></span><br>
                                        <span id="buyer_email"></span><br>
                                        
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td>
                                  <table>
                                    <tr>
                                      <td style="vertical-align: text-top;">
                                        <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/app-custom-ui-1/48/Check_circle-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;"></div>   
                                      </td>
                                      <td>
                                        <strong>Shipping Information</strong><br>
                                        <span id="receiver_fname"></span> <span id="receiver_lname"></span><br>
                                        <span id="receiver_address"></span><br>
                                        <span id="receiver_mobile"></span><br>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table><br>
                            <table width="100%" style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">
                              <tr>
                                <td><h3>Order Status : <span id="orderpaymentstatus"></span> </h3><td>
                              </tr>
                            </table><br>
                            <div style="background: #ffd9e8 url(https://cdn4.iconfinder.com/data/icons/basic-ui-2-line/32/shopping-cart-shop-drop-trolly-128.png) no-repeat;width: 50px;height: 50px;margin-right: 10px;background-position: center;background-size: 25px;float: left; margin-bottom: 15px;"></div> 
                            <h3>Items</h3>
                            <span style="display: inherit;" id="carts"></span>
                            <br>
                            <span id="costing"></span>
                          </div><!-- container -->
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).on('click', '.order-details', function() {
        var codeid = $(this).data('id');
        var element = document.getElementById("order-detail2");
        element.classList.add("is-visible");

        $.ajax({
          url: "/getorderdetail/ajax",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            codeid:codeid,
          },
          success: function(response){ 
            if(response.order.paymentstatus === 'Y'){
                var paymentstatus = 'Paid';
            }
            else{
                var paymentstatus = 'Unpaid';
            }
            $('#orderdate').html(response.order.created_at);
            $('#ordernumber').html(response.order.id);
            $('#ordercode').html(response.order.code);
            $('#orderpaymenttype').html(response.order.paymentmethod);
            $('#ordershipping').html(response.order.shippingcompany);
            $('#delivery_range').html(response.order.delivery_range);
            $('#buyer_fname').html(response.order.buyer_fname);
            $('#buyer_lname').html(response.order.buyer_lname);
            $('#buyer_address').html(response.order.buyer_address);
            $('#buyer_mobile').html(response.order.buyer_mobile);
            $('#buyer_email').html(response.order.buyer_email);
            $('#receiver_fname').html(response.order.receiver_fname);
            $('#receiver_lname').html(response.order.receiver_fname);
            $('#receiver_address').html(response.order.receiver_address);
            $('#receiver_mobile').html(response.order.receiver_mobile);
            $('#orderpaymentstatus').html(paymentstatus);
            $('#carts').html(response.carts);
            $('#costing').html(response.costing);
             
            }
         
         });

})
    
</script>

@stop
