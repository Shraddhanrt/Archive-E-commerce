@extends('layouts.app', ['title' => __('Add Photos')])
@section('content')
@include('layouts.navbars.navbar')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
           <h3>{{ $product->name }}</h3>
        </div>
    </div>
</div>
   
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-0">Add photos</h3>
                  </div>
                  <div class="col-md-4" style="text-align: right;">
                      <a data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Add</a>
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
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($photos as $item)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="mr-3">
                          <img alt="Image placeholder" src="{{ asset('site/uploads/products/'.$item->photo) }}" width="130">
                        </a>
                      </div>
                    </th>
                   
                   
                    
                    <td class="text-right">
                       <a href="">Delete</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{ route('postProductPhotoAdd', $product->id) }}" enctype="multipart/form-data">
      <div class="modal-body">
          @csrf()
          <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"></span>
                  </div>
                  <input class="form-control" type="text" name="name" value="{{ $product->name }}" disabled>
              </div>
          </div>
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                  <span class="input-group-text"></span>
              </div>
              <input type="file" class="form-control" placeholder="Photo" name="photo[]" multiple>
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