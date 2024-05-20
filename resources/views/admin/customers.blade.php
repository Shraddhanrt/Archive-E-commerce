@extends('layouts.app', ['title' => __('Manage Customer')])
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
                <div class="col-md-8">
                    <h3 class="mb-0">Customer List</h3>
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
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Full Name</th>
                    <th scope="col" class="sort" data-sort="budget">Address</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Order(s)</th>
                    <th>Agent?</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($customers as $item)
                  @php $ordercount = App\Models\Order::where('customer_id', $item->id)->count(); @endphp
                  
                  <tr>
                    <th scope="row">{{ $item->fname }} {{ $item->lname }}</th>
                    <td class="budget">
                        @if($item->address != NULL)
                            {{ $item->address }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @if($item->country != NULL && $item->mobile != NULL)
                        @php $country11 = App\Models\Country::where('id', $item->country)->limit(1)->first(); @endphp
                        <a href="https://wa.me/+{{ $country11->phone }}{{ $item->mobile }}" target="_blank">
                          <img src="{{ asset('site/images/whatsapp.png') }}" alt="" width="20">{{ $item->mobile }}
                        </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <!-- <a class="getListofCustomerOrder" data-id="{{ $item->id }}">{{ $ordercount }}</a> -->
                        <a class="getListofCustomerOrder" data-id = "{{ $item->id }}" data-open="orderlist" href="javascript:void(0)">{{ $ordercount }}</a>
                    </td>
                    <td>
                        @if($item->agent == 'Y')
                            Agent (discount {{ $item->discount }}%) <br />
                            <small><a href="{{ route('getAdminRemoveAgent', $item->id) }}">Remove Agent</a></small>
                        @else
                            <a href="javascript:void(0)" class="makeaagent" data-id="{{ $item->id }}" data-name="{{ $item->fname }} {{ $item->lname }}">Make a Agent</a>
                        @endif
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Make an Agent</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                  <div class="col-md-12">
                    <div class="row1">
                      <form method="post" action="{{ route('postUpdateAsAAgent') }}" method="POST">
                        @csrf
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Customer Name') }} <span>*</span></label>
                                <input type="text" name="fname" class="form-control form-control-alternative" id="customerinputname" disabled>
                                <input type="hidden" name="customerid" value="" id="customerinputid">
                            </div>

                           
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">{{ __('Discount %') }}</label>
                                        <input type="number" name="discount" class="form-control form-control-alternative" required>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                    </div>
                  </div>

              </div>
            </div>
          </div>
        </div>
    </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Customer Orders History</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                  <div class="col-md-12">
                    <div class="row">
                    <div class="col-md-6">
                        <br />
                        Customer Name : <strong><span id="customerfname"></span> <span id="customerlname"></span></strong> <br />
                        Address : <strong><span id="customeraddress"></span></strong> <br /> <br />
                    </div>
                    <div class="col-md-6">
                        <br />
                      Contact Number : <strong><span id="customermobile"></span></strong> <br />
                      Email : <strong><span id="costomeremail"></span></strong> <br /> <br />
                  </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                        <span id="orderlist"></span>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('js')
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<script>
    $(document).on('click', '.getListofCustomerOrder', function() {
        var customerid = $(this).data('id');
        $.ajax({
          url: "/getListofCustomerOrder/ajax",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            customerid:customerid,
          },
          success: function(response){ 
            
            $('#orderlist').html(response.orders);
            $('#customerfname').html(response.customer.fname);
            $('#customerlname').html(response.customer.lname);
            $('#customeraddress').html(response.customer.address);
            $('#customermobile').html(response.customer.mobile);
            $('#costomeremail').html(response.customer.email);
            
             
            }
         
         });

        $('#exampleModal').modal('show'); 



})
</script>
<script>
    $(document).on('click', '.makeaagent', function() {
        var customerid = $(this).data('id');
        var customername = $(this).data('name');
        $('#customerinputname').val(customername);
        $('#customerinputid').val(customerid);
        $('#exampleModal2').modal('show');
});
</script>
@endsection