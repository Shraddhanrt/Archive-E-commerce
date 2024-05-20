@extends('layouts.app', ['title' => __('Manage Category')])
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
                    <h3 class="mb-0">Paid Orders</h3>
                  </div>
                  <div class="col-md-8" style="text-align: right;">
                      <a href="{{ route('getManageOrder') }}" class="btn btn-primary">All</a>
                      <a href="{{ route('getManagePaidOrder') }}" class="btn btn-primary">Paid Order</a>
                      <a href="{{ route('getManageUnpaidOrder') }}" class="btn btn-primary">Unpaid Order</a>
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
            <div class="table-responsive">
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th></th>
                      <th>Date</th>
                      <th>Buyer Info</th>
                      <th>Item Weight</th>
                      <th>Grand Total</th>
                      <!-- <th>Status</th> -->
                      <th>Payment Status</th>
                      <th>Courier</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="list">
  
                    @foreach($orders as $item)
                    @php
                      $cartitem = App\Models\Cart::where('code', $item->code)->count();
                      $country11 = App\Models\Country::where('id', $item->receiver_country)->limit(1)->first();
                   
                      
                    @endphp
                    <tr>
                      <th>
                       @if($item->paymentstatus == 'Y')
                       <a href="{{ route('getManageCourier', $item->id) }}">
                        @if($item->order_status == 'Pending')
                          <img src="{{ asset('site/assets/img/other/notshipping.png') }}" alt="" width="50">
                          @elseif($item->order_status == 'Shipped')
                          <img src="{{ asset('site/assets/img/other/shippingdone.png') }}" alt="" width="50">
                          @endif
                        </a>
                       @else
                       <a href="" onclick="return confirm('This order is not a paid order. Before manage courier make a paid');">
                        @if($item->order_status == 'Pending')
                          <img src="{{ asset('site/assets/img/other/notshipping.png') }}" alt="" width="50">
                          @elseif($item->order_status == 'Shipped')
                          <img src="{{ asset('site/assets/img/other/shippingdone.png') }}" alt="" width="50">
                          @endif
                        </a>
                       @endif
                      </th>
                       
                        <th>
                          {{ $item->created_at->format('d M, Y') }} <br />
                          <small>#RITZ-{{ $item->id }}</small> <br />
                          <small>
                            @if($item->paymentstatus == 'Y')
                            <span style="color: green;"> <i class="ni ni-check-bold"></i> Paid | {{ $item->paymentmethod }}</span>
                           @else
                           <a href="{{ route('getOrderDetail', $item->id) }}"><span style="color:red;"><i class="ni ni-fat-remove"></i> Unpaid | {{ $item->paymentmethod }}</span> </a>
                           @endif
                          </small>
                        </th>
                      <th scope="row">
                        
                        <div style="">
                          <a href="{{ route('getOrderDetail', $item->id) }}">{{ $item->buyer_fname }} {{ $item->buyer_lname }} </a> - <a href="https://wa.me/+{{ $country11->phone }}{{ $item->receiver_mobile }}" target="_blank"> <img src="{{ asset('site/images/whatsapp.png') }}" alt="" width="20">{{ $item->buyer_mobile }}</a> <br />
                          <small>
                            {{Str::limit($item->receiver_city, 15, $end='...')}}
                            @if($country11)
                            , {{ $country11->name }}
                            @endif
                          </small>
                        </div>
                      </th>
                      <th>{{ $cartitem }} item(s)<br />
                        <small>{{ $item->producttotalweight }}kg</small><br />
                        MYR {{ $item->grandtotal }}</th>
                     
                      <form action="{{ route('getSendTrackCode', $item->id) }}" method="POST">
                        @csrf()
                      <td>
                        {{Str::limit($item->shippingcompany, 10, $end='...')}}
                        <br />
                        <small>MYR {{ $item->shippingcost }} <br /> {{ $item->delivery_range }}</small>
                        <!-- <a href="{{ route('getManageCourier', $item->id) }}"><i class="ni ni-delivery-fast"></i> Shipping</a> -->
                        <!-- <input type="text" name="trackingcode" value="{{ $item->trackingcode }}"> <input type="submit" value="Send"> -->
                      </td>
                      </form>
                      <td class="text-right">
                        @if($item->paymentstatus == 'N')
                        <a href="{{ route('getSendEmailFollowBack', $item->id) }}" style="background-color: rgb(165, 52, 71); color: #fff; padding: 7px;">Email Follow</a>
                        <a href="{{ route('getMakeAsPaid', $item->id) }}" style="background-color: rgb(165, 52, 71); color: #fff; padding: 7px;">Mark as paid</a>
                        @else
                        <a href="{{ route('getMakeAsUnPaid', $item->id) }}" style="background-color: rgb(165, 52, 71); color: #fff; padding: 7px;">Mark as Unpaid</a>
                        @endif
                        
                       <a href="{{ route('getManageInvoice', $item->id) }}" target="_blank"><i class="ni ni-bullet-list-67" style="background-color: rgb(165, 52, 71); color: #fff; padding: 9px;" title="Detail Invoice"></i></a>
                       <a href="{{ route('getDeleteOrder', $item->id) }}"onclick="return confirm('Are you sure, you want to delete it?')"><i class="ni ni-fat-remove" style="background-color: rgb(165, 52, 71); color: #fff; padding: 9px;" title="Delete Order"></i></a>
                      </td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
               
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-12">
                      <p>{!! $orders->links() !!}</p>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Catagory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{ route('postAddCatagory') }}" enctype="multipart/form-data">
      <div class="modal-body">
          @csrf()
          <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <input class="form-control" placeholder="Catagory Name" type="text" name="name"  required>
              </div>
          </div>
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                </div>
                <textarea class="form-control" placeholder="Catagory Detail" name="detail"></textarea>
            </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                  <span class="input-group-text"></span>
              </div>
              <input type="file" class="form-control" placeholder="Photo" name="photo">
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </div>
      </form>
    </div>
  </div>
</div>
 
@endsection
@section('js')
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
@endsection