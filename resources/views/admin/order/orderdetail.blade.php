@extends('layouts.app', ['title' => __('Manage Category')])
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<style>
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}

    </style>
@stop
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
        </div>
    </div>
</div>
   
    <!-- Topnav -->
    
    <!-- Header -->
    <!-- Header -->
   
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-md-4">
                    <h3 class="mb-0">Manage Orders</h3>
                  </div>
                  <div class="col-md-8" style="text-align: right;">
                    @if($order->paymentstatus == 'N')
                      <a href="{{ route('getMakeAsPaid', $order->id) }}" class="btn btn-primary">Mark as a Paid</a>
                    @else
                    <a class="btn btn-primary" aria-disabled>Paid</a>
                    @endif
                    @if($order->paymentstatus == 'Y')
                        @if($order->order_status == 'Pending')
                        <a href=""><img src="{{ asset('site/images/pendingorder.png') }}" alt="" width="60"> Order Pending</a>
                        @elseif($order->order_status == 'Shipped')
                            <a href=""><img src="{{ asset('site/images/delivered.png') }}" alt="" width="60"> Order Delivered</a>
                        @else
                            <a href=""><img src="{{ asset('site/images/ordercomplete.png') }}" alt="" width="60">Order Completed</a>
                        @endif
                    @endif
                  </div>
              </div>
            </div>
            @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
            <!-- Light table -->
            <div class="page-content container">
            
                <div class="container px-0">
                    <div class="row mt-4">
                        <div class="col-12 col-lg-12">
                           
            
                            <hr class="row brc-default-l1 mx-n1 mb-4" />
            
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5>Buying Information</h5>
                                    <div>
                                        <span class="text-600 text-110 text-blue align-middle">{{ $order->buyer_fname }} {{ $order->buyer_lname }}</span>
                                    </div>
                                    <div class="text-grey-m2">
                                        <div class="my-1">
                                            {{ $order->buyer_address }}
                                        </div>
                                        <div class="my-1">
                                            {{ $order->buyer_postal_code }}, {{ $order->buyer_state }}, {{ $order->buyer_country }}
                                        </div>
                                        <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">{{ $order->buyer_mobile }}</b></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h5>Shipping Information</h5>
                                    <div>
                                        
                                        <span class="text-600 text-110 text-blue align-middle">{{ $order->receiver_fname }} {{ $order->receiver_lname }}</span>
                                    </div>
                                    <div class="text-grey-m2">
                                        <div class="my-1">
                                            {{ $order->receiver_address }}, {{ $order->receiver_address1 }}
                                        </div>
                                        <div class="my-1">
                                            {{ $order->receiver_postal_code }}, {{ $order->receiver_state }}, {{ $order->receiver_city }}
                                        </div>
                                        <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">{{ $order->receiver_mobile }}</b></div>
                                    </div>
                                </div>
            
                                <div class="text-95 col-sm-4 align-self-start d-sm-flex justify-content-end">
                                    <hr class="d-sm-none" />
                                    <div class="text-grey-m2">
                                        <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                            Invoice : ID: #RITZ-{{ $order->id }}
                                        </div>
                                        
            
                                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Order Id:</span> #{{ $order->id }}-{{ $order->code }}</div>
            
                                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Order Date:</span> {{ $order->created_at->format('d M, Y') }}</div>
            
                                        <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span class="badge badge-warning badge-pill px-25" style="color: #000;">
                                        @if($order->paymentstatus == 'Y')
                                            Paid via {{ $order->paymentmethod }}
                                        @else
                                            Pending Payment
                                        @endif
                                        </span></div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
            
                            <div class="mt-4">
                                <div class="row text-600 text-white bgc-default-tp1 py-25">
                                    <div class="d-none d-sm-block col-1">#</div>
                                    <div class="col-9 col-sm-5">Description</div>
                                    <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                                    <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                                    <div class="col-2">Amount</div>
                                </div>
            
                                <div class="text-95 text-secondary-d3">
                                    @php
                                        $carts = App\Models\Cart::where('code', $order->code)->get();
                                    @endphp
                                    @foreach($carts as $cart)
                                    @php $product = App\Models\Product::where('id', $cart->product_id)->limit(1)->first(); @endphp
                                    <div class="row mb-2 mb-sm-0 py-25">
                                        <div class="d-none d-sm-block col-1">1</div>
                                        <div class="col-9 col-sm-5">{{ $product->name }}</div>
                                        <div class="d-none d-sm-block col-2">{{ $cart->qty }}</div>
                                        <div class="d-none d-sm-block col-2 text-95">MYR {{ $cart->cost }}</div>
                                        <div class="col-2 text-secondary-d2">MYR {{ $cart->totalcost }}</div>
                                    </div>
                                    @endforeach
            
                                    
            
                                    
            
                                    
                                </div>
            
                                <div class="row border-b-2 brc-default-l2"></div>
            
                                <!-- or use a table instead -->
                                
            
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                        <p>Payment Method : {{ $order->paymentmethod }}</p>
                                        <p>Shipping via {{ $order->shippingcompany }} with in {{ $order->delivery_range }}</p>
                                    </div>
            
                                    <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                SubTotal
                                            </div>
                                            <div class="col-5">
                                                <span class="text-120 text-secondary-d1">MYR {{ $order->producttotalcost }}</span>
                                            </div>
                                        </div>
            
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                Tax
                                            </div>
                                            <div class="col-5">
                                                <span class="text-110 text-secondary-d1">MYR {{ $order->tax }}</span>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                Shipping Charge
                                            </div>
                                            <div class="col-5">
                                                <span class="text-110 text-secondary-d1">MYR {{ $order->shippingcost }}</span>
                                            </div>
                                        </div>
                                        @if($order->coupon_id)
                                        @php $promocodedetail = App\Models\Coupon::where('id', $order->coupon_id)->limit(1)->first(); @endphp
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                Promo Code Discount
                                                @if($promocodedetail->amounttype == 'percentage')
                                                    <small style="display: block; color: blue;">{{$promocodedetail->code}} {{$promocodedetail->amount}}%</small>
                                                @else
                                                <small style="display: block; color: blue;">{{$promocodedetail->code}} MYR{{$promocodedetail->amount}}</small>
                                                @endif
                                            </div>
                                            <div class="col-5">
                                                <span class="text-110 text-secondary-d1"> - MYR {{ $order->discount }}</span>
                                            </div>
                                        </div>
                                        @endif
            
                                        <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                            <div class="col-7 text-right">
                                                Total Amount
                                            </div>
                                            <div class="col-5">
                                                <span class="text-150 text-success-d3 opacity-2">MYR {{ $order->grandtotal }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <hr />
            
                                <div>
                                    <span class="text-secondary-d1 text-105">This is computer generated invoice. No signature required.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card footer -->
            
          </div>
        </div>
      </div>
    </div>
    <!-- Button trigger modal -->


<!-- Modal -->

 
@endsection
@section('js')
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
@endsection