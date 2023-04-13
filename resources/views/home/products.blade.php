@extends('layouts.home')

@section('title')
    {{$inventory->name}}
@endsection

@section('content')

<nav class="breadcrumb-nav container">
    <ul class="breadcrumb bb-no">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Products</li>
    </ul>
</nav>

<div class="page-content">
    <div class="container">
        <div class="row gutter-lg">
            <div class="main-content">
                <div class="product product-single row">
                    <div class="col-md-6 mb-6">
                        <div class="product-gallery product-gallery-sticky">
                            <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                'navigation': {
                                    'nextEl': '.swiper-button-next',
                                    'prevEl': '.swiper-button-prev'
                                }
                            }">
                                <div class="swiper-wrapper row cols-1 gutter-no">
                                    @foreach ($inventory->inventoryImage as $item)
                                        <div class="swiper-slide">
                                            <figure class="product-image">
                                                <img src="{{asset($item->image)}}"
                                                    data-zoom-image="{{asset($item->image)}}"
                                                    alt="Electronics Black Wrist Watch" width="800" height="900">
                                            </figure>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                                <a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>
                            </div>
                            <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                'navigation': {
                                    'nextEl': '.swiper-button-next',
                                    'prevEl': '.swiper-button-prev'
                                }
                            }">
                                <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                    @foreach ($inventory->inventoryImage as $item)
                                        <div class="product-thumb swiper-slide">
                                            <img src="{{asset($item->image)}}"
                                                alt="Product Thumb" width="800" height="900">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-6">
                        <div class="product-details" data-sticky-options="{'minWidth': 767}">
                            <h1 class="product-title">{{$inventory->name}}</h1>

                            @php
                                        if ($inventory->saleItem) {
                                            $sale = true;
                                            if ($inventory->saleItem->sale_type == 1) {
                                                $sale_value = $inventory->price - ($inventory->price * $inventory->saleItem->amount) / 100;
                                            } else {
                                                $sale_value = $inventory->price - $inventory->saleItem->amount;
                                            }
                                        } else {
                                            $sale_value = $inventory->price;
                                            $sale = false;
                                        }
                                    @endphp
                            <hr class="product-divider">

                            <div class="product-price">
                                <ins class="new-price">
                                    @if ($sale)
                                    <span style="text-decoration: line-through; font-size: 1.8rem">{{ number_format($sale_value, 2, '.', '') }}</span>
                                        {{ number_format($inventory->price, 2, '.', '') }}
                                    @else
                                        {{ number_format($sale_value, 2, '.', '') }}
                                    @endif
                                </ins>
                            </div>

                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width: 80%;"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#product-tab-reviews" class="rating-reviews scroll-to">(3
                                    Reviews)</a>
                            </div>

                            <div class="product-short-desc">
                                <ul class="list-type-check list-style-none">
                                    <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                                    <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                                    <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                                </ul>
                            </div>

                            <div class="fix-bottom  sticky-content">
                                <div class="product-form container">
                                    <div class="product-qty-form">
                                        <div class="input-group">
                                            <input class="quantity form-control" type="number" min="1"
                                                max="10000000">
                                            <button class="quantity-plus w-icon-plus"></button>
                                            <button class="quantity-minus w-icon-minus"></button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-cart">
                                        <i class="w-icon-cart"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>

                            <div class="social-links-wrapper">
                                <div class="social-links">
                                    <div class="social-icons social-no-color border-thin">
                                        <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                        <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                        <a href="#"
                                            class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                        <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                        <a href="#"
                                            class="social-icon social-youtube fab fa-linkedin-in"></a>
                                    </div>
                                </div>
                                <span class="divider d-xs-show"></span>
                                <div class="product-link-wrapper d-flex">
                                    <a href="#"
                                        class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#product-tab-description" class="nav-link active">Description</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="product-tab-description">
                            <div class="row mb-4">
                                <div class="col-md-12 mb-5">
                                    <p class="mb-4">
                                        {!! $inventory->full_description !!}
                                    </p>

                                </div>

                            </div>
                            <div class="row cols-md-3">
                                <div class="mb-3">
                                    <h5 class="sub-title font-weight-bold"><span class="mr-3">1.</span>Free
                                        Shipping &amp; Return</h5>
                                    <p class="detail pl-5">We offer free shipping for products on orders
                                        above 50$ and offer free delivery for all orders in US.</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="sub-title font-weight-bold"><span>2.</span>Free and Easy
                                        Returns</h5>
                                    <p class="detail pl-5">We guarantee our products and you could get back
                                        all of your money anytime you want in 30 days.</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="sub-title font-weight-bold"><span>3.</span>Special Financing
                                    </h5>
                                    <p class="detail pl-5">Get 20%-50% off items over 50$ for a month or
                                        over 250$ for a year with our special credit card.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
