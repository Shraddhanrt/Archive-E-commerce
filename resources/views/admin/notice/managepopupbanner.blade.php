@extends('layouts.app', ['title' => __('Manage Modal')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-12 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Manage Popup Modal</h6>
                     
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
                        <h3 class="mb-0">{{ __('Manage Popup Modal') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        if($banner){
                            $id = $banner->id;
                        }
                        else{
                            $id = 0;
                        }
                    @endphp
                    <form method="post" action="{{ route('postPopUpBanner', $id) }}" method="POST" enctype="multipart/form-data">
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
                                        <label class="form-control-label">{{ __('Banner *') }}</label>
                                        <input type="file" name="photo" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">
                                    @if($id != 0)
                                    {{ __('Replace') }}
                                    @else
                                    {{ __('Add') }}
                                    @endif
                                </button>
                                @if($id != 0)
                                <a href="{{ route('getRemoveBanner', $id) }}" class="btn btn-success mt-4">Remove</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div>
                        
                        @if($banner)
                        <p>Current Banner</p>
                            <img src="{{ asset('site/uploads/notice/'.$banner->banner) }}" alt="">
                        @endif

                    </div>
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