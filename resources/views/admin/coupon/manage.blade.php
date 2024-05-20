@extends('layouts.app', ['title' => __('Manage Coupon')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Manage Promo Code</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a data-toggle="modal" data-target="#exampleModal" class="btn btn-lg btn-neutral">Create New Promo Code</a>
                    </div>
                  </div>
                
            
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
              <h3 class="mb-0">Manage Promo Code</h3>
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
                    <th scope="col">Promo Code</th>
                    <th scope="col">Promo code Value</th>
                    <th scope="col">Expiry Date</th>
                    <th scope="col">Min Cost</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($coupons as $coupon)
                  <tr>
                    
                    <td class="budget">
                      {{ $coupon->code }}
                      @if($coupon->onetime == 'Y')
                      <small style="display:block;">One time use only </small>
                      @else
                      <small style="display:block;">Multiple time use</small>
                      @endif
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        @if($coupon->amounttype == 'percentage')
                          {{ $coupon->amount }}%
                        @else
                          MYR{{ $coupon->amount }}
                        @endif
                      </span>
                    </td>
                    <td>{{$coupon->expiry}}</td>
                    <td>RM{{$coupon->min_cost_apply}}</td>
                    <td>
                      @if($coupon->onetime == 'Y')
                        One time Use only
                      @else
                        Multiple time use
                      @endif
                    </td>
                    <td>
                      @if($coupon->expiry >= date('Y-m-d'))
                        <span style="color: green;">Active</span>
                      @else
                        <span style="color:red;">Expired</span>
                      @endif
                      @if($coupon->status == 'N')
                        | Disable
                      @endif
                    </td>
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="{{route('getEditCoupon', $coupon->id)}}">Edit</a>
                          <a class="dropdown-item" href="{{route('getDeleteCoupon', $coupon->id)}}">Delete</a>
                          <a class="dropdown-item" href="{{route('getEnableDisableCoupon', $coupon->id)}}">Enable/Disable</a>
                        </div>
                      </div>
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
    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Promo Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{route('postCreateCoupon')}}">
      <div class="modal-body">
          @csrf()
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative" style="padding: 15px 0;">
                <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                </div>
                <label for="percentage"><input id="percentage" class="" type="radio" name="amounttype" value="percentage" onclick="ModifyPlaceHolder(this)" required> &nbsp; Percentage</label>
                <label for ="flatrate">&nbsp; &nbsp; &nbsp; &nbsp; <input id="flatrate" class="" type="radio" name="amounttype" value="flatrate" onclick="ModifyPlaceHolder(this)" required> &nbsp; Flat Rate</label>

            </div>
          </div>
          <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <input class="form-control" placeholder="Promo Code" type="text" name="code" required>
              </div>
          </div>
            <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"></span>
                    </div>
                    <input id="couponvalue" class="form-control" placeholder="Promo Code Value" type="number" name="amount" required>
                </div>
            </div>
            <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"></span>
                    </div>
                    <input class="form-control" placeholder="Promo Code Expiry Date" type="text" name="expirydate" required placeholder="MM/DD/YYYY"
                    onfocus="(this.type='date')"
                    onblur="(this.type='text')">
                </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <input class="form-control" placeholder="Min Purchase Cost Apply (RM)" type="number" name="min_cost_apply" required>
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative" style="padding: 15px 0;">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <label for="unlimite"><input id="unlimite" class="" type="radio" name="type" value="N" checked required> &nbsp; Multiple Time Use</label>
                  <label for ="onetime">&nbsp; &nbsp; &nbsp; &nbsp; <input id="onetime" class="" type="radio" name="type" value="Y" required> &nbsp; One Time Use</label>
  
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
<script>
  function ModifyPlaceHolder(element) {
      var data = {
              percentage: 'Promo Code Value %',
              flatrate: 'Promo Code Value MYR'
          };
     var input = document.getElementById("couponvalue");
     input.placeholder = data[element.id];
}
</script>
@endsection