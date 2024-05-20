@extends('layouts.app', ['title' => __('Manage Shipping')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your projects or assigned tasks'),
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
                                <h3 class="mb-0">Order #{{ $order->id }}-{{ $order->code }}</h3>
                           </div>
                           <div class="col-md-6 text-right">
                            <h3 class="mb-0">Order Date : {{ $order->created_at->format('d M, Y')}}</h3>
                       </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('AminPostModifyCourier') }}">
                            <select class="checkout__input--select__field border-radius-5" name="selectedagent" id="selectedagent" style="border-color: orange;">
                                {!! $shippers !!}
                            </select> <br />
                            <input type="hidden" name="orderid" value="{{ $order->id }}">
                            <small>Please take note after changed different courier agent shipping cost may be different.</small> <br />
                            <input type="submit" value="Change">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

