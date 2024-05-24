(function($) {
    "use strict";
    /* -------------------------------------
               Prealoder
         -------------------------------------- */
    $(window).on('load', function(event) {
        $('.js-preloader').delay(500).fadeOut(500);
    });

    /* -------------------------------------
          Open Search box
    -------------------------------------- */
    $('.shopcart').on('click', function() {
        $('.cart-popup').addClass('open');
        $('.body_overlay').addClass('open');
    });
    $('.close-popup, .body_overlay').on('click', function() {
        $('.cart-popup').removeClass('open');
        $('.body_overlay').removeClass('open');
    });

    $('.close-popup, .body_overlay').on('click', function() {
        $('.body_overlay').removeClass('open');

    });

    /* -------------------------------------
          Language Dropdown
    -------------------------------------- */
    $(".language-option").each(function() {
        var each = $(this)
        each.find(".lang-name").html(each.find(".language-dropdown-menu a:nth-child(1)").text());
        var allOptions = $(".language-dropdown-menu").children('a');
        each.find(".language-dropdown-menu").on("click", "a", function() {
            allOptions.removeClass('selected');
            $(this).addClass('selected');
            $(this).closest(".language-option").find(".lang-name").html($(this).text());
        });
    })

    /* ----------------------------------------
          Counter animation
    ------------------------------------------*/
    $('.counter-item').appear(function() {
        var element = $(this);
        var timeSet = setTimeout(function() {
            if (element.hasClass('counter-item')) {
                element.find('.counter-value').countTo();
            }
        });
    });

    /* -------------------------------------
          Product Quantity
    -------------------------------------- */
    var minVal = 1,
        maxVal = 20;
    $(".increaseQty").on('click', function() {
        var $parentElm = $(this).parents(".qtySelector");
        $(this).addClass("clicked");
        setTimeout(function() {
            $(".clicked").removeClass("clicked");
        }, 100);
        var value = $parentElm.find(".qtyValue").val();
        if (value < maxVal) {
            value++;
        }
        $parentElm.find(".qtyValue").val(value);
    });
    // Decrease product quantity on cart page
    $(".decreaseQty").on('click', function() {
        var $parentElm = $(this).parents(".qtySelector");
        $(this).addClass("clicked");
        setTimeout(function() {
            $(".clicked").removeClass("clicked");
        }, 100);
        var value = $parentElm.find(".qtyValue").val();
        if (value > 1) {
            value--;
        }
        $parentElm.find(".qtyValue").val(value);
    });


    /* -------------------------------------
          Mobile Topbar 
    -------------------------------------- */

    $('.mobile-top-bar').on('click', function() {
        $('.header-top-right').addClass('open')
    });
    $('.close-header-top').on('click', function() {
        $('.header-top-right').removeClass('open')
    });

    /* -------------------------------------
          sticky Header
    -------------------------------------- */
    var wind = $(window);
    var sticky = $('.header-wrap');
    wind.on('scroll', function() {
        var scroll = wind.scrollTop();
        if (scroll < 100) {
            sticky.removeClass('sticky');
        } else {
            sticky.addClass('sticky');
        }
    });

    /*---------------------------------
        Responsive mmenu
    ---------------------------------*/
    $('.mobile-menu a').on('click', function() {
        $('.main-menu-wrap').addClass('open');
        $('.mobile-bar-wrap.style2 .mobile-menu').addClass('open');
    });

    $('.mobile_menu a').on('click', function() {
        $(this).parent().toggleClass('open');
        $('.main-menu-wrap').toggleClass('open');
    });

    $('.menu-close').on('click', function() {
        $('.main-menu-wrap').removeClass('open')
    });
    $('.mobile-top-bar').on('click', function() {
        $('.header-top').addClass('open')
    });
    $('.close-header-top button').on('click', function() {
        $('.header-top').removeClass('open')
    });
    var $offcanvasNav = $('.main-menu'),
        $offcanvasNavSubMenu = $offcanvasNav.find('.sub-menu');
    $offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="las la-angle-down"></i></span>');

    $offcanvasNavSubMenu.slideUp();

    $offcanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if (($this.parent().attr('class').match(/\b(has-children|sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length) {
                $this.siblings('ul').slideUp('slow');
            } else {
                $this.closest('li').siblings('li').find('ul:visible').slideUp('slow');
                $this.siblings('ul').slideDown('slow');
            }
        }
        if ($this.is('a') || $this.is('span') || $this.attr('class').match(/\b(menu-expand)\b/)) {
            $this.parent().toggleClass('menu-open');
        } else if ($this.is('li') && $this.attr('class').match(/\b('has-children')\b/)) {
            $this.toggleClass('menu-open');
        }
    });


    /* -------------------------------------
                 range slider
        -------------------------------------- */
    $("#slider-range_one").slider({
        range: true,
        min: 0,
        max: 400,
        values: [10, 300],
        slide: function(event, ui) {
            $("#amount_one").val("$" + ui.values[0] + " - " + "$" + ui.values[1]);
        }
    });
    $(" #amount_one").val("$" + $("#slider-range_one").slider("values", 0) +
        " - " + "$" + $("#slider-range_one").slider("values", 1));
   
    /*---------------------------------
           Deals Slider
    ---------------------------------*/
    var deals_slider_one = new Swiper('.deals-item-slider', {
        spaceBetween: 30,
        autoplay: {
            delay: 6000,
            disableOnInteraction: true,
        },
        observer: true,
        observeParents: true,
        speed: 1500,
        loop: true,
        navigation: {
            nextEl: '.deals-next',
            prevEl: '.deals-prev',
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 30,

            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,

            },
            1200: {
                slidesPerView: 3,
                spaceBetween:30,

            },

            1500: {
                slidesPerView: 4,
                spaceBetween: 30,

            }
        }
    });

    /*---------------------------------
           Partner Slider
    ---------------------------------*/
    var partner_one = new Swiper('.partner-slider', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        speed: 1500,
        autoplay: {
            delay: 6000,
            disableOnInteraction: true,
        },
       
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 20,

            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,

            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 20,

            }
        }

    });

    /*---------------------------------
           Blog Slider
    ---------------------------------*/
    var blog_slider_one = new Swiper('.blog-slider', {
        spaceBetween: 30,
        autoplay: {
            delay: 3000,
            disableOnInteraction: true,
        },

        speed: 1500,
        loop: true,
        navigation: {
            nextEl: '.blog-next',
            prevEl: '.blog-prev',
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 30,

            },
            768: {
                slidesPerView: 2,
                spaceBetween: 25,

            },
           
            1200: {
                slidesPerView: 2,
                spaceBetween: 25,

            },

            1500: {
                slidesPerView: 3,
                spaceBetween: 25,

            }
        }
    });
    /*---------------------------------
           Single  Car Slider
    ---------------------------------*/
    var car_slider_one = new Swiper('.single-car-two ', {
        spaceBetween: 30,
        autoplay: {
            delay: 3000,
            disableOnInteraction: true,
        },

        speed: 1500,
        loop: true,
        navigation: {
            nextEl: '.single-gal-next',
            prevEl: '.single-gal-prev',
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 30,

            },
            768: {
                slidesPerView: 1.7,
                spaceBetween: 25,

            },
           
            1200: {
                slidesPerView: 2.2,
                spaceBetween: 25,

            },

            1500: {
                slidesPerView: 2.8,
                spaceBetween: 25,

            }
        }
    });
    /*---------------------------------
           Car Gallery  
    ---------------------------------*/
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 15,
        slidesPerView: 4,
        freeMode: true,
         navigation: {
            nextEl: ".swiper-thumb-next",
            prevEl: ".swiper-thumb-prev",
        },
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
  
    /*---------------------------------
        Single  Product Slider 
    ---------------------------------*/
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 20,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        breakpoints: {
            0: {
                slidesPerView: 3,
                spaceBetween: 20,

            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,

            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20,

            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 20,

            }
        }
    });
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });

    /*---------------------------------
            Testimonial  Slider
    ---------------------------------*/
    var testimonial_one = new Swiper('.testimonial-slider-one', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        speed: 1500,
        pagination: {
            el: ".testimonial-one-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 25,

            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,

            },
            992: {
                slidesPerView: 2,
                spaceBetween: 20,

            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,

            }
        }

    });

    /*-------------------------------------
         Scroll to top
    ----------------------------------*/

    // Show or hide the  button
    $(window).on('scroll', function(event) {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').fadeIn(200)
        } else {
            $('.back-to-top').fadeOut(200)
        }
    });


    //Animate the scroll to top
    $('.back-to-top').on('click', function(event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });


})(jQuery);


// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('talon_theme', themeName);
    document.documentElement.className = themeName;
}

// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem('talon_theme') === 'theme-dark') {
        setTheme('theme-light');
    } else {
        setTheme('theme-dark');
    }
}

// Immediately invoked function to set the theme on initial load
(function () {
    if (localStorage.getItem('talon_theme') === 'theme-dark') {
        setTheme('theme-dark');
        document.getElementById('slider').checked = false;
    } else {
        setTheme('theme-light');
        document.getElementById('slider').checked = true;
    }
})();