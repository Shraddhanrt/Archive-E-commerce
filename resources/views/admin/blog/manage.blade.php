@extends('layouts.app', ['title' => __('Manage Blogs')])
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
                    <h3 class="mb-0">Manage Blogs</h3>
                  </div>
                  <div class="col-md-4" style="text-align: right;">
                      <a href="{{ route('getAddBlog') }}" class="btn btn-primary">Add</a>
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
                    <th></th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Created Date</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($blogs as $item)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="{{ asset('site/uploads/blogs/'.$item->photo) }}">
                        </a>
                      </div>
                    </th>
                   <td>{{ $item->title }}</td>
                   <th>{{ $item->type }}</th>
                   <th>{{ $item->created_at }}</th>
                   
                    <td class="text-right">
                      <a href="{{ route('getBlogEdit', $item->id) }}">Edit</a> | <a href="{{ route('getDeleteBlog', $item->id) }}">Delete</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Catagory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{ route('postAddCatagory') }}" enctype="multipart/form-data">
      <div class="modal-body">
          @csrf()
          <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <input class="form-control" placeholder="Catagory Name" type="text" name="name"  required>
              </div>
          </div>
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                </div>
                <textarea class="form-control" placeholder="Catagory Detail" name="detail"></textarea>
            </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                  <span class="input-group-text"></span>
              </div>
              <input type="file" class="form-control" placeholder="Photo" name="photo">
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
@endsection