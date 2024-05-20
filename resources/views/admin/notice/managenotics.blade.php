@extends('layouts.app', ['title' => __('Manage Notices')])
@section('content')
@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop
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
                    <h3 class="mb-0">Manage Offer Notics</h3>
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
              <table class="table align-items-center table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Created at</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($notices as $item)
                  <tmar>
                    
                    <td class="budget">
                      {{ $item->title }}
                    </td>
                    
                    <td>
                     {{ $item->created_at }}
                    </td>
                    <td class="text-right">
                      <a href="{{ route('getDeleteNotice', $item->id) }}">Delete</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Notices</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{ route('postAddNotice') }}" enctype="multipart/form-data">
      <div class="modal-body">
          @csrf()
         
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                </div>
                <textarea class="form-control" placeholder="Notices" name="detail"></textarea>
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
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
@endsection