@extends('site.template', ['title' => __('Diet Plan for good health')])
@section('content')
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Diet Plan</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white"
                                href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Diet Plan</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog__section section--padding">
    <div class="container">
        <div class="section__heading text-center mb-50">
            <h2 class="section__heading--maintitle">5 STEPS TO BETTER HEALTH AND BODY WITH RITZ</h2>
        </div>
        <div class="diet__section--inner" style="border-left: #db980f solid 10px; padding: 20px 0;">
            @foreach($dietplans as $plan)
            <div class="col-md-12 diet-list" style="margin: 20px 0;">
                <div class="row">
                    <div class="col-md-3">
                       <img class="banner__items--thumbnail__img" src="{{ asset('site/uploads/diets/'.$plan->photo) }}" alt="">
                    </div>
                    <div class="col-md-9">
                        <h4>{{ $plan->title }}</h4>
                        <p>
                            {!! $plan->detail !!}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
           
           
           
           

        </div>
    </div>
</section>
@stop