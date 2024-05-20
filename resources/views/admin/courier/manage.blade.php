@extends('layouts.app', ['title' => __('Manage Shipping')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is courier manage page. Its linked into EASY PARSAL, You can direct place the courier. Make sure you have balance on Easy parsal'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                       
                        <span class="btn btn-lg btn-info mt-4">{{ $order->order_status }} <img src="{{ asset('site/assets/img/other/notshipping.png') }}" width="30" alt=""></span>
                        <div class="card-body pt-0 pt-md-4 text-center">
                            <div class="h5 font-weight-300">
                                <h5>Courier Information</h5>
                               <img src="{{ $order->shippingcompanylogo }}" alt="" width="100">
                               <p>
                                   {{ $order->shippingcompany }} <br />
                                   <small>{{ $order->delivery_range }}</small>
                                </p>
                                <p><u><a href="{{ route('getAdminChangeCourier', $order->id) }}">Change Courier Agent</a></u></p>
                                @if($order->awb_id_link != null AND $order->trackingcode != null)
                                <p>
                                    <a href="{{ $order->trackingcode }}" class="btn btn-success mt-4" target="_blank">Tracking URL</a> <br />
                                    <a href="{{ $order->awb_id_link }}" class="btn btn-success mt-4" target="_blank"> Print AWB</a> <br />
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-1">
                                    
                                        <div style="background-color: red; border-radius: 5px; color: #fff;">
                                            <span class="heading">{{ $carts->count() }}</span>
                                            <span class="description" style="color: #fff;">No. of Item(s)</span>
                                        </div>
                                        <div style="background-color: green; border-radius: 5px; color: #fff;">
                                            <span class="heading">{{ $order->producttotalweight }}kg</span>
                                            <span class="description" style="color: #fff;">{{ __('Weight') }}</span>
                                        </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center">
                                    
                                    <div style="background-color: pink; border-radius: 5px; color: #333;">
                                        <span class="heading">MYR{{ $order->shippingcost }}</span>
                                        <span class="description" style="color: #333;">{{ __('Shipping Cost') }}</span>
                                    </div>
                                        <div style="background-color: blue; border-radius: 5px; color: #fff;">
                                            <span class="heading">MYR{{ $order->grandtotal }}</span>
                                            <span class="description" style="color: #fff;">{{ __('Total Amount') }}</span>
                                        </div>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <h3>
                                Buyer Information
                            </h3>
                            <div class="h5 font-weight-300">
                                <strong>{{ $order->buyer_fname }} {{ $order->buyer_lname }}</strong> <br />
                                {{ $order->buyer_address }} <br />
                                Contact Number : {{ $order->buyer_mobile }}
                            </div>
                          
                            <hr class="my-4" />
                            <h3 class="text-center">Items</h3>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach($carts as $cart)
                                        @php $products = App\Models\Product::where('id', $cart->product_id)->limit(1)->first(); @endphp
                                        <tr>
                                            <td>{{ $products->name }}</td>
                                            <td>{{ $cart->qty }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                           <div class="col-md-6">
                                <h3 class="mb-0">Order #RITZ-{{ $order->id }}</h3>
                           </div>
                           <div class="col-md-6 text-right">
                            <h3 class="mb-0">Order Date : {{ $order->created_at->format('d M, Y')}}</h3>
                       </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('postAddtoCartParsal') }}" method="POST">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
    
                            <div class="pl-lg-4">
                                @php
                                           
                                            if($order->receiver_country == '136'){
                                                $rcountry1 = App\Models\Country::where('id', $order->receiver_country)->limit(1)->first();
                                                $rstate1 = App\Models\State::where('id',$order->receiver_state)->limit(1)->first();
                                                $rcountry = $rcountry1->name;
                                                $rstate = $rstate1->name;
                                            }
                                            else{
                                                $rcountry1 = App\Models\Country::where('id', $order->receiver_country)->limit(1)->first();
                                                $rcountry = $rcountry1->name;
                                                $rstate = $order->receiver_state;
                                            }
                                        @endphp

                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Receiver Full Name') }} <span>*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $order->receiver_fname }} {{ $order->receiver_lname }}" class="form-control form-control-alternative" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label" for="input-email">{{ __('Full Address') }}</label>
                                             <input type="text" name="address" id="address" class="form-control form-control-alternative" value="{{ $order->receiver_address }}" readonly required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-control-label" for="input-email">{{ __('Address II') }}</label>
                                             <input type="text" name="address1" id="address1" value="{{ $order->receiver_address2 }}" placeholder="Optional" class="form-control form-control-alternative" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="input-email">{{ __('Country') }}</label>
                                            
                                             <input type="text" name="country" id="country" class="form-control form-control-alternative" value="{{ $rcountry}}" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="input-email">{{ __('State') }}</label>
                                             <input type="text" name="state" id="state" class="form-control form-control-alternative" value="{{ $rstate }}" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="input-email">{{ __('Postal Code') }}</label>
                                             <input type="number" name="postalcode" id="postalcode" class="form-control form-control-alternative" value="{{ $order->receiver_postal_code }}" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="input-email">{{ __('Contact Number') }}</label>
                                             <input type="number" name="mobile" id="mobile" class="form-control form-control-alternative" value="{{ $order->receiver_mobile }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="input-email">{{ __('Email Address') }}</label>
                                             <input type="email" name="email" id="email" class="form-control form-control-alternative" value="{{ $order->buyer_email }}" required>
                                             
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Collection Date') }}</label>
                                    <input type="date" name="collectiondate" id="collectiondate" class="form-control form-control-alternative" value="" required>
                                    <input type="hidden" name="orderid" id="orderid" value="{{ $order->id }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __(' Tracking Code Send to Buyer Email?') }}</label>
                                    <input type="checkbox" name="trackingemailsend" class="form-control" checked>
                                </div>
    
                                <div class="text-center">
                                    <input type="submit" class="btn btn-success mt-4" value="Continue">
                                </div>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
@section('js')
<script type="text/javascript">

    $('#orderEasyParsal').on('submit',function(e){
        e.preventDefault();
       
        let name = $('#name').val();
        let address = $('#address').val();
        let address1 = $('#address1').val();
        let country = $('#country').val();
        let state = $('#state').val();
        let postalcode = $('#postalcode').val();
        let mobile = $('#mobile').val();
        let email = $('#email').val();
        let collectiondate = $('#collectiondate').val();
        let orderid = $('#orderid').val();
        
        
        $.ajax({
          url: "/addtocart/parsal",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
            address:address,
            address1:address1,
            country:country,
            state:state,
            postalcode:postalcode,
            mobile:mobile,
            email:email,
            collectiondate:collectiondate,
            orderid:orderid,
          },
          success:function(response){
            console.log(response);
           
          }
         
         });
        });
</script>
<script>
$('#modifyCourierAgent').on('click',function(){
    var orderid = $(this).data('id');
    $("#exampleModal").modal("show");

});

</script>
@endsection
