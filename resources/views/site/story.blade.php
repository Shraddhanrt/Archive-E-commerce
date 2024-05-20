@extends('site.template', ['title' => __('Our Story')])
@section('content')
<!-- Start breadcrumb section -->
<section class="breadcrumb__section breadcrumb__bg">
    <div class="container">
        <div class="row row-cols-1">
            <div class="col">
                <div class="breadcrumb__content text-center">
                    <h1 class="breadcrumb__content--title text-white mb-25">Story</h1>
                    <ul class="breadcrumb__content--menu d-flex justify-content-center">
                        <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('getHome') }}">Home</a></li>
                        <li class="breadcrumb__content--menu__items"><span class="text-white">Story</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb section -->

<!-- Start about section -->
<section class="about__section section--padding mb-95">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__thumb d-flex">
                    <div class="about__thumb--items">
                        <img class="about__thumb--img border-radius-5 display-block" src="{{ asset('site/assets/img/other/about-thumb-list2.png') }}" alt="about-thumb">
                        <div class="banner__bideo--play about__thumb--play">
                            <!-- <a class="banner__bideo--play__icon about__thumb--play__icon glightbox" href="https://vimeo.com/115041822" data-gallery="video">
                                <svg id="play" xmlns="http://www.w3.org/2000/svg" width="40.302" height="40.302" viewBox="0 0 46.302 46.302">
                                    <g id="Group_193" data-name="Group 193" transform="translate(0 0)">
                                    <path id="Path_116" data-name="Path 116" d="M39.521,6.781a23.151,23.151,0,0,0-32.74,32.74,23.151,23.151,0,0,0,32.74-32.74ZM23.151,44.457A21.306,21.306,0,1,1,44.457,23.151,21.33,21.33,0,0,1,23.151,44.457Z" fill="currentColor"/>
                                    <g id="Group_188" data-name="Group 188" transform="translate(15.588 11.19)">
                                        <g id="Group_187" data-name="Group 187">
                                        <path id="Path_117" data-name="Path 117" d="M190.3,133.213l-13.256-8.964a3,3,0,0,0-4.674,2.482v17.929a2.994,2.994,0,0,0,4.674,2.481l13.256-8.964a3,3,0,0,0,0-4.963Zm-1.033,3.435-13.256,8.964a1.151,1.151,0,0,1-1.8-.953V126.73a1.134,1.134,0,0,1,.611-1.017,1.134,1.134,0,0,1,1.185.063l13.256,8.964a1.151,1.151,0,0,1,0,1.907Z" transform="translate(-172.366 -123.734)" fill="currentColor"/>
                                        </g>
                                    </g>
                                    <g id="Group_190" data-name="Group 190" transform="translate(28.593 5.401)">
                                        <g id="Group_189" data-name="Group 189">
                                        <path id="Path_118" data-name="Path 118" d="M328.31,70.492a18.965,18.965,0,0,0-10.886-10.708.922.922,0,1,0-.653,1.725,17.117,17.117,0,0,1,9.825,9.664.922.922,0,1,0,1.714-.682Z" transform="translate(-316.174 -59.724)" fill="currentColor"/>
                                        </g>
                                    </g>
                                    <g id="Group_192" data-name="Group 192" transform="translate(22.228 4.243)">
                                        <g id="Group_191" data-name="Group 191">
                                        <path id="Path_119" data-name="Path 119" d="M249.922,47.187a19.08,19.08,0,0,0-3.2-.27.922.922,0,0,0,0,1.845,17.245,17.245,0,0,1,2.889.243.922.922,0,1,0,.31-1.818Z" transform="translate(-245.801 -46.917)" fill="currentColor"/>
                                        </g>
                                    </g>
                                    </g>
                                </svg>
                                <span class="visually-hidden">Video Play</span>
                            </a> -->
                        </div>
                       
                    </div>
                    <div class="about__thumb--items position__relative">
                        <img class="about__thumb--img border-radius-5 display-block" src="{{ asset('site/assets/img/other/about-thumb-list1.jpg') }}" alt="about-thumb" width="350">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__content">
                    <span class="about__content--subtitle text__secondary mb-20"> Why Choose us</span>
                    <h2 class="about__content--maintitle mb-25">How We Started!!</h2>
                    <p class="about__content--desc mb-20">This brand is a mother daughter initiative to bring nature into your daily life. We carry the pride of being the first Malaysian based weight loss brand to focus on creating highly constructive  & proven weight loss products based on 100%  Indian herbs and nature based. Ritz Enchantress is an attempt for individuals to love themselves in a healthy way.</p>
                    <p class="about__content--desc mb-20">The modern world brought advancement and ease in our lives, but at the same time introduced a new  setback  called obesity or being in an unhealthy BMI range. Our ancestors, who were very close to nature and herbs, may never have felt this physical condition in their life. Judging from the present situation, we can obviously see that our current lifestyle revolves around time, where we have minimal physical activity, and our meals are not well taken care of.
</p>
                    <p class="about__content--desc mb-25">Furthermore, it must be agreed that our body is at its best when we are living life close to nature and its magic. This kind of less physical activity and more time rushing lifestyle has brought in one of the most suffered diseases called obesity (according to an study by MOH,  in 2020 there is 54.2% of overweight and obese adult in Malaysia). Obesity is when abnormal or excessive fat accumulation may impair an individual's health.</p>
                </div>
            </div>
        </div>
        <br /> <br />
        <div class="row">
            <div class="col-md-12">
                <p>In order to lose weight, this are the things that one has to do:</p>



            <strong>1. Self-Acceptance</strong> <br />

            A person has to come in terms with themselves and accept their body.  <br /> <br />



<strong>2. Set your Dream & Ideal Weight</strong>  <br />

    Check your current bmi with us and also the ideal weight for yourself.   We all have our dream body and this is the right time to set yours.
<br /> <br />


<strong>3. Get your Ritz Routine</strong> <br />
<img src="{{ asset('site/assets/img/other/daily-route.jpg') }}" alt="" width="50%">

<br /> <br />

<strong>4. Practice Portion Control</strong> <br />

Portion control is a way of eating your daily food in a specific amount, it plays a big role in weight loss. It sounds so simple: Don’t eat or drink too much. Portion control lets you eat whatever you want just in a small portio and gets you the nutrient benefits without overeating. 
<br /> <br />



<strong>5. Drink Water & Get Your Beauty Sleep</strong> <br />

Water is an important element for your weight loss journey as it helps to keep you hydrated while suppressing appetite. Drinking 8 glasses of water a day is a must. Moreover, it must also be taken into account that getting an adequate amount of quality sleep is important for weight loss journey. Losing sleep may induce stress that encourages overeating. 

<br /> <br />

<strong>6. Trust The Process</strong> <br />

Celebrate all your small wins. Remember that it takes small steps to reach the destination. 

            </div>
        </div>
    </div>
</section>
<!-- End about section -->



<!-- End team members section -->


@stop