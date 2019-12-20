@php
    use App\User;
@endphp

@extends('layouts.frontend')

@section('content')

    <!--================ Start Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content text-center">
                    <h2>Blog</h2>
                    <div class="page_link">
                        <a href="index.html">Home</a>
                        <a href="blog.html">Our Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Banner Area =================-->
        
    <!--================Blog Categorie Area =================-->
    <section class="blog_categorie_area section_gap_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="categories_post">
                        <img src="/frontend/img/blog/cat-post/cat-post-3.jpg" alt="post">
                        <div class="categories_details">
                            <div class="categories_text">
                                <a href="/c/website"><h5>Web Development</h5></a>
                                <div class="border_line"></div>
                                <p>Enjoy your websites</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories_post">
                        <img src="/frontend/img/blog/cat-post/cat-post-2.jpg" alt="post">
                        <div class="categories_details">
                            <div class="categories_text">
                                <a href="/c/games"><h5>Games Development</h5></a>
                                <div class="border_line"></div>
                                <p>Be a part of games</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories_post">
                        <img src="/frontend/img/blog/cat-post/cat-post-1.jpg" alt="post">
                        <div class="categories_details">
                            <div class="categories_text">
                                <a href="/c/android"><h5>Android Development</h5></a>
                                <div class="border_line"></div>
                                <p>Let your android project be finished</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Categorie Area =================-->
    
    <!--================Blog Area =================-->
    <section class="blog_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">

                       

                        @foreach ($artikels as $item)
                            
                                           
                        <article class="row blog_item">
                            <div class="col-md-3">
                                <div class="blog_info text-right">
                                   
                                    <ul class="blog_meta list">
                                        @php
                                            $user = DB::table("users")->where("id",$item->user_id)->first();
                                        @endphp

                                        <li><a href="/u/{{$user->id}}">{{$user->name}}<i class="lnr lnr-user"></i></a></li>
                                        <li><a href="#">12 Dec, 2017<i class="lnr lnr-calendar-full"></i></a></li>
                                        <li><a href="#">1.2M Views<i class="lnr lnr-eye"></i></a></li>
                                        <li><a href="#">06 Comments<i class="lnr lnr-bubble"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="blog_post">
                                    <img src="/img/{{$item->img}}" alt="">
                                    <div class="blog_details">
                                        <a href="single-blog.html"><h2>{{$item->judul}}</h2></a>
                                    <div class="post_tag">
                                        <a href="#">{{$item->kategori}},</a>
                                        
                                    </div>

                                        <p>{{$item->isi}}</p>
                                        <a href="{{$item->slug}}" class="primary_btn"><span>View More</span></a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach

                        {{$artikels->links()}}

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                            @include('frontend.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
    
 

@endsection