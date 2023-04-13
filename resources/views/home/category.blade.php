@extends('layouts.home')

@section('title')
    Categories
@endsection

@section('content')
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Categories</li>
            </ul>
        </div>
    </nav>

    <div class="page-content mb-10">
        <!-- Start of Shop Banner -->
        <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
            style="background-color: #2e264e;">
            <div class="container banner-content">
                <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-10">{{ $category->name }}</h3>
            </div>
        </div>
        <!-- End of Shop Banner -->
        <div class="container-fluid">
            <!-- Start of Shop Content -->
            <div class="shop-content">
                <!-- Start of Sidebar, Shop Sidebar -->
                <aside class="sidebar shop-sidebar left-sidebar sticky-sidebar-wrapper">
                    <!-- Start of Sidebar Overlay -->
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>


                    <!-- Start of Sidebar Content -->
                    <div class="sidebar-content scrollable">
                        <div class="filter-actions">
                            <label>Filter :</label>
                        </div>
                        <!-- Start of Collapsible widget -->
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title"><span>All Categories</span></h3>
                            <ul class="widget-body filter-items search-ul">
                                @foreach ($sub_category as $item)
                                    <li><a
                                            href="{{ url('/sub_categories/' . Crypt::encrypt($item->id)) }}">{{ ucwords($item->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- End of Sidebar Content -->
                </aside>
                <!-- End of Shop Sidebar -->

                <!-- Start of Shop Main Content -->
                <div class="main-content">
                    <nav class="toolbox sticky-toolbox sticky-content fix-top">
                        <div class="toolbox-left">
                            <a href="#"
                                class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle
                                btn-icon-left"><i
                                    class="w-icon-category"></i><span>Filters</span></a>

                        </div>
                    </nav>
                    <div class="product-wrapper row cols-xl-2 cols-sm-1 cols-xs-2 cols-1">
                        @foreach ($sub_category as $item)
                            @foreach ($item->getInventoryPage as $product)
                                <div class="product product-list">
                                    <figure class="product-media">
                                        <a href="{{ url('/products/' . Crypt::encrypt($product->id)) }}">
                                            <img src="{{ asset($product->image) }}" alt="Product" width="330"
                                                height="338" />
                                            <img src="{{ asset($product->image) }}" alt="Product" width="330"
                                                height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                                title="Quick View"></a>
                                        </div>
                                        @php
                                            if ($product->saleItem) {
                                                $sale = true;
                                                $date_time = date('Y, m, d', strtotime($product->saleItem->end_date));
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
                                        @if ($sale)
                                            <div class="product-countdown-container">
                                                <div class="product-countdown countdown-compact"
                                                    data-until="{{ $date_time }}" data-format="DHMS" data-compact="false"
                                                    data-labels-short="Days, Hours, Mins, Secs">
                                                    00:00:00:00</div>
                                            </div>
                                        @endif

                                    </figure>
                                    <div class="product-details">
                                        <div class="product-cat">
                                            <a
                                                href="{{ url('/sub_categories/' . Crypt::encrypt($item->id)) }}">{{ $item->name }}</a>
                                        </div>
                                        <h4 class="product-name">
                                            <a
                                                href="{{ url('/products/' . Crypt::encrypt($product->id)) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 100%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="{{ url('/products/' . Crypt::encrypt($product->id)) }}"
                                                class="rating-reviews">(3 Reviews)</a>
                                        </div>
                                        <div class="product-price">
                                            @if ($sale)
                                                <ins class="new-price">{{ number_format($sale_value, 2, '.', '') }}</ins>
                                                <del
                                                    class="old-price">{{ number_format($product->price, 2, '.', '') }}</del>
                                            @else
                                                <ins class="new-price">{{ number_format($sale_value, 2, '.', '') }}</ins>
                                            @endif

                                        </div>
                                        <div class="product-desc">
                                            {{ $product->description }}
                                        </div>
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart" title="Add to Cart"><i
                                                    class="w-icon-cart"></i> Add To Cart</a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                title="Add to wishlist"></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                    </div>

                </div>
                <!-- End of Shop Main Content -->
            </div>
            <!-- End of Shop Content -->
        </div>
    </div>
@endsection
