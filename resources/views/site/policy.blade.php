@extends('site.template', ['title' => __($title)])
@section('content')
<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">{{ $title }}</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">{{ $title }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- Start privacy policy section -->
<div class="privacy__policy--section section--padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
               
                
                <div class="privacy__policy--content section_3">
                    <h2 class="privacy__policy--content__title">{{ $title }}</h2>
                    <p class="privacy__policy--content__desc">
                        {!! $page->content !!}
                        </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End privacy policy section -->
@stop