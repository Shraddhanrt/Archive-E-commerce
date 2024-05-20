@extends('site.template', ['title' => __('Order Status')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Order Status</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Order Status</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="checkout__page--area">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="background-color: goldenrod; text-align: center; margin-top: 12px; padding: 15px;">
              
               <h1>Something went wrong!</h1>
               <h4>Payment declined.</h4>
               
              
            </div>
        </div>
        
    </div>
</div>
@stop