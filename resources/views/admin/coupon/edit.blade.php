@extends('layouts.app', ['title' => __('Manage Coupon')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Edit Coupon</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{route('getCouponManage')}}" class="btn btn-lg btn-neutral">Manage Coupon</a>
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
              <h3 class="mb-0">Edit Coupon</h3>
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
                <form role="form" method="POST" action="{{route('postEditCoupon', $coupon->id)}}">
                    <div class="modal-body">
                        @csrf()
                        <div class="form-group mb-3">
                          <div class="input-group input-group-alternative">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"></span>
                              </div>
                              <input class="" type="radio" name="amounttype" value="percentage" required <?php if($coupon->amounttype == 'percentage'){ echo 'checked'; } ?>> Percentage
                              &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; <input class="" type="radio" name="amounttype" value="flatrate" required <?php if($coupon->amounttype == 'flatrate'){ echo 'checked';} ?>> Flat Rate
              
                          </div>
                      </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input class="form-control" value="{{$coupon->code}}" type="text" name="code"  required>
                            </div>
                        </div>
                          <div class="form-group mb-3">
                              <div class="input-group input-group-alternative">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"></span>
                                  </div>
                                  <input class="form-control" value="{{ $coupon->amount }}" type="text" name="amount"  required>
                              </div>
                          </div>
                          <div class="form-group mb-3">
                              <div class="input-group input-group-alternative">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"></span>
                                  </div>
                                  <input class="form-control" value="{{$coupon->expiry->format('Y-m-d')}}" type="date" name="expirydate"  required>
                              </div>
                          </div>
                          <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input class="form-control" placeholder="Min Cost Apply (RM)" type="number" name="min_cost_apply" value="{{$coupon->min_cost_apply}}" required>
                            </div>
                          </div>
                          <div class="form-group mb-3">
                            <div class="input-group input-group-alternative" style="padding: 15px 0;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <label for="unlimite"><input id="unlimite" class="" type="radio" name="type" value="N" <?php if($coupon->onetime == 'N'){ echo 'checked'; } ?> required> &nbsp; Multiple Time Use</label>
                                <label for ="onetime">&nbsp; &nbsp; &nbsp; &nbsp; <input id="onetime" class="" type="radio" name="type" value="Y" <?php if($coupon->onetime == 'Y'){ echo 'checked'; } ?> required> &nbsp; One Time Use</label>
                
                            </div>
                          </div>
                       
                      
                    
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                    </form>
            </div>
            <!-- Card footer -->
            
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
@endsection