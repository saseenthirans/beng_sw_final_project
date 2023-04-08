@extends('layouts.home')

@section('title')
    Subcategories
@endsection

@section('content')
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/categories/' . Crypt::encrypt($subcategory->category_id)) }}">Categories</a></li>
                <li>Subcategories</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mb-10">
        <!-- Start of Shop Banner -->
        <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
            style="background-color: #2e264e;">
            <div class="container banner-content">
                <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-10">{{ $subcategory->name }}</h3>
            </div>
        </div>
        <!-- End of Shop Banner -->
        <div class="container-fluid">
            <!-- Start of Shop Content -->
            <div class="shop-content">


                <!-- Start of Shop Main Content -->
                <div class="main-content">

                    <div class="product-wrapper row cols-xl-2 cols-sm-1 cols-xs-2 cols-1">
                        @foreach ($subcategory->getInventoryPage as $product)
                            <div class="product product-list product-select">
                                <figure class="product-media">
                                    <a href="product-default.html">
                                        <img src="{{ asset($product->image) }}" alt="Product" width="330"
                                            height="338" />
                                    </a>
                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                            title="Quick View"></a>
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="product-cat">
                                        <a href="shop-banner-sidebar.html">{{ $subcategory->name }}</a>
                                    </div>
                                    <h4 class="product-name">
                                        <a href="product-default.html">{{ $product->name }}</a>
                                    </h4>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 100%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="product-default.html" class="rating-reviews">(3 Reviews)</a>
                                    </div>
                                    @php
                                        if ($product->saleItem) {
                                            $sale = true;
                                            if ($product->saleItem->sale_type == 1) {
                                                $sale_value = $product->price - ($product->price * $product->saleItem->amount) / 100;
                                            } else {
                                                $sale_value = $product->price - $product->saleItem->amount;
                                            }
                                        } else {
                                            $sale_value = $product->price;
                                            $sale = false;
                                        }
                                    @endphp
                                    <div class="product-price">
                                        @if ($sale)
                                            <span
                                                style="text-decoration: line-through; font-size: 1.5rem">{{ number_format($sale_value, 2, '.', '') }}</span>
                                            {{ number_format($product->price, 2, '.', '') }}
                                        @else
                                            {{ number_format($sale_value, 2, '.', '') }}
                                        @endif
                                    </div>
                                    <div class="product-desc">
                                        {{ $product->description }}
                                    </div>
                                    <div class="product-action">
                                        <a href="product-default.html" class="btn-product btn-cart" title="Add to Cart"><i
                                                class="w-icon-cart"></i>Add To Cart</a>
                                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                            title="Add to wishlist"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="toolbox toolbox-pagination justify-content-between">
                        <p class="showing-info mb-2 mb-sm-0">
                            {{-- Showing<span>1-12 of 60</span>Products --}}
                        </p>
                        {{-- <ul class="pagination">
                        <li class="prev disabled">
                            <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                <i class="w-icon-long-arrow-left"></i>Prev
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="next">
                            <a href="#" aria-label="Next">
                                Next<i class="w-icon-long-arrow-right"></i>
                            </a>
                        </li>
                    </ul> --}}
                    </div>
                </div>
                <!-- End of Shop Main Content -->
            </div>
            <!-- End of Shop Content -->
        </div>
    </div>
@endsection
