
    @extends('layouts.frontend')
    @section('tittle')
        {{$artikel->judul}}
    @endsection

    @section('content')
        
    
    <!--================ Start Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content text-center">
                    <h2>{{$artikel->judul}}</h2>
                    <div class="page_link">
                        <a href="index.html">Home</a>
                        <a href="blog.html">Blog</a>
                        <a href="single-blog.html">Blog Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Banner Area =================-->
    
    <!--================Blog Area =================-->
    <section class="blog_area single-post-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post row">
                        <div class="col-lg-12">
                            <div class="feature-img">
                                <img class="img-fluid" src="/img/{{$artikel->img}}" alt="{{$artikel->img}}">
                            </div>									
                        </div>
                        <div class="col-lg-3  col-md-3">
                            <div class="blog_info text-right">
                                <div class="post_tag">
                                    <a href="{{$artikel->judul}}">Kategori</a>
                                    <a class="active" href="#">Technology,</a>
                                    <a href="#">Politics,</a>
                                    <a href="#">Lifestyle</a>
                                </div>
                                <ul class="blog_meta list">
                                    @php
                                        $user = App\User::find($artikel->user_id);
                                    @endphp
                                    <li><a href="">{{$user->name}}<i class="lnr lnr-user"></i></a></li>

                                    <li><a href="#">{{date_format($artikel->created_at,"d M Y") }}
                                    <i class="lnr lnr-calendar-full"></i></a></li>
                                    <li><a href="#">1.2M Views<i class="lnr lnr-eye"></i></a></li>
                                    <li><a href="#">06 Comments<i class="lnr lnr-bubble"></i></a></li>
                                </ul>
                                <ul class="social-links">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-github"></i></a></li>
                                    <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 blog_details">
                            <h2>{{$artikel->judul}}</h2>
                            <p>
                                    {{$artikel->isi}}
                            </p>
                        </div>
                    </div>
                    <div class="comments-area" id="komentar-list">
                        	
                    </div>

                <div class="comment-form"id="form-komentar">
                            <h4>Leave a Reply</h4>
                                <div class="form-group">
                                    <input id="artikel-id" value="{{ $artikel->id}}" type="hidden" name="artikel_id">
                                    <input id="induk-id" type="hidden" name="induk">
                                    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                                </div>
                                <div class="form-group">
                                    <textarea id="komentar" class="form-control mb-10" rows="5" name="komentar" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                                </div>
    
                                @if(Auth::user())
                                    <button id="btn-simpan" class="primary-btn primary_btn">
                                        <span>Post Comment</span>
                                    </button>	
                                @else 
                                    <a href="/login" class="primary-btn primary_btn"><span>Login For Comment</span></a>	
                                @endif
    
                            @section('js-after')
                                <script>
                                   function dataKomen(data,reply){
                                    //    alert("test")
                                       return  `<div class="comment-list ${reply}" id="komen-${data.id}">
                                                            <div class="single-comment justify-content-between d-flex">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb">
                                                                        <img width="50px" src="${data.avatar}" alt="">
                                                                    </div>
                                                                    <div class="desc">
                                                                        <h5><a href="#">${data.name}</a></h5>
                                                                        <p class="date">${data.created_at}</p>
                                                                        <p class="comment">
                                                                            ${data.komentar}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="reply-btn">
                                                                        <a onclick="reply(${data.id})" href="#form-komentar" class="btn-reply text-uppercase">reply</a> 
                                                                </div>
                                                            </div>
                                                        </div>`;
                                   }
                                    function getKomentar(id){
                                        $.get("/komentars/"+id)
                                        .done(function(res){
                                            console.log(res)
                                           
                                                for (let index = 0; index < res.length; index++) {
                                                    
                                                    if(res[index].induk == 0 || res[index].induk == null){

                                                    // alert("test"+res[index].id)
                                                        let komen = dataKomen(res[index],"");
                                                        $("#komentar-list").append(komen);
                                                        
                                                    }else{
                                                        let reply = dataKomen(res[index],"left-padding");
                                                        $("#komen-"+res[index].induk).after(reply);
                                                    }
                                                }
                        
                                        })
                                    }
                                    
                                    getKomentar($("#artikel-id").val())


                                    $("#btn-simpan").click(function(){
                                        let artikelId = $("#artikel-id").val();
                                        let indukId = $("#induk-id").val() || 0;
                                        let komentar = $("#komentar").val();
                                        let token = $("#csrf").val();
                                        
                                        let data = {
                                            artikel_id: artikelId,
                                            induk: indukId,
                                            _token: token,
                                            komentar: komentar
                                        }
                                        console.log(data);

                                        $.post("/tambah-komentar", data)
                                        .done ( (res) => {
                                           let isReply = "";
                                            if (res[0].induk > 0){
                                                isReply ="left-padding";
                                            }
                                        //  console.log(res)

                                            // alert("data berhasil disimpan");
                                            $("#komentar").val("");
                                            $("#induk-id").val("");
                                            let komen = `<div class="comment-list  ${isReply}" id="komen-${res[0].id}">
                                                <div class="single-comment justify-content-between d-flex">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb">
                                                            <img width="50px" src="${res[1].avatar}" alt="">
                                                        </div>
                                                        <div class="desc">
                                                            <h5><a href="#">${res[1].name}</a></h5>
                                                            <p class="date">${res[0].created_at}</p>
                                                            <p class="comment">
                                                                <span style="color:blue">
                                                                    ${res[2]}
                                                                </span>
                                                                ${res[0].komentar}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="reply-btn">
                                                            <a onclick="reply(${res[0].id})" href="#form-komentar" class="btn-reply text-uppercase">reply</a> 
                                                    </div>
                                                </div>
                                            </div>`;
                                                      
                                            //push komen

                                            if (res[0].induk > 0){
                                                $("#komen-"+res[0].induk).after(komen);
                                            }else{
                                                $("#komentar-list").append(komen);
                                            }
                                            

                                        }).fail( (e) => {
                                            alert("data gagal disimpan");
                                        })
                                        })
                                                function reply(id){
                                                    $("#induk-id").val(id);
                                                    // alert(id);
                                                }
                                       
                                </script>
                            @endsection
                        </div>
                    </div>
                {{-- </div> --}}
        
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        @include('frontend.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection