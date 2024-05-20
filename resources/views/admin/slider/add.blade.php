@extends('layouts.app', ['title' => __('Add Slider')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Add Slider</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{ route('getManageSlider') }}" class="btn btn-lg btn-neutral">Manage Slider</a>
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
                        <h3 class="mb-0">{{ __('Add Slider') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('postSliderAdd') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">{{ __('Photo *') }}</label>
                                        <input type="file" name="photo" class="form-control form-control-alternative" required>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Botton Text') }}</label>
                                <input type="text" name="value" class="form-control form-control-alternative" required>
                            </div>
                           
                             <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Botton Link') }} </label>
                                <input type="url" name="link" class="form-control form-control-alternative">
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