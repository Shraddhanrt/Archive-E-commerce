@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                @if(auth()->user()->role == 'A')
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0"> Total Paid Sales</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $countpaidsales }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $countpaidsalestotal }}</span>
                                <span class="text-nowrap">Today Paid Sales</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Unpaid Sales</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $countunpaidsales }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> {{ $countunpaidsalestotal }}</span>
                                <span class="text-nowrap">Today Unpaid Sales</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Sales</h5>
                                    <span class="h2 font-weight-bold mb-0">MYR {{ $salestotal }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> {{ $todaysalestotal }}</span>
                                <span class="text-nowrap">Today Total Sales</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Products</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $totalproducts }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"> </span>
                                <span class="text-nowrap"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <div class="container-fluid mt--7">
       
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h3 class="mb-0">Quick Detail</h3>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="nav-wrapper">
                                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Today Paid Order ({{ $paidorders->count() }})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Today Unpaid Order ({{ $unpaidorders->count() }})</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Messages</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                    <div class="table-responsive">
                                        @if($paidorders->count())
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Paymet</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    @foreach($paidorders as $paidorder)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $paidorder->buyer_fname }} {{ $paidorder->buyer_lname }} - <a href="https://wa.me/{{ $paidorder->buyer_mobile }}" target="_blank">{{ $paidorder->buyer_mobile }}</a> <br />
                                                            @if($paidorder->buyer_fname.''.$paidorder->buyer_lname != $paidorder->receiver_fname.''.$paidorder->receiver_lname)
                                                            <small>{{ $paidorder->receiver_fname }} {{ $paidorder->receiver_lname }}</small> <br />
                                                            @endif
                                                            <small>{{ $paidorder->receiver_address }}</small>
                                                        </th>
                                                        <td>
                                                            MYR {{ $paidorder->grandtotal }}
                                                        </td>
                                                        <td>
                                                            {{ $paidorder->paymentmethod }} ({{ $paidorder->paymentstatus }})
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('getManageInvoice', $paidorder->id) }}" target="_blank"><i class="far fa-address-card" style="background-color: red; color: #fff; padding: 10px; font-weight: bold;" title="View Detail"> View Detail</i></a>
                                                        </td>
                                                    </tr>
                                                   
                                                    @endforeach
                                               
                                            </tbody>
                                        </table>
                                        @else
                                        <p>Today no order!!!</p>
                                    @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                    <div class="table-responsive">
                                        @if($unpaidorders->count())
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Paymet</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    @foreach($unpaidorders as $unpaidorder)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $unpaidorder->buyer_fname }} {{ $unpaidorder->buyer_lname }} - <a href="https://wa.me/{{ $unpaidorder->buyer_mobile }}"> <img src="{{ asset('site/images/whatsapp.png') }}" width="30" alt="">{{ $unpaidorder->buyer_mobile }}</a> <br />
                                                            @if($unpaidorder->buyer_fname.''.$unpaidorder->buyer_lname != $unpaidorder->receiver_fname.''.$unpaidorder->receiver_lname)
                                                            <small>{{ $unpaidorder->receiver_fname }} {{ $unpaidorder->receiver_lname }}</small> <br />
                                                            @endif
                                                            <small>{{ $unpaidorder->receiver_address }}</small>
                                                        </th>
                                                        <td>
                                                            MYR {{ $unpaidorder->grandtotal }}
                                                        </td>
                                                        <td>
                                                            {{ $unpaidorder->paymentmethod }} ({{ $unpaidorder->paymentstatus }})
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('getManageInvoice', $unpaidorder->id) }}" target="_blank"><i class="far fa-address-card" style="background-color: red; color: #fff; padding: 10px; font-weight: bold;" title="View Detail"> View Detail</i></a>
                                                            <a href="{{ route('getMakeAsPaid', $unpaidorder->id) }}"><i class="far fa-address-card" style="background-color: green; color: #fff; padding: 10px; font-weight: bold;" title="View Detail"> Mark as a Paid</i></a>
                                                            <a href="{{ route('getSendEmailFollowBack', $unpaidorder->id) }}"><i class="far fa-address-card" style="background-color: yellow; color: #000; padding: 10px; font-weight: bold;" title="View Detail"> Email Follow</i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                               
                                            </tbody>
                                        </table>
                                        @else
                                        <p>Today no order!!!</p>
                                    @endif
                                    </div>
                                </div>
                                <!-- <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                    <p class="description">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            @if(auth()->user()->role == 'A')
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Monthly Collection</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Collection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        Online
                                    </th>
                                    <td>
                                        MYR {{ $onlineamount }}
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Paypal
                                    </th>
                                    <td>
                                        MYR {{ $paypalamount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <strong>Grand Total</strong>
                                    </th>
                                    <td>
                                        <strong>MYR {{ $monthlytotalamount }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush