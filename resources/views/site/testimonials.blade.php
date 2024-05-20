@extends('site.template', ['title' => __('Our Costomers Testimonial')])
@section('content')
<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Testimonials</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Testimonials</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- Start blog details section -->
<section class="blog__details--section section--padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-8">
                <div class="blog__details--wrapper">
                    <div id="product_list" class="tab_pane active show">
                        <div class="product__section--inner">
                            <div class="row row-cols-1 mb--n30">
                                @foreach($testimonials as $testimonial)
                                <div class="col mb-30">
                                    <div class="product__items product__list--items d-flex">
                                        <div class="product__items--thumbnail product__list--items__thumbnail">
                                            <a class="product__items--link" href="">
                                                <img class="product__items--img product__primary--img" src="{{asset('site/uploads/testimonials/'.$testimonial->photo)}}" alt="product-img">
                                            </a>
                                        </div>
                                        <div class="product__list--items__content">
                                            <h3 class="product__list--items__content--title h4 mb-10"><a href="">{{ $testimonial->title }}</a></h3>
                              <ul class="rating product__rating d-flex">
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </li>
                                            </ul>
                                            <p class="product__list--items__content--desc d-xl-none mb-15">{!! $testimonial->detail !!}</p>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-4">
                <div class="blog__sidebar--widget left widget__area">
                    <div class="single__widget widget__search widget__bg">
                        <h2 class="widget__title h3">Search</h2>
                        <form class="widget__search--form" action="#">
                            <label>
                                <input class="widget__search--form__input" placeholder="Search..." type="text">
                            </label>
                            <button class="widget__search--form__btn" aria-label="search button" type="button">
                                <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path></svg>
                            </button>
                        </form>
                    </div>
                   
                    <div class="single__widget widget__bg">
                       <h2 class="widget__title h3">Our Products</h2>
                        <div class="product__grid--inner">
                            @foreach($products as $product)
                            <div class="product__items product__items--grid d-flex align-items-center">
                                <div class="product__items--grid__thumbnail position__relative">
                                    <a class="product__items--link" href="{{ route('getProductDetail', $product->slug) }}">
                                        <img class="product__grid--items__img product__primary--img" src="{{ asset('site/uploads/products/'.$product->photo) }}" alt="product-img">
                                        <img class="product__grid--items__img product__secondary--img" src="{{ asset('site/uploads/products/'.$product->alt_photo) }}" alt="product-img">
                                    </a>
                                </div>
                                <div class="product__items--grid__content">
                                    <h3 class="product__items--content__title h4"><a href="{{ route('getProductDetail', $product->slug) }}">{{ $product->name }}</a></h3>
                                    @if($product->dcost !=null)
                                    <span class="current__price" style="font-weight: bold;">MYR {{ $product->dcost }}</span>
                                    <span class="price__divided"></span>
                                    <span class="old__price">MYR {{ $product->acost }}</span>
                                    @else
                                    <span class="current__price" style="font-weight: bold;">MYR {{ $product->acost }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop