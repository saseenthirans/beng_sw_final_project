<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Mobile Shop Management System | {{ $company->name }}</title>

    <meta name="keywords" content="Marketplace ecommerce responsive HTML5 Template" />
    <meta name="description" content="Wolmart is powerful marketplace &amp; ecommerce responsive Html5 Template.">
    <meta name="author" content="D-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('home_style/images/icons/favicon.png') }}">

    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: {
                families: ['Poppins:400,600,500,700,800', 'Zeyada: 400']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = '{{ asset('home_style/js/webfont.js') }}';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <link rel="preload" href="{{ asset('home_style/vendor/fontawesome-free/webfonts/fa-regular-400.woff2') }}"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ asset('home_style/vendor/fontawesome-free/webfonts/fa-solid-900.woff2') }}"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ asset('home_style/vendor/fontawesome-free/webfonts/fa-brands-400.woff2') }}"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{ asset('home_style/fonts/wolmart87d5.woff?png09e') }}" as="font" type="font/woff"
        crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home_style/vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('home_style/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('home_style/vendor/animate/animate.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('home_style/vendor/magnific-popup/magnific-popup.min.css') }}">

    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home_style/css/demo3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('home_style/css/style.min.css')}}">
</head>

<body class="home">
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <p class="welcome-msg">Welcome to {{ $company->name }}</p>
                    </div>
                    <div class="header-right">

                        <!-- End of Dropdown Menu -->
                        <a href="my-account.html" class="d-lg-show">My Account</a>
                        <a href="home_style/ajax/login.html" class="d-lg-show login sign-in"><i
                                class="w-icon-account"></i>Sign In</a>
                        <span class="delimiter d-lg-show">/</span>
                        <a href="home_style/ajax/login.html" class="ml-0 d-lg-show login register">Register</a>
                    </div>
                </div>
            </div>
            <!-- End of Header Top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="#" class="mobile-menu-toggle  w-icon-hamburger" aria-label="menu-toggle">
                        </a>
                        <a href="{{ url('/') }}" class="logo ml-lg-0">
                            <img src="{{ asset('home_style/images/logo.png') }}" alt="logo" width="144"
                                height="45" />
                        </a>
                        <form method="get" action="#"
                            class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">

                            <input type="text" class="form-control" name="search" id="search"
                                placeholder="Search in..." required />
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header-right ml-4">
                        <div class="header-call d-xs-show d-lg-flex align-items-center">
                            <a href="tel:#" class="w-icon-call"></a>
                            <div class="call-info d-lg-show">
                                <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                                    <a href="mailto:{{ $company->email }}" class="text-capitalize">Live Chat</a> or :
                                </h4>
                                <a href="tel:{{ $company->contact }}"
                                    class="phone-number font-weight-bolder ls-50">{{ $company->contact }}</a>
                            </div>
                        </div>
                        <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                            <div class="cart-overlay"></div>
                            <a href="#" class="cart-toggle label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count">2</span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                            <div class="dropdown-box">
                                <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close">Close<i
                                            class="w-icon-long-arrow-right"></i></a>
                                </div>

                                <div class="products">
                                    <div class="product product-cart">
                                        <div class="product-detail">
                                            <a href="product-default.html" class="product-name">Beige knitted
                                                elas<br>tic
                                                runner shoes</a>
                                            <div class="price-box">
                                                <span class="product-quantity">1</span>
                                                <span class="product-price">$25.68</span>
                                            </div>
                                        </div>
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="home_style/images/cart/product-1.jpg" alt="product"
                                                    height="84" width="94" />
                                            </a>
                                        </figure>
                                        <button class="btn btn-link btn-close" aria-label="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="product product-cart">
                                        <div class="product-detail">
                                            <a href="product-default.html" class="product-name">Blue utility
                                                pina<br>fore
                                                denim dress</a>
                                            <div class="price-box">
                                                <span class="product-quantity">1</span>
                                                <span class="product-price">$32.99</span>
                                            </div>
                                        </div>
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="home_style/images/cart/product-2.jpg" alt="product"
                                                    width="84" height="94" />
                                            </a>
                                        </figure>
                                        <button class="btn btn-link btn-close" aria-label="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="cart-total">
                                    <label>Subtotal:</label>
                                    <span class="price">$58.67</span>
                                </div>

                                <div class="cart-action">
                                    <a href="cart.html" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                    <a href="checkout.html" class="btn btn-primary  btn-rounded">Checkout</a>
                                </div>
                            </div>
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->
            @php
                $segment = Request::segment(1);
            @endphp
            <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <div class="dropdown category-dropdown {{!$segment ? 'show-dropdown' : 'has-border'}} " data-visible="true">
                                <a href="#" class="text-white category-toggle" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                    data-display="static" title="Browse Categories">
                                    <i class="w-icon-category"></i>
                                    <span>Browse Categories</span>
                                </a>

                                <div class="dropdown-box">
                                    <ul class="menu vertical-menu category-menu">
                                        @foreach ($categories as $item)
                                            <li>
                                                <a href="{{url('/categories/'.Crypt::encrypt($item->id))}}">
                                                    {{ $item->name }}
                                                </a>
                                                <ul class="megamenu">
                                                    <li>
                                                        <ul>
                                                            @foreach ($item->activeSubCategory as $aitem)
                                                                <li><a
                                                                        href="{{url('/sub_categories/'.Crypt::encrypt($aitem->id))}}">{{ $aitem->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endforeach

                                        @if ($categories_count > 11)
                                            <li>
                                                <a href="shop-banner-sidebar.html"
                                                    class="font-weight-bold text-uppercase ls-25">
                                                    View All Categories<i class="w-icon-angle-right"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <nav class="main-nav">
                                <ul class="menu active-underline">
                                    <li class="active">
                                        <a href="{{url('/')}}">Home</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- End of Header -->

        <!-- Start of Main -->
        <div class="main">
            @yield('content')

        </div>
        <!-- End of Main -->

        <!-- Start of Footer -->
        <footer class="footer footer-dark appear-animate">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget widget-about">
                                <a href="demo3.html" class="logo-footer">
                                    <img src="{{asset('home_style/images/footer_logo.png')}}" alt="logo-footer"
                                        width="145" height="45" />
                                </a>
                                <div class="widget-body">
                                    <p class="widget-about-title">Got Question? Call us 24/7</p>
                                    <a href="tel:18005707777" class="widget-about-call">{{$company->contact}}</a>
                                    <p class="widget-about-desc">Register now to get updates on pronot get up icons
                                        & coupons ster now toon.
                                    </p>

                                    <div class="social-icons social-icons-colored">
                                        <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                        <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                        <a href="#" class="social-icon social-instagram w-icon-instagram"></a>
                                        <a href="#" class="social-icon social-youtube w-icon-youtube"></a>
                                        <a href="#" class="social-icon social-pinterest w-icon-pinterest"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget">
                                <h3 class="widget-title">Company</h3>
                                <ul class="widget-body">
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="contact-us.html">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4>
                                <ul class="widget-body">
                                    <li><a href="#">Payment Methods</a></li>
                                    <li><a href="#">Money-back guarantee!</a></li>
                                    <li><a href="#">Product Returns</a></li>
                                    <li><a href="#">Support Center</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Term and Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-left">
                        <p class="copyright">Copyright © {{date('Y')}} {{$company->name}}. All Rights Reserved.</p>
                    </div>
                    <div class="footer-right">
                        <span class="payment-label mr-lg-8">We're using safe payment for</span>
                        <figure class="payment">
                            <img src="{{asset('home_style/images/payment.png')}}" alt="payment" width="159" height="25" />
                        </figure>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Page-wrapper -->

    <!-- Start of Sticky Footer -->
    <div class="sticky-footer sticky-content fix-bottom">
        <a href="demo3.html" class="sticky-link active">
            <i class="w-icon-home"></i>
            <p>Home</p>
        </a>
        <a href="shop-banner-sidebar.html" class="sticky-link">
            <i class="w-icon-category"></i>
            <p>Shop</p>
        </a>
        <a href="my-account.html" class="sticky-link">
            <i class="w-icon-account"></i>
            <p>Account</p>
        </a>
        <div class="cart-dropdown dir-up">
            <a href="cart.html" class="sticky-link">
                <i class="w-icon-cart"></i>
                <p>Cart</p>
            </a>
            <div class="dropdown-box">
                <div class="products">
                    <div class="product product-cart">
                        <div class="product-detail">
                            <h3 class="product-name">
                                <a href="product-default.html">Beige knitted elas<br>tic
                                    runner shoes</a>
                            </h3>
                            <div class="price-box">
                                <span class="product-quantity">1</span>
                                <span class="product-price">$25.68</span>
                            </div>
                        </div>
                        <figure class="product-media">
                            <a href="product-default.html">
                                <img src="home_style/images/cart/product-1.jpg" alt="product" height="84"
                                    width="94" />
                            </a>
                        </figure>
                        <button class="btn btn-link btn-close" aria-label="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="product product-cart">
                        <div class="product-detail">
                            <h3 class="product-name">
                                <a href="product-default.html">Blue utility pina<br>fore
                                    denim dress</a>
                            </h3>
                            <div class="price-box">
                                <span class="product-quantity">1</span>
                                <span class="product-price">$32.99</span>
                            </div>
                        </div>
                        <figure class="product-media">
                            <a href="product-default.html">
                                <img src="home_style/images/cart/product-2.jpg" alt="product" width="84"
                                    height="94" />
                            </a>
                        </figure>
                        <button class="btn btn-link btn-close" aria-label="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="cart-total">
                    <label>Subtotal:</label>
                    <span class="price">$58.67</span>
                </div>

                <div class="cart-action">
                    <a href="cart.html" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                    <a href="checkout.html" class="btn btn-primary  btn-rounded">Checkout</a>
                </div>
            </div>
            <!-- End of Dropdown Box -->
        </div>


        <div class="header-search hs-toggle dir-up">
            <a href="#" class="search-toggle sticky-link">
                <i class="w-icon-search"></i>
                <p>Search</p>
            </a>
            <form action="#" class="input-wrapper">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- End of Sticky Footer -->

    <!-- Start of Scroll Top -->
    <a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button"> <i
            class="w-icon-angle-up"></i> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
            <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10"
                cx="35" cy="35" r="34" style="stroke-dasharray: 16.4198, 400;"></circle>
        </svg> </a>
    <!-- End of Scroll Top -->

    <!-- Start of Mobile Menu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay"></div>
        <!-- End of .mobile-menu-overlay -->

        <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
        <!-- End of .mobile-menu-close -->

        <div class="mobile-menu-container scrollable">
            <form action="#" method="get" class="input-wrapper">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form>
            <!-- End of Search Form -->
            <div class="tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#main-menu" class="nav-link active">Main Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="#categories" class="nav-link">Categories</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="main-menu">
                    <ul class="mobile-menu">
                        <li><a href="demo3.html">Home</a></li>

                    </ul>
                </div>
                <div class="tab-pane" id="categories">
                    <ul class="mobile-menu">
                        @foreach ($categories as $item)
                            <li>
                                <a href="{{url('/categories/'.Crypt::encrypt($item->id))}}">
                                    {{ $item->name }}
                                </a>
                                <ul>
                                    @foreach ($item->activeSubCategory as $aitem)
                                        <li><a href="{{url('/sub_categories/'.Crypt::encrypt($aitem->id))}}">{{ $aitem->name }}</a>
                                        </li>
                                    @endforeach


                                </ul>
                            </li>
                        @endforeach
                        @if ($categories_count > 11)
                            <li>
                                <a href="shop-banner-sidebar.html"
                                    class="font-weight-bold text-primary text-uppercase ls-25">
                                    View All Categories<i class="w-icon-angle-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Mobile Menu -->

    <!-- Start of Newsletter popup -->
    <div class="newsletter-popup mfp-hide">
        <div class="newsletter-content">
            <h4 class="text-uppercase font-weight-normal ls-25">Get Up to<span class="text-primary">25% Off</span>
            </h4>
            <h2 class="ls-25">Sign up to Wolmart</h2>
            <p class="text-light ls-10">Subscribe to the Wolmart market newsletter to
                receive updates on special offers.</p>
            <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                <input type="email" class="form-control email font-size-md" name="email" id="email2"
                    placeholder="Your email address" required="">
                <button class="btn btn-dark" type="submit">SUBMIT</button>
            </form>
            <div class="form-checkbox d-flex align-items-center">
                <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup"
                    name="hide-newsletter-popup" required="">
                <label for="hide-newsletter-popup" class="font-size-sm text-light">Don't show this popup
                    again.</label>
            </div>
        </div>
    </div>
    <!-- End of Newsletter popup -->

    <!-- Start of Quick View -->
    <div class="product product-single product-popup">
        <div class="row gutter-lg">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-gallery product-gallery-sticky">
                    <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                        <div class="swiper-wrapper row cols-1 gutter-no">
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('home_style/images/products/popup/1-440x494.jpg')}}"
                                        data-zoom-image="{{asset('home_style/images/products/popup/1-800x900.jpg')}}"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('home_style/images/products/popup/2-440x494.jpg')}}"
                                        data-zoom-image="{{asset('home_style/images/products/popup/2-800x900.jpg')}}"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('home_style/images/products/popup/3-440x494.jpg')}}"
                                        data-zoom-image="{{asset('home_style/images/products/popup/3-800x900.jpg')}}"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('home_style/images/products/popup/4-440x494.jpg')}}"
                                        data-zoom-image="{{asset('home_style/images/products/popup/4-800x900.jpg')}}"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                        </div>
                        <button class="swiper-button-next"></button>
                        <button class="swiper-button-prev"></button>
                    </div>
                    <div class="product-thumbs-wrap swiper-container"
                        data-swiper-options="{
                        'navigation': {
                            'nextEl': '.swiper-button-next',
                            'prevEl': '.swiper-button-prev'
                        }
                    }">
                        <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('home_style/images/products/popup/1-103x116.jpg')}}" alt="Product Thumb"
                                    width="103" height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('home_style/images/products/popup/2-103x116.jpg')}}" alt="Product Thumb"
                                    width="103" height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('home_style/images/products/popup/3-103x116.jpg')}}" alt="Product Thumb"
                                    width="103" height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('home_style/images/products/popup/4-103x116.jpg')}}" alt="Product Thumb"
                                    width="103" height="116">
                            </div>
                        </div>
                        <button class="swiper-button-next"></button>
                        <button class="swiper-button-prev"></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 overflow-hidden p-relative">
                <div class="product-details scrollable pl-0">
                    <h2 class="product-title">Electronics Black Wrist Watch</h2>
                    <div class="product-bm-wrapper">
                        <figure class="brand">
                            <img src="{{asset('home_style/images/products/brand/brand-1.jpg')}}" alt="Brand" width="102"
                                height="48" />
                        </figure>
                        <div class="product-meta">
                            <div class="product-categories">
                                Category:
                                <span class="product-category"><a href="#">Electronics</a></span>
                            </div>
                            <div class="product-sku">
                                SKU: <span>MS46891340</span>
                            </div>
                        </div>
                    </div>

                    <hr class="product-divider">

                    <div class="product-price">$40.00</div>

                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width: 80%;"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="#" class="rating-reviews">(3 Reviews)</a>
                    </div>

                    <div class="product-short-desc">
                        <ul class="list-type-check list-style-none">
                            <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                            <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                            <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                        </ul>
                    </div>

                    <hr class="product-divider">

                    <div class="product-form product-variation-form product-color-swatch">
                        <label>Color:</label>
                        <div class="d-flex align-items-center product-variations">
                            <a href="#" class="color" style="background-color: #ffcc01"></a>
                            <a href="#" class="color" style="background-color: #ca6d00;"></a>
                            <a href="#" class="color" style="background-color: #1c93cb;"></a>
                            <a href="#" class="color" style="background-color: #ccc;"></a>
                            <a href="#" class="color" style="background-color: #333;"></a>
                        </div>
                    </div>
                    <div class="product-form product-variation-form product-size-swatch">
                        <label class="mb-1">Size:</label>
                        <div class="flex-wrap d-flex align-items-center product-variations">
                            <a href="#" class="size">Small</a>
                            <a href="#" class="size">Medium</a>
                            <a href="#" class="size">Large</a>
                            <a href="#" class="size">Extra Large</a>
                        </div>
                        <a href="#" class="product-variation-clean">Clean All</a>
                    </div>

                    <div class="product-variation-price">
                        <span></span>
                    </div>

                    <div class="product-form">
                        <div class="product-qty-form">
                            <div class="input-group">
                                <input class="quantity form-control" type="number" min="1" max="10000000">
                                <button class="quantity-plus w-icon-plus"></button>
                                <button class="quantity-minus w-icon-minus"></button>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-cart">
                            <i class="w-icon-cart"></i>
                            <span>Add to Cart</span>
                        </button>
                    </div>

                    <div class="social-links-wrapper">
                        <div class="social-links">
                            <div class="social-icons social-no-color border-thin">
                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                            </div>
                        </div>
                        <span class="divider d-xs-show"></span>
                        <div class="product-link-wrapper d-flex">
                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                            <a href="#"
                                class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Quick view -->

    <!-- Plugin JS File -->
    <script src="{{asset('home_style/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/parallax/parallax.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/jquery.plugin/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/zoom/jquery.zoom.js')}}"></script>
    <script src="{{asset('home_style/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/jquery.countdown/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('home_style/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <!-- Main Js -->
    <script src="{{asset('home_style/js/main.min.js')}}"></script>

    <!-- Add to Cart -->

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.btn_add_to_cart').click(function (e) {
                e.preventDefault();
                var id = $(this).closest('._product_data').find('._product_id').val();
                var qty = $(this).closest('._product_data').find('.quantity').val();

                var data = {
                    'product_id' : id,
                    'qty' : qty
                }

                $.ajax({
                    type: "POST",
                    url: "{{url('/add_to_cart')}}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {

                    }
                });

            });
        });
    </script>

    @yield('scripts')
</body>

</html>
