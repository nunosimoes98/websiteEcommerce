

@extends('layouts.frontLayout.front_design')




@section('content')

<head>
  ...
  <script src="https://unpkg.com/vue"></script>
  <script src="https://unpkg.com/vueperslides"></script>
  <link href="https://unpkg.com/vueperslides/dist/vueperslides.css" rel="stylesheet">
</head>

    <script src="{{ asset('js/frontend_js/jssor.slider-28.0.0.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        window.jssor_1_slider_init = function() {

            var jssor_1_SlideoTransitions = [
              [{b:-1,d:1,ls:0.5},{b:0,d:1000,y:5,e:{y:6}}],
              [{b:-1,d:1,ls:0.5},{b:200,d:1000,y:25,e:{y:6}}],
              [{b:-1,d:1,ls:0.5},{b:400,d:1000,y:45,e:{y:6}}],
              [{b:-1,d:1,ls:0.5},{b:600,d:1000,y:65,e:{y:6}}],
              [{b:-1,d:1,ls:0.5},{b:800,d:1000,y:85,e:{y:6}}],
              [{b:-1,d:1,ls:0.5},{b:500,d:1000,y:195,e:{y:6}}],
              [{b:0,d:2000,y:30,e:{y:3}}],
              [{b:-1,d:1,rY:-15,tZ:100},{b:0,d:1500,y:30,o:1,e:{y:3}}],
              [{b:-1,d:1,rY:-15,tZ:-100},{b:0,d:1500,y:100,o:0.8,e:{y:3}}],
              [{b:500,d:1500,o:1}],
              [{b:0,d:1000,y:380,e:{y:6}}],
              [{b:300,d:1000,x:80,e:{x:6}}],
              [{b:300,d:1000,x:330,e:{x:6}}],
              [{b:-1,d:1,r:-110,sX:5,sY:5},{b:0,d:2000,o:1,r:-20,sX:1,sY:1,e:{o:6,r:6,sX:6,sY:6}}],
              [{b:0,d:600,x:150,o:0.5,e:{x:6}}],
              [{b:0,d:600,x:1140,o:0.6,e:{x:6}}],
              [{b:-1,d:1,sX:5,sY:5},{b:600,d:600,o:1,sX:1,sY:1,e:{sX:3,sY:3}}]
            ];

            var jssor_1_options = {
              $AutoPlay: 1,
              $LazyLoading: 1,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $SpacingX: 20,
                $SpacingY: 20
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 1600;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,regular,italic,700,700italic&subset=latin-ext,greek-ext,cyrillic-ext,greek,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />
    <style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        /*jssor slider bullet skin 132 css*/
        .jssorb132 {position:absolute;}
        .jssorb132 .i {position:absolute;cursor:pointer;}
        .jssorb132 .i .b {fill:#fff;fill-opacity:0.8;stroke:#000;stroke-width:1600;stroke-miterlimit:10;stroke-opacity:0.7;}
        .jssorb132 .i:hover .b {fill:#000;fill-opacity:.7;stroke:#fff;stroke-width:2000;stroke-opacity:0.8;}
        .jssorb132 .iav .b {fill:#000;stroke:#fff;stroke-width:2400;fill-opacity:0.8;stroke-opacity:1;}
        .jssorb132 .i.idn {opacity:0.3;}

        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>
    <svg viewbox="0 0 0 0" width="0" height="0" style="display:block;position:relative;left:0px;top:0px;">
        <defs>
            <filter id="jssor_1_flt_1" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stddeviation="4"></feGaussianBlur>
            </filter>
            <radialGradient id="jssor_1_grd_2">
                <stop offset="0" stop-color="#fff"></stop>
                <stop offset="1" stop-color="#000"></stop>
            </radialGradient>
            <mask id="jssor_1_msk_3">
                <path fill="url(#jssor_1_grd_2)" d="M600,0L600,400L0,400L0,0Z" x="0" y="0" style="position:absolute;overflow:visible;"></path>
            </mask>
        </defs>
    </svg>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1600px;height:700px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="{{ asset('images/frontend_images/spin.svg')}}" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1600px;height:700px;overflow:hidden;">
            
            <div>
                <img data-u="image" data-src="{{ asset('images/frontend_images/back.jpg')}}" />
                <div data-ts="flat" data-p="540" data-po="40% 50%" style="left:0px;top:0px;width:700px;height:560px;position:absolute;">
                    <div data-to="50% 50%" data-ts="preserve-3d" data-t="6" style="left:350px;top:360px;width:900px;height:500px;position:absolute;">
                        <svg viewbox="0 0 800 60" data-to="50% 50%" width="800" height="60" data-t="7" style="left:0px;top:-70px;display:block;position:absolute;opacity:0;font-family:'Roboto Condensed',sans-serif;font-size:60px;font-weight:700;letter-spacing:0.05em;overflow:visible;">
                            <text fill="#ffffff" stroke="#000000" stroke-width="2" text-anchor="middle" x="400" y="60">SHOP WITH US
                            </text>
                        </svg>
  
                        <svg viewbox="0 0 800 100" width="800" height="100" data-t="9" style="left:40px;top:320px;display:block;position:absolute;opacity:0;font-family:'Roboto Condensed',sans-serif;font-size:100px;font-weight:900;letter-spacing:0.5em;overflow:visible;">
                            <text fill="rgba(255,255,255,0.7)" stroke="#000000" text-anchor="middle" x="400" y="100">WolfWork Brand.
                            </text>
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <img data-u="image" src="{{ asset('images/frontend_images/joao.png')}}" />
                <div data-ts="flat" data-p="275" data-po="40% 50%" style="left:145px;top:299px;width:800px;height:300px;position:absolute;">
                    <div data-to="50% 50%" data-t="0" style="left:30px;top:400px;width:400px;height:100px;position:absolute;color:#fff;font-family:'Roboto Condensed',sans-serif;font-size:60px;font-weight:900;">WOLF</div>

                </div>
            </div>
            <div style="background-color:#000000;">
                <img data-u="image" style="opacity:0.8;" data-src="{{ asset('images/frontend_images/wolf.jpg')}}" />
                <div data-ts="flat" data-p="1080" style="left:0px;top:0px;width:1600px;height:560px;position:absolute;">
                    <svg viewbox="0 0 600 400" data-ts="preserve-3d" width="600" height="400" data-tchd="jssor_1_msk_3" style="left:1000px;top:0px;display:block;position:absolute;overflow:visible;">
                        <g mask="url(#jssor_1_msk_3)">
                            <path data-to="300px -180px" fill="none" stroke="rgba(250,251,252,0.5)" stroke-width="20" d="M410-350L410-10L190-10L190-350Z" x="500" y="-350" data-t="10" style="position:absolute;overflow:visible;"></path>
                        </g>
                    </svg>
                    <svg viewbox="0 0 800 72" data-to="50% 50%" width="800" height="72" data-t="11" style="left:-2000px;top:200px;display:block;position:absolute;font-family:'Roboto Condensed',sans-serif;font-size:60px;font-weight:900;overflow:visible;">
                        <text fill="#fafbfc" text-anchor="middle" x="1125" y="72">WOLFWORK BRAND.
                        </text>
                    </svg>
                    <svg viewbox="0 0 800 72" data-to="50% 50%" width="800" height="72" data-t="12" style="left:1600px;top:250px;display:block;position:absolute;font-family:'Roboto Condensed',sans-serif;font-size:40px;font-weight:900;overflow:visible;">
                        <text fill="#fafbfc" text-anchor="middle" x="1050" y="72">Established 2018
                        </text>
                    </svg>
                </div>
            </div>
            
        </div><a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">slider html</a>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb132" style="position:absolute;bottom:24px;right:16px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:12px;height:12px;">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
       
    </div>
    <script type="text/javascript">jssor_1_slider_init();
    </script>

	<section class="feature_product_area section_gap">
        <div class="main_box">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title">
                        <h2>Featured Products</h2>
                        <p>Who are in extremely love with eco friendly system.</p>
                    </div>
                </div>
                <div class="row">
                     @foreach($productsAll as $pro)
                    <div class="col col3" style="position: center">
                       
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="{{ asset('images/backend_images/products/small/'.$pro->image) }}" alt="" >
                                
                            </div>
                            <a href="#">
                                <h4>{{ $pro->product_name }}</h4>
                            </a>
                            <h5>EUR {{ $pro->price }}</h5>
                        </div>
                         
                    </div>
                    @endforeach
               
                </div>

            </div>
        </div>
    </section>


    <section class="subscription-area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <h2>Subscribe for Our Newsletter</h2>
                        <span>We won’t send any kind of spam</span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div id="mc_embed_signup">
                        <form action="javascript:void(0);"
                         type="post" class="subscription relative">{{ csrf_field() }}
                            <input type="email" name="subscriber_email" id="subscriber_email" placeholder="Email address" onfocus="enableSubscriber();" onfocusout="checkSubscriber();" onblur="this.placeholder = 'Email address'"
                             required="">
                            <!-- <div style="position: absolute; left: -5000px;">
                                <input type="text" name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="">
                            </div> -->
                            <button onclick="checkSubscriber(); addSubscriber();" id="btnSubmit" type="submit" class="newsl-btn">Get Started</button>
                            <div  id="statusSubscribe" style="display: none; text-align: center;">
                                <div ></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    function checkSubscriber(){
        var subscriber_email = $("#subscriber_email").val();
        $.ajax({
            type:'post',
            url:'/check-subscriber-email',
            data:{subscriber_email:subscriber_email},
            success:function(resp){
                if (resp=="exists") {
                    //alert("Subscriber email already exists");
                    $("#statusSubscribe").show();
                    $("#btnSubmit").hide();
                    $("#statusSubscribe").html("<div style='margin-top:-5px;'>&nbsp;</div><br><font color='red>Error: Subscriber email already exists</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    }

    function addSubscriber(){
        var subscriber_email = $("#subscriber_email").val();
        $.ajax({
            type:'post',
            url:'/add-subscriber-email',
            data:{subscriber_email:subscriber_email},
            success:function(resp){
                if (resp=="exists") {
                    //alert("Subscriber email already exists");
                    $("#statusSubscribe").show();
                    $("#btnSubmit").hide();
                    $("#statusSubscribe").html("<div></div><br><font color='red'>Error: Subscriber email already exists</font>");
                } else if(resp=="saved"){
                    $("#statusSubscribe").show();
                    $("#statusSubscribe").html("<div >&nbsp;</div><br><font color='green'>Success: Thanks for subscribing!</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    }

    function enableSubscriber(){
        $("#btnSubmit").show();
        $("#statusSubscribe").hide();
    }
</script>

@endsection