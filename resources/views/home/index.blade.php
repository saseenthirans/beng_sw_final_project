@extends('layouts.home')

@section('title')
    Home
@endsection

@section('content')
    <div class="container">
        <div class="intro-wrapper mb-4">
            <div class="swiper-container swiper-theme nav-inner swiper-nav-md animation-slider"
                data-swiper-options="{
                        'autoplay': {
                            'delay': 8000,
                            'disableOnInteraction': false
                        }
                    }">
                <div class="swiper-wrapper row cols-1 gutter-no">
                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide1 br-sm"
                        style="background-image: url(home_style/images/demos/demo3/slides/slide-1.jpg);
                            background-color: #262729;">
                        <div class="banner-content y-50 x-50 w-100 text-center">
                            <h5 class="banner-subtitle text-primary font-weight-normal text-capitalize font-secondary ls-25 slide-animate"
                                data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s'}">Mega Sale
                            </h5>
                            <h3 class="banner-title text-white text-capitalize ls-25 lh-1 slide-animate"
                                data-animation-options="{'name': 'fadeInRightShorter', 'duration': '.5s', 'delay': '.5s'}">
                                2021 Men's Lifestyle</h3>
                            <p class="ls-25 slide-animate"
                                data-animation-options="{
                                        'name': 'fadeInLeftShorter', 'duration': '.5s', 'delay': '.5s'
                                    }">
                                Get Free Shipping on all orders over $99.00</p>
                            <a href="shop-banner-sidebar.html"
                                class="btn btn-white btn-outline btn-rounded btn-icon-right slide-animate"
                                data-animation-options="{'name': 'fadeInUpShorter', 'duration': '.5s', 'delay': '.5s'}">
                                Shop Now<i class="w-icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- End Of Intro Slide 1 -->
                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide2  br-sm"
                        style="background-image: url(home_style/images/demos/demo3/slides/slide-2.jpg);
                                background-color: #DCE0DF;">
                        <div class="banner-content y-50">
                            <h5 class="banner-subtitle text-primary font-secondary font-weight-normal text-capitalize mb-0 lh-1 ls-25 slide-animate"
                                data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s'}">Best
                                Seller</h5>
                            <h3 class="banner-title text-capitalize lh-.8 slide-animate"
                                data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.4s'}">
                                Kitchen Electronic</h3>
                            <p class="text-default font-weight-normal ls-25 slide-animate"
                                data-animation-options="{
                                        'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.6s'
                                    }">
                                Get Free Shipping on all orders over <strong class="text-primary">$99.00</strong>
                            </p>
                            <a href="shop-banner-sidebar.html"
                                class="btn btn-white btn-rounded btn-icon-right slide-animate"
                                data-animation-options="{'name': 'fadeInDownShorter', 'duration': '.8s', 'delay': '.8s'}">Shop
                                Now<i class="w-icon-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- End of Intro Slide 3 -->
                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide3 br-sm"
                        style="background-image: url(home_style/images/demos/demo3/slides/slide-3.jpg);
                                background-color: #696A6E;">
                        <div class="banner-content y-50 text-right">
                            <div class="slide-animate"
                                data-animation-options="{
                                        'name': 'fadeInUpShorter', 'duration': '.7s'
                                    }">
                                <h5 class="banner-subtitle text-primary font-secondary font-weight-normal ls-25 mb-0 lh-1">
                                    New Arrivals</h5>
                                <h3 class="banner-title text-white text-capitalize lh-1">Sports Sneakers</h3>
                                <p class="text-white ls-25">Get Free Shipping on all orders over
                                    <strong>$99.00</strong>
                                </p>
                                <a href="shop-banner-sidebar.html"
                                    class="btn btn-white btn-outline btn-rounded btn-icon-right">
                                    Shop Now<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="swiper-button-next"></button>
                <button class="swiper-button-prev"></button>
            </div>
        </div>
        <!-- End of Intro Wrapper -->
        <div class="swiper-container swiper-theme intro-banner appear-animate"
            data-swiper-options="{
                    'spaceBetween': 20,
                    'slidesPerView': 1,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2,
                            'spaceBetween': 15
                        },
                        '992': {
                            'slidesPerView': 3
                        }
                    }
                }">

            <div class="swiper-pagination"></div>
        </div>

        <div class="swiper-container swiper-theme icon-box-wrapper appear-animate br-sm mt-6 mb-10"
            data-swiper-options="{
                    'slidesPerView': 1,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2
                        },
                        '768': {
                            'slidesPerView': 3
                        },
                        '992': {
                            'slidesPerView': 3
                        },
                        '1200': {
                            'slidesPerView': 4
                        }
                    }
                }">
            <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                <div class="swiper-slide icon-box icon-box-side text-dark">
                    <span class="icon-box-icon icon-shipping">
                        <i class="w-icon-truck"></i>
                    </span>
                    <div class="icon-box-content">
                        <h4 class="icon-box-title mb-1 ls-normal">Free Shipping & Returns</h4>
                        <p class="text-default">For all orders over $99</p>
                    </div>
                </div>
                <div class="swiper-slide icon-box icon-box-side text-dark">
                    <span class="icon-box-icon icon-payment">
                        <i class="w-icon-bag"></i>
                    </span>
                    <div class="icon-box-content">
                        <h4 class="icon-box-title mb-1 ls-normal">Secure Payment</h4>
                        <p class="text-default">We ensure secure payment</p>
                    </div>
                </div>
                <div class="swiper-slide icon-box icon-box-side text-dark icon-box-money">
                    <span class="icon-box-icon icon-money">
                        <i class="w-icon-money"></i>
                    </span>
                    <div class="icon-box-content">
                        <h4 class="icon-box-title mb-1 ls-normal">Money Back Guarantee</h4>
                        <p class="text-default">Any back within 30 days</p>
                    </div>
                </div>
                <div class="swiper-slide icon-box icon-box-side text-dark icon-box-chat">
                    <span class="icon-box-icon icon-chat">
                        <i class="w-icon-chat"></i>
                    </span>
                    <div class="icon-box-content">
                        <h4 class="icon-box-title mb-1 ls-normal">Customer Support</h4>
                        <p class="text-default">Call or email us 24/7</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Iocn Box Wrapper -->

        <h2 class="title text-left pt-1 mb-5 appear-animate">Categories</h2>
        <div class="swiper">
            <div class="swiper-container category-wrapper swiper-theme appear-animate"
                data-swiper-options="{
                        'spaceBetween': 20,
                        'slidesPerView': 2,
                        'breakpoints': {
                            '576': {
                                'slidesPerView': 3
                            },
                            '768': {
                                'slidesPerView': 4
                            },
                            '992': {
                                'slidesPerView': 5
                            },
                            '1200': {
                                'slidesPerView': 6
                            }
                        }
                    }">
                <div class="swiper-wrapper row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">

                    @foreach ($categories as $item)
                        <div class="swiper-slide category category-ellipse">
                            <figure class="category-media">
                                <a href="{{url('/categories/'.Crypt::encrypt($item->id))}}">
                                    <img src="{{ asset($item->image) }}" alt="Categroy" width="190" height="190"
                                        style="background-color: #5C92C0;" />
                                </a>
                            </figure>
                            <div class="category-content">
                                <h4 class="category-name">
                                    <a href="{{url('/categories/'.Crypt::encrypt($item->id))}}">{{ $item->name }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>


        <!-- End of Category Wrapper -->

        <div class="row deals-wrapper appear-animate mb-7">
            <div class="col-lg-9 mb-4">
                <div class="single-product h-100 br-sm">
                    <h4 class="title-sm title-underline font-weight-bolder ls-normal">Deals Hot Of The Day</h4>
                    <div class="swiper">
                        <div class="swiper-container swiper-theme nav-top swiper-nav-lg"
                            data-swiper-options="{
                                        'spaceBetween': 20,
                                        'slidesPerView': 1
                                    }">
                            <div class="swiper-wrapper row cols-1 gutter-no">

                                @foreach ($deals as $item)
                                    <div class="swiper-slide">
                                        <div class="product product-single row">
                                            <div class="col-md-6">
                                                <div class="product-gallery product-gallery-vertical mb-0">
                                                    <div
                                                        class="swiper-container product-single-swiper swiper-theme nav-inner">
                                                        <div class="swiper-wrapper row cols-1 gutter-no">

                                                            @foreach ($item->inventory->inventoryImage as $images)
                                                                <div class="swiper-slide">
                                                                    <figure class="product-image">
                                                                        <img src="{{ asset($images->image) }}"
                                                                            data-zoom-image="{{ asset($images->image) }}"
                                                                            alt="Product Image" width="800"
                                                                            height="900">
                                                                    </figure>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                        <button class="swiper-button-next"></button>
                                                        <button class="swiper-button-prev"></button>
                                                    </div>
                                                    <div class="product-thumbs-wrap swiper-container"
                                                        data-swiper-options="{
                                                                'breakpoints': {
                                                                    '992': {
                                                                        'direction': 'vertical',
                                                                        'slidesPerView': 'auto'
                                                                    }
                                                                }
                                                            }">
                                                        <div
                                                            class="product-thumbs swiper-wrapper row cols-lg-1 cols-4 gutter-sm">
                                                            @foreach ($item->inventory->inventoryImage as $images)
                                                                <div class="swiper-slide product-thumb">
                                                                    <img src="{{ asset($images->image) }}"
                                                                        alt="Product thumb" width="60"
                                                                        height="68" />
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="product-details scrollable">
                                                    <h2 class="product-title mb-1"><a
                                                            href="product-default.html">{{ $item->inventory->name }}</a>
                                                    </h2>

                                                    <hr class="product-divider">
                                                    @php
                                                        if ($item->sale_type == 1) {
                                                            $sale_value = $item->inventory->price - ($item->inventory->price * $item->amount) / 100;
                                                        } else {
                                                            $sale_value = $item->inventory->price - $item->amount;
                                                        }

                                                        $sales_end = date('Y, m, d', strtotime($item->end_date));
                                                    @endphp
                                                    <div class="product-price"><ins class="new-price ls-50">
                                                            <span
                                                                style="text-decoration: line-through; font-size: 1.8rem">{{ $item->inventory->price }}</span>
                                                            -
                                                            {{ number_format($sale_value, 2, '.', '') }}</ins></div>

                                                    <div class="product-countdown-container flex-wrap">
                                                        <label class="mr-2 text-default">Offer Ends In:</label>
                                                        <div class="product-countdown countdown-compact"
                                                            data-until="{{ $sales_end }}" data-compact="true">
                                                            629 days, 11: 59: 52</div>
                                                    </div>

                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 80%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <a href="#" class="rating-reviews">(3 Reviews)</a>
                                                    </div>

                                                    <div class="product-form pt-4">
                                                        <div class="product-qty-form mb-2 mr-2">
                                                            <div class="input-group">
                                                                <input class="quantity form-control" type="number"
                                                                    min="1" max="10000000">
                                                                <button class="quantity-plus w-icon-plus"></button>
                                                                <button class="quantity-minus w-icon-minus"></button>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-cart">
                                                            <i class="w-icon-cart"></i>
                                                            <span>Add to Cart</span>
                                                        </button>
                                                    </div>

                                                    <div class="social-links-wrapper mt-1">
                                                        <div class="social-links">
                                                            <div class="social-icons social-no-color border-thin">
                                                                <a href="#"
                                                                    class="social-icon social-facebook w-icon-facebook"></a>
                                                                <a href="#"
                                                                    class="social-icon social-twitter w-icon-twitter"></a>
                                                                <a href="#"
                                                                    class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                                <a href="#"
                                                                    class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                                <a href="#"
                                                                    class="social-icon social-youtube fab fa-linkedin-in"></a>
                                                            </div>
                                                        </div>
                                                        <span class="divider d-xs-show"></span>
                                                        <div class="product-link-wrapper d-flex">
                                                            <a href="#"
                                                                class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                            <a href="#"
                                                                class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="swiper-button-next"></button>
                            <button class="swiper-button-prev"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="widget widget-products widget-products-bordered h-100">
                    <div class="widget-body br-sm h-100">
                        <h4 class="title-sm title-underline font-weight-bolder ls-normal mb-2">Top 20 Best
                            Seller</h4>
                        <div class="swiper">
                            <div class="swiper-container swiper-theme nav-top"
                                data-swiper-options="{
                                        'slidesPerView': 1,
                                        'spaceBetween': 20,
                                        'breakpoints': {
                                            '576': {
                                                'slidesPerView': 2
                                            },
                                            '768': {
                                                'slidesPerView': 3
                                            },
                                            '992': {
                                                'slidesPerView': 1
                                            }
                                        }
                                    }">
                                <div class="swiper-wrapper row cols-lg-1 cols-md-3">
                                    <div class="swiper-slide product-widget-wrap">
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-1.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Fashionable Leather Satchel</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 80%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$25.68</ins>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-2.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Mini Wireless Earphone</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 80%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$29.99 - $49.00</ins>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-3.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Women's Comforter</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$24.00</ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-widget-wrap">
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-4.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Apple Fashion IPhone</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$123.00</ins>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-5.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">T-Shirt</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$80.00</ins><del
                                                        class="old-price">$100.00</del>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-6.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Tea Cup</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$18.00</ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-widget-wrap">
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-7.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Soft Sound Marker</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$39.00</ins>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-8.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Smart Watch</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$230.95</ins><del
                                                        class="old-price">$253.50</del>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product product-widget">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="home_style/images/demos/demo3/products/1-9.jpg"
                                                        alt="Product" width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="product-default.html">Rotate Crusher</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price">$65.00</ins><del class="old-price">$70.00</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Deals Wrapper -->

        @foreach ($home_categories as $item)
            <h2 class="title text-left appear-animate mb-5">{{ $item->name }}</h2>
            <div class="row banner-product-wrapper appear-animate mb-10">
                <div class="col-lg-9 mb-4 mb-lg-0">
                    <div class="banner banner-fixed br-sm appear-animate">
                        <figure>
                            <img src="{{ asset($item->banner_image) }}" alt="banner" width="925" height="298"
                                style="background-color: #ECEDE8;" />
                        </figure>
                        <div class="banner-content y-50">

                            <h3 class="banner-title font-weight-bold text-uppercase ls-25">
                                {{ $item->banner_title }}
                            </h3>
                            <a href="{{url('/categories/'.Crypt::encrypt($item->id))}}" class="btn btn-dark btn-outline btn-rounded">Shop
                                Now</a>
                        </div>
                    </div>
                    <div class="swiper-container swiper-theme mt-4"
                        data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '576': {
                                        'slidesPerView': 3
                                    },
                                    '768': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">
                        <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-2">
                            @foreach ($item->activeSubCategory as $actCategory)
                                @foreach ($actCategory->getInventory as $inventory)
                                    <div class="swiper-slide product-wrap">
                                        <div class="product product-simple text-center">
                                            <figure class="product-media">
                                                <a href="product-default.html">
                                                    <img src="{{ asset($inventory->image) }}" alt="Product"
                                                        width="330" height="338" />
                                                    <img src="{{ asset($inventory->image) }}" alt="Product"
                                                        width="330" height="338" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist"></a>
                                                </div>

                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a
                                                        href="product-default.html">{{ $inventory->name }}</a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                                </div>
                                                @php
                                                    if ($inventory->saleItem) {
                                                        if ($inventory->saleItem->sale_type == 1) {
                                                            $sale_value = $inventory->price - ($inventory->price * $inventory->saleItem->amount) / 100;
                                                        } else {
                                                            $sale_value = $inventory->price - $inventory->saleItem->amount;
                                                        }
                                                    } else {
                                                        $sale_value = $inventory->price;
                                                    }
                                                @endphp
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <ins class="new-price">{{ number_format($sale_value,2,'.','') }}</ins>
                                                    </div>
                                                    <div class="product-action">
                                                        <a href="#"
                                                            class="btn-cart btn-product btn btn-icon-right btn-link btn-underline">Add
                                                            To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach

                            <!-- End of Product Wrap -->

                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget widget-products widget-products-bordered h-100">
                        <div class="widget-body br-sm pb-2 h-100">
                            <h4 class="title-sm title-underline font-weight-bolder ls-normal mb-2">Featured Products</h4>
                            <div class="swiper">
                                <div class="swiper-container swiper-theme nav-top"
                                    data-swiper-options="{
                                            'slidesPerView': 1,
                                            'spaceBetween': 20,
                                            'breakpoints': {
                                                '576': {
                                                    'slidesPerView': 2
                                                },
                                                '992': {
                                                    'slidesPerView': 1
                                                }
                                            }
                                        }">
                                    <div class="swiper-wrapper row cols-lg-1 cols-md-3">
                                        @foreach ($item->activeSubCategory as $actCategory)
                                            <div class="swiper-slide product-widget-wrap">

                                                @foreach ($actCategory->getInventory as $inventory)
                                                    <div class="product product-widget bb-no">
                                                        <figure class="product-media">
                                                            <a href="product-default.html">
                                                                <img src="{{ asset($inventory->image) }}" alt="Product"
                                                                    width="105" height="118" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="product-default.html">{{ $inventory->name }}</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 80%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            @php
                                                                if ($inventory->saleItem) {
                                                                    if ($inventory->saleItem->sale_type == 1) {
                                                                        $sale_value = $inventory->price - ($inventory->price * $inventory->saleItem->amount) / 100;
                                                                    } else {
                                                                        $sale_value = $inventory->price - $inventory->saleItem->amount;
                                                                    }
                                                                } else {
                                                                    $sale_value = $inventory->price;
                                                                }
                                                            @endphp
                                                            <div class="product-price">
                                                                <ins class="new-price">{{ number_format($sale_value,2,'.','') }}</ins>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach

                                    </div>
                                    <button class="swiper-button-next"></button>
                                    <button class="swiper-button-prev"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Banner Product Wrapper -->
    </div>
@endsection
