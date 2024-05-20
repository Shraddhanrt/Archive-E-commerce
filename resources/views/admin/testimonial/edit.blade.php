@extends('layouts.app', ['title' => __('Edit Testimonial')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Edit Testimonial</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{ route('getManageTestimonial') }}" class="btn btn-lg btn-neutral">Manage Testimonial</a>
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
                        <h3 class="mb-0">{{ __('Edit Testimonial') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('postTestimonialEdit', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-control-label" for="input-name">{{ __('Title') }} <span>*</span></label>
                                <input type="text" name="title" class="form-control form-control-alternative" value="{{ $testimonial->title }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Name') }} <span>*</span></label>
                                <input type="text" name="name" class="form-control form-control-alternative" value="{{ $testimonial->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Detail') }} <span>*</span></label>
                                <textarea id="detail" name="detail" class="form-control form-control-alternative" required>{!! $testimonial->detail !!}</textarea>
                            </div>
                           
                            
                           
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">{{ __('Photo') }}</label>
                                        <input type="file" name="photo" class="form-control form-control-alternative"> <br />
                                        <img src="{{ asset('site/uploads/testimonials/'.$testimonial->photo) }}" alt="" width="120">
                                    </div>
                                    
                                </div>
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
<script>
    tinymce.init({
      selector: '#detail'
    });
  </script>
@stop