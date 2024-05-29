
$(function() {
	"use strict";



// Theme switcher
    // Check the localStorage for theme preference on page load and apply it
    if (localStorage.getItem('theme') === 'dark') {
        $("html").attr("class", "dark-theme");
        $(".mode-icon i").removeClass("bi-brightness-high").addClass("bi-moon");
    } else {
        $("html").attr("class", "light-theme");
        $(".mode-icon i").removeClass("bi-moon").addClass("bi-brightness-high");
    }

    // Light theme switcher
    $("#LightTheme").on("click", function() {
        $("html").attr("class", "light-theme");
        localStorage.setItem('theme', 'light'); // Save preference to localStorage
        $(".mode-icon i").removeClass("bi-moon").addClass("bi-brightness-high");
    });

    // Dark theme switcher
    $("#DarkTheme").on("click", function() {
        $("html").attr("class", "dark-theme");
        localStorage.setItem('theme', 'dark'); // Save preference to localStorage
        $(".mode-icon i").removeClass("bi-brightness-high").addClass("bi-moon");
    });

    // Toggle theme switcher
    $(".dark-mode-icon").on("click", function() {
        $("html").toggleClass("dark-theme");
        var currentTheme = $("html").hasClass("dark-theme") ? 'dark' : 'light';
        localStorage.setItem('theme', currentTheme); // Save preference to localStorage
        $(".mode-icon i").toggleClass("bi-brightness-high bi-moon");
    });



/* Back to top */
$(document).ready(function() {
  $(window).on("scroll", function() {
    $(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
  }), $(".back-to-top").on("click", function() {
    return $("html, body").animate({
      scrollTop: 0
    }, 600), !1
  })
})


/* list active */
$(function() {
  for (var e = window.location, o = $(".primary-menu li a").filter(function() {
      return this.href == e
    }).addClass("active").parent().addClass("active"); o.is("li");) o = o.parent("").addClass("show").parent("").addClass("active")
})



});


