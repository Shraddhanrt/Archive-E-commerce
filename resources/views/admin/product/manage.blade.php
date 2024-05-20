@extends('layouts.app', ['title' => __('Manage Category')])
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
                    <h3 class="mb-0">Manage Products</h3>
                  </div>
                  <div class="col-md-4" style="text-align: right;">
                      <a href="{{ route('getAddProduct') }}" class="btn btn-primary">Add</a>
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
                    <th>Products</th>
                    <th>Catagory</th>
                    <th>Cost</th>
                    <th>Stock?</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($products as $item)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="{{ asset('site/uploads/products/'.$item->photo) }}">
                        </a>
                      </div>
                    </th>
                    <td class="budget">
                      {{ $item->name }}
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                          @php $cat = App\Models\Catagory::where('id', $item->catagory_id)->limit(1)->first(); @endphp
                       {{ $cat->name }}
                      </span>
                    </td>
                    <td>
                        @if($item->dcost != null)
                        <del>MYR {{ $item->acost }}</del>
                        MYR {{ $item->dcost }}
                        @else
                        MYR {{ $item->acost }}
                        @endif
                        @if($item->shippingfree == 'Y')
                        <small style="color:red; display:block;">Shipping Free</small>
                        @endif
                    </td>
                    <td>
                      <form action="{{ route('getStockChange', $item->id) }}">
                        @if($item->stock == 'Y')
                          In Stock
                          <br />
                          <input type="submit" value="Make an Out of Stock">
                        @else
                          <span style="color: red;">Out of Stock</span>
                          <br />
                          <input type="submit" value="Make an In Stock">
                        @endif
                        
                      </form>
                    </td>
                    <td class="text-right">
                     <a href="{{ route('getAddOtherPhoto', $item->id) }}">Photo</a> |
                     <a href="">FAQ</a> | <a href="{{ route('getProductEdit', $item->id) }}">Edit</a> |
                     <a href="{{ route('getDeleteProduct', $item->id) }}" onclick="return confirm('Are you sure you want to delete?');">Delete</a> |
                     <a href="{{route('getProductToogle', $item->id)}}" onclick="return confirm('Are you sure you want to hide this product?');">Hide</a>
                    </td>
                  </tr>
                  @endforeach

                  @foreach($unactiveproducts as $item1)
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="{{ asset('site/uploads/products/'.$item1->photo) }}">
                        </a>
                      </div>
                    </th>
                    <td class="budget">
                     <span style="color: red;"> {{ $item1->name }}</span>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                          @php $cat1 = App\Models\Catagory::where('id', $item1->catagory_id)->limit(1)->first(); @endphp
                       <span style="color: red;">{{ $cat1->name }}</span>
                      </span>
                    </td>
                    <td>
                       <span style="color:red;">
                        @if($item1->dcost != null)
                        <del>MYR {{ $item1->acost }}</del>
                        MYR {{ $item1->dcost }}
                        @else
                        MYR {{ $item1->acost }}
                        @endif
                      </span>
                    </td>
                    <td>
                      <form action="{{ route('getStockChange', $item->id) }}">
                        @if($item1->stock == 'Y')
                        <span style="color: red;">In Stock</span>
                          <br />
                          <input type="submit" value="Make an Out of Stock">
                        @else
                          <span style="color: red;">Out of Stock</span>
                          <br />
                          <input type="submit" value="Make an In Stock">
                        @endif
                        
                      </form>
                    </td>
                    <td class="text-right">
                     <a href="{{ route('getAddOtherPhoto', $item1->id) }}" style="color:red;">Photo</a> |
                     <a href="{{ route('getProductEdit', $item1->id) }}" style="color:red;">Edit</a> |
                     <a href="{{ route('getDeleteProduct', $item1->id) }}" style="color:red;" onclick="return confirm('Are you sure you want to delete?');">Delete</a> |
                     <a href="{{route('getProductToogle', $item1->id)}}" style="color:red;">Show</a>
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
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