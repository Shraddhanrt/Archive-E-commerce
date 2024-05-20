@extends('layouts.app', ['title' => __('Edit Products')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Edit Products</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{ route('getProductManage') }}" class="btn btn-lg btn-neutral">Manage Products</a>
                    </div>
                  </div>
                
            
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('Edit Product') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('postProductEdit', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
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
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Catagory') }} <span>*</span></label>
                                <select name="catagory_id" class="form-control form-control-alternative" required>
                                    @foreach($catagories as $cat)
                                    <option value="{{ $cat->id }}" @php if($cat->id == $product->catagory_id){ echo 'selected'; } @endphp > {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Product Name') }} <span>*</span></label>
                                <input type="text" name="name" class="form-control form-control-alternative" value="{{ $product->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Detail') }} <span>*</span></label>
                                <textarea id="detail" name="detail" class="form-control form-control-alternative" required focus>{!! $product->detail !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Benefit') }}</label>
                                <textarea id="benefit" name="benefit" class="form-control form-control-alternative">{!! $product->benefit !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Ingredient') }}</label>
                                <textarea id="ingredient" name="ingredient" class="form-control form-control-alternative">{!! $product->ingredient !!}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-control-label" for="input-email">{{ __('Cost *') }}</label>
                                         <input type="number" value="{{ $product->acost }}" name="acost" class="form-control form-control-alternative">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-control-label" for="input-email">Offer?</label> <br />
                                        <input type="checkbox">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-control-label" for="input-email">{{ __('Offer Cost') }}</label>
                                         <input type="number" name="dcost" value="{{ $product->dcost }}" class="form-control form-control-alternative">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Product Weight') }}</label>
                                <input id="weight" name="weight" class="form-control form-control-alternative" value="{{ $product->weight }}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Free Shipping?') }}</label>
                                <input type="checkbox" id="freeshipping" name="shippingfree" class="" <?php if($product->shippingfree == 'Y'){ echo 'checked'; } ?>>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">{{ __('Photo *') }}</label>
                                        <input type="file" name="photo" class="form-control form-control-alternative"> <br />
                                        <img src="{{ asset('site/uploads/products/'.$product->photo) }}" alt="" width="120">
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('edit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    
    @include('layouts.footers.auth')
</div>
@stop
@section('js')

<script>
    tinymce.init({
      selector: '#detail'
    });
  </script>
  <script>
    tinymce.init({
      selector: '#benefit'
    });
  </script>
@stop