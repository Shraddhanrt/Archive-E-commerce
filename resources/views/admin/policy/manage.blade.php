@extends('layouts.app', ['title' => __('Manage Policy')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Manages Policies</h6>
                     
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
                        <h3 class="mb-0">{{ __('Policy') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    <form action="{{ route('getEditPolicy', $return->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Return & Refund Policy') }}</label>
                                <textarea id="return" name="detail" class="form-control form-control-alternative">{!! $return->content !!}</textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="{{ route('getEditPolicy', $privacy->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-control-label" for="input-email">{{ __('Privacy Policy') }}</label>
                                <textarea id="privacy" name="detail" class="form-control form-control-alternative"> {!! $privacy->content !!}</textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="{{ route('getEditPolicy', $terms->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-control-label" for="input-email">{{ __('Terms & Conditions') }}</label>
                                <textarea id="terms" name="detail" class="form-control form-control-alternative"> {!! $terms->content !!}</textarea>
                            </div>
                            <div class="text-right">
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

<script>
    tinymce.init({
      selector: '#privacy'
    });
  </script>
  <script>
    tinymce.init({
      selector: '#return'
    });
  </script>
  <script>
    tinymce.init({
      selector: '#terms'
    });
  </script>
@stop