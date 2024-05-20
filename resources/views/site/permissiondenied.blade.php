@extends('site.template', ['title' => __('Order Status')])
@section('content')
<main class="main__content_wrapper">
        
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Permission Denied</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Permission Denied</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start error section -->
    <section class="error__section section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="error__content text-center">
                        <img class="error__content--img mb-50" src="{{ asset('site/assets/img/other/404-thumb.png') }}" alt="error-img">
                        <h2 class="error__content--title">Opps ! Permission Denied </h2>
                        <p class="error__content--desc"> You are not allow to view this page</p>
                        <a class="error__content--btn primary__btn" href="{{ url()->previous() }}">Back To Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@stop