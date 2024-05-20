@extends('layouts.app', ['title' => __('Edit Faq')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Edit Faq</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{ route('getManageFaq') }}" class="btn btn-lg btn-neutral">Manage Faq</a>
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
                        <h3 class="mb-0">{{ __('Edit Faq') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('postFaqEdit', $faq->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-control-label" for="input-name">{{ __('Product') }} <span>*</span></label>
                                <select name="product_id" class="form-control form-control-alternative">
                                    <option value=""> None</option>
                                   @foreach($products as $product)
                                    <option value="{{ $product->id }}" <?php if($product->id == $faq->product_id) { echo 'selected'; } ?>>{{ $product->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Catagory Type') }} <span>*</span></label>
                                <select name="catagory" class="form-control form-control-alternative" required>
                                    <option value="General Information" <?php if($faq->catagory == 'General Information'){ echo 'selected'; } ?>>General Information</option>
                                    <option value="Shipping Information" <?php if($faq->catagory == 'Shipping Information'){ echo 'selected'; } ?>>Shipping Information</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Question') }} <span>*</span></label>
                                <input type="text" name="question" class="form-control form-control-alternative" value="{{ $faq->question }}" required>
                            </div>
                           
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Answer') }}</label>
                                <textarea id="detail" name="answer" class="form-control form-control-alternative">{!! $faq->answer !!}</textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Edit') }}</button>
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
<link href="{{ asset('froala-editor/css/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('froala-editor/js/froala_editor.pkgd.min.js') }}"></script>
<script> 
    var editor = new FroalaEditor('#example');
    var editor = new FroalaEditor('#detail');
    var editor = new FroalaEditor('#ingredient');
    
</script>
@stop