@extends('layouts.app')
@section('title','Online Food Ordering System')
@section('content')
<div>   
    <main>
        <div class="hero_single version_1">
            <div class="opacity-mask">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8">
                            <h1>Delivery or Takeaway Food</h1>
                            <p>The best restaurants at the best price</p>
                            <form method="post" action="#" onsubmit="return false">
                                <div class="row g-0 custom-search-input">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <input class="form-control no_border_r" type="text" id="search_query" autofocus placeholder="Category, product...">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn_1 gradient" type="submit">Search</button>
                                    </div>
                                </div>
                                <!-- /row -->
                                <div class="search_trends">
                                    <h5>Trending:</h5>
                                    <ul>
                                        <li><a href="#0">Sushi</a></li>
                                        <li><a href="#0">Burgher</a></li>
                                        <li><a href="#0">Chinese</a></li>
                                        <li><a href="#0">Pizza</a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <div class="wave hero"></div>
        </div>
        <!-- /hero_single -->

        <div class="container margin_30_60">
            <div class="main_title center">
                <span><em></em></span>
                <h2>Popular Categories</h2>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
            </div>
            <!-- /main_title -->
            <div class="owl-carousel owl-theme categories_carousel">
                @foreach($categories as $category)
                    <div class='item_version_2'><a href='#'>
                            <figure>
                                <span>
                                    @php
                                        $total_product =  App\Models\Product::where('category_id', $category->id)->count();
                                        echo $total_product;
                                    @endphp
                                </span>
                                <img src='frontend/img/home_cat_placeholder.jpg' data-src='frontend/img/home_cat_pizza.jpg' alt='' class='owl-lazy' width='350' height='450'>
                                <div class='info'>
                                    <h3>{{$category->category_name}}</h3>
                                </div>
                            </figure>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- /carousel -->
        </div>
        <!-- /container -->

        <div class="bg_gray">
            <div class="container margin_60_40">
                <div class="main_title">
                    <span><em></em></span>
                    <h2>Top Rated Products</h2>
                    <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
                    <a href="#0">View All &rarr;</a>
                </div>
                <div class="row add_bottom_25">
                <div class="col-lg-12">
                    <div class="list_home">
                        <ul>
                            @foreach($products as $product)
                                        <li>
                                            <a href="#">
                                                <figure>
                                                    <img src="{{$product->product_image}}" data-src="{{$product->product_image}}" alt="" class="lazy" width="350" height="233">
                                                </figure>
                                                <div class="score"><strong>{{(($product->id)*10/100) > 5 ? 5 :  (($product->id)*10/100)}}</strong></div>
                                                <em>{{$product->categories->category_name}}</em>
                                                <h3>{{$product->product_name}}</h3>
                                                <small>{{$product->product_name}}</small>
                                                <ul>
                                                    <li><span class="ribbon off">- ${{($product->product_price)*10/100}}</span></li>
                                                    <li>Unit price ${{$product->product_price}}</li>
                                                </ul>
                                            </a>
                                        </li>
                            @endforeach
                        </ul>
                    </div>
                    </div>
                </div>
                <!-- /row -->
                <div class="banner lazy" data-bg="url(img/banner_bg_desktop.jpg)">
                    <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.3)">
                        <div>
                            <small>FooYes Delivery</small>
                            <h3>We Deliver to your Office</h3>
                            <p>Enjoy a tasty food in minutes!</p>
                            <a href="/" class="btn_1 gradient">Start Now!</a>
                        </div>
                    </div>
                    <!-- /wrapper -->
                </div>
                <!-- /banner -->
            </div>
        </div>
        <!-- /bg_gray -->

        <div class="shape_element_2">
            <div class="container margin_60_0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="frontend/img/how_1.svg" alt="" width="150" height="167" class="lazy"></figure>
                                    <h3>Easly Order</h3>
                                    <p>Faucibus ante, in porttitor tellus blandit et. Phasellus tincidunt metus lectus sollicitudin.</p>
                                </div>
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="frontend/img/how_2.svg" alt="" width="130" height="145" class="lazy"></figure>
                                    <h3>Quick Delivery</h3>
                                    <p>Maecenas pulvinar, risus in facilisis dignissim, quam nisi hendrerit nulla, id vestibulum.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center">
                                <div class="box_how">
                                    <figure><img src="img/lazy-placeholder-100-100-white.png" data-src="frontend/img/how_3.svg" alt="" width="150" height="132" class="lazy"></figure>
                                    <h3>Enjoy Food</h3>
                                    <p>Morbi convallis bibendum urna ut viverra. Maecenas quis consequat libero, a feugiat eros.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-center mt-3 d-block d-lg-none"><a href="#0" class="btn_1 medium gradient pulse_bt mt-2">Register Now!</a></p>
                    </div>
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="intro_txt">
                            <div class="main_title">
                                <span><em></em></span>
                                <h2>Start Ordering Now</h2>
                            </div>
                            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed imperdiet libero id nisi euismod, sed porta est consectetur deserunt.</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <p><a href="/" class="btn_1 medium gradient pulse_bt mt-2">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>     
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){

        });
    </script>
@endpush