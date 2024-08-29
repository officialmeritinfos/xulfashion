(function ($) {
  "use strict";

  //* Navbar Fixed
  function navbarFixed() {
    if ($(".sticky_nav").length) {
      $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll) {
          $(".sticky_nav").addClass("navbar_fixed");
        } else {
          $(".sticky_nav").removeClass("navbar_fixed");
        }
      });
    }
  }
  navbarFixed();

  function Menu_js() {
    if ($(".submenu").length) {
      $(".submenu > .dropdown-toggle").click(function () {
        var location = $(this).attr("href");
        window.location.href = location;
        return false;
      });
    }
  }
  Menu_js();

  function menu_dropdown() {
    if ($(window).width() < 992) {
      $(".menu > li .mobile_dropdown_icon").on("click", function (event) {
        event.preventDefault();
        $(this).parent().find(".dropdown-menu").first().slideToggle(700);
        $(this).parent().siblings().find(".dropdown-menu").slideUp(700);
      });
    }
  }
  menu_dropdown();

  //*============ background color js ==============*/
  $("[data-bg-color]").each(function () {
    var bg_color = $(this).data("bg-color");
    $(this).css({
      "background-color": bg_color,
    });
  });

  //*============ background image js ==============*/
  $("[data-bg-image]").each(function () {
    var bg = $(this).data("bg-image");
    $(this).css({
      background: "no-repeat center 0/cover url(" + bg + ")",
    });
  });

  $(".slick_slider").slick({});

  /*--------------- Start popup-js--------*/
  function popupGallery() {
    if ($(".popup-youtube").length) {
      $(".popup-youtube").magnificPopup({
        disableOn: 700,
        type: "iframe",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        mainClass: "mfp-with-zoom mfp-img-mobile",
      });
    }
  }
  popupGallery();

  $(".qu_accordion").each(function () {
    var $accordion = $(".qu_accordion");
    if ($accordion.length > 0) {
      $(this)
        .find(".qu_accordion_item.is-active")
        .children(".qu_accordion_panel")
        .slideDown();
      $accordion.find(".qu_accordion_item").on("click", function () {
        $(this)
          .siblings(".qu_accordion_item")
          .removeClass("is-active")
          .children(".qu_accordion_panel")
          .slideUp();
        $(this)
          .toggleClass("is-active")
          .children(".qu_accordion_panel")
          .slideToggle("ease-out");
      });
    }
  });

  if ($(".select").length > 0) {
    $(".select").niceSelect();
  }

  if ($(".job_post").length > 0) {
    var jpost = $(".job_post");
    jpost.imagesLoaded(function () {
      // images have loaded
      // Activate isotope in container
      jpost.isotope({
        itemSelector: ".job_post_item",
        layoutMode: "masonry",
        filter: "*",
        animationOptions: {
          duration: 1000,
        },
        hiddenStyle: {
          opacity: 0,
          transform: "scale(.4)rotate(60deg)",
        },
        visibleStyle: {
          opacity: 1,
          transform: "scale(1)rotate(0deg)",
        },
        stagger: 0,
        transitionDuration: "0.9s",
        masonry: {},
      });

      // Add isotope click function
      $(".job_filter div").on("click", function () {
        $(".job_filter div").removeClass("active");
        $(this).addClass("active");

        var selector = $(this).attr("data-filter");
        jpost.isotope({
          filter: selector,
          animationOptions: {
            animationDuration: 750,
            easing: "linear",
            queue: false,
          },
        });
        return false;
      });
    });
  }
  /*===========Portfolio isotope js===========*/

  /*--------- WOW js-----------*/

  function bodyScrollAnimation() {
    var scrollAnimate = $("body").data("scroll-animation");
    if (scrollAnimate === true) {
      new WOW({}).init();
    }
  }
  bodyScrollAnimation();
})(jQuery);
