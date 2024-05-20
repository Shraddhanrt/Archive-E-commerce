@extends('layouts.app', ['title' => __('Edit Blogs')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
           
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">Edit Blog/ News &amp; Events</h6>
                     
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                      <a href="{{ route('getManageBlog') }}" class="btn btn-lg btn-neutral">Manage Blogs/News</a>
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
                        <h3 class="mb-0">{{ __('Edit Blog/News &amp; Events') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('postBlogEdit', $blog->id) }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-control-label" for="input-name">{{ __('Type') }} <span>*</span></label>
                                <select name="type" class="form-control form-control-alternative" required>
                                   
                                    <option value="B" <?php if($blog->type == 'B') { echo 'selected'; }?>>Blog</option>
                                    <option value="N" <?php if($blog->type == 'N') { echo 'selected'; }?>>News &amp; Events</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Title') }} <span>*</span></label>
                                <input type="text" name="title" class="form-control form-control-alternative" value="{{ $blog->title }}" required>
                            </div>
                           
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Detail') }}</label>
                                <textarea id="detail" name="detail" class="form-control form-control-alternative">{!! $blog->detail !!}</textarea>
                            </div>
                             <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Video URL') }} </label>
                                <input type="text" name="video" class="form-control form-control-alternative" value="{{ $blog->link }}">
                            </div>
                            
                           
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label">{{ __('Photo *') }}</label>
                                        <input type="file" name="photo" class="form-control form-control-alternative"> <br />
                                        <img src="{{ asset('site/uploads/testimonials/'.$blog->photo) }}" alt="" width="120">
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
<link href="{{ asset('froala-editor/css/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('froala-editor/js/froala_editor.pkgd.min.js') }}"></script>
<script> 
    var editor = new FroalaEditor('#example');
    var editor = new FroalaEditor('#detail');
    var editor = new FroalaEditor('#ingredient');
    
</script>
@stop