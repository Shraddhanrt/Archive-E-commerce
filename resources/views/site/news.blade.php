@extends('site.template', ['title' => __('News')])
@section('content')
<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">News &amp; Events</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white"
                                href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">News &amp; Events</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- Start blog section -->
<section class="blog__section section--padding">
    <div class="container">
        <div class="section__heading text-center mb-50">
            <h2 class="section__heading--maintitle">From The News &amp; Events</h2>
        </div>
        <div class="blog__section--inner">
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-sm-u-2 row-cols-1 mb--n30">
                @foreach($blogs as $blog)
                <div class="col mb-30">
                    <div class="blog__items">
                        <div class="blog__thumbnail">
                            <a class="blog__thumbnail--link" href="{{ route('getBlogDetail',$blog->slug) }}"><img
                                    class="blog__thumbnail--img" src="{{ asset('site/uploads/blogs/'.$blog->photo) }}"
                                    alt="blog-img"></a>
                        </div>
                        <div class="blog__content">
                            <span class="blog__content--meta">{{ $blog->created_at }}</span>
                            <h3 class="blog__content--title"><a href="{{ route('getBlogDetail',$blog->slug) }}">{{
                                    $blog->title }}</a></h3>
                            <a class="blog__content--btn primary__btn"
                                href="{{ route('getBlogDetail',$blog->slug) }}">Read more </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
           
        </div>
    </div>
</section>
@stop