<!-- Custom Theme files -->
<script>
    var host = '{{ config('app.url') }}';
    var simbolCurrency = "{!! Currency::getSymbol() !!}";
    var userAuth = '{!! Auth::check() !!}';
    var userName = '';
    var userEmail = '';
    var adminName = '';

    @auth
        userName = '{{ Auth::user()->name }}';
        userEmail = '{{ Auth::user()->email->email }}';
        adminName = '{{ Auth::user()->name }}';
    @endif

    var adminpath = '{{ route('admin.index') }}';

    var csrftoken = $('meta[name=_token]').attr('content');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script src="{{ asset('js/bootstrap.js') }}"></script>

<script src="{{ asset('js/validator.js') }}"></script>
<script defer src="{{ asset('js/jquery.flexslider.js') }}"></script>
<script>
    // Can also be used with $(document).ready()
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>
<script src="{{ asset('js/imagezoom.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items :4,
            itemsDesktop : [640,5],
            itemsDesktopSmall : [480,2],
            navigation : true
        });
    });
</script>
<script src="{{ asset('js/jquery-scrolltofixed-min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Dock the header to the top of the window when scrolled past the banner. This is the default behaviour.
        var r = /comparison\/\S+/;
        if(!r.test(document.location.pathname))
            $('.header-two').scrollToFixed();
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('.header-two').outerHeight(true) + 10,
                zIndex: 999
            });
        });
    });
</script>
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="{{ asset('js/move-top.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/easing.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>
<!-- //end-smooth-scrolling -->
<!-- smooth-scrolling-of-move-up -->
<script type="text/javascript">
    $(document).ready(function() {
        var defaults = {
            containerID: 'toTop', // fading element id
            containerHoverID: 'toTopHover', // fading element hover id
            scrollSpeed: 1200,
            easingType: 'linear'
        };
        $().UItoTop({ easingType: 'easeOutQuart' });
    });
</script>
<!-- //smooth-scrolling-of-move-up -->
<script type="text/javascript" src="{{ asset('js/jquery.mousewheel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.autocomplete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.marquee.min.js') }}"></script>
<script>
    $('.marquee').marquee({ pauseOnHover: true });
    //@ sourceURL=pen.js
</script>
<!-- countdown.js -->
<script src="{{ asset('js/jquery.knob.js') }}"></script>
<script src="{{ asset('js/jquery.throttle.js') }}"></script>
<script src="{{ asset('js/jquery.classycountdown.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#countdown1').ClassyCountdown({
            end: '1388268325',
            now: '1387999995',
            labels: true,
            style: {
                element: "",
                textResponsive: .5,
                days: {
                    gauge: {
                        thickness: .10,
                        bgColor: "rgba(0,0,0,0)",
                        fgColor: "#1abc9c",
                        lineCap: 'round'
                    },
                    textCSS: 'font-weight:300; color:#fff;'
                },
                hours: {
                    gauge: {
                        thickness: .10,
                        bgColor: "rgba(0,0,0,0)",
                        fgColor: "#05BEF6",
                        lineCap: 'round'
                    },
                    textCSS: 'font-weight:300; color:#fff;'
                },
                minutes: {
                    gauge: {
                        thickness: .10,
                        bgColor: "rgba(0,0,0,0)",
                        fgColor: "#8e44ad",
                        lineCap: 'round'
                    },
                    textCSS: 'font-weight:300; color:#fff;'
                },
                seconds: {
                    gauge: {
                        thickness: .10,
                        bgColor: "rgba(0,0,0,0)",
                        fgColor: "#f39c12",
                        lineCap: 'round'
                    },
                    textCSS: 'font-weight:300; color:#fff;'
                }

            },
            onEndCallback: function() {
                console.log("Time out!");
            }
        });
    });
</script>
<!-- //countdown.js -->
<!-- menu js aim -->
<script type="text/javascript" src="{{ asset('js/jquery.jscrollpane.min.js') }}"></script>
<script type="text/javascript" id="sourcecode">
    $(function()
    {
        $('body .scroll-pane').jScrollPane();
    });
</script>
<script src="{{ asset('js/jquery.menu-aim.js') }}"> </script>
<!--<script type="text/javascript" src='{{-- asset('js/html.js') --}}'></script>-->
<script src="{{ asset('js/html.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/myjs.js') }}"></script>
<script src="{{ asset('js/socket.js') }}"></script>
<!-- //menu js aim -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
@stack('scripts')
