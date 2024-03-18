/* Loading 
================================*/
$(window).on("load", function () {
  "use strict";
  AOS.init({
    offset: 100,
    duration: 500,
    easing: "ease-in-out",
  });
  $(".load_cont").fadeOut(function () {
    $(this).parent().fadeOut();
    $("body").css({
      "overflow-y": "visible",
    });
  });
});

$(document).ready(function () {
  "use strict";
  //Header
  $(window).scroll(function () {
    let scroll = $(window).scrollTop();
    if (scroll >= 20) {
      $("header").addClass("move shadow");
      $(".package_fixed_bar").addClass("up");
    } else {
      $("header").removeClass("move shadow");
      $(".package_fixed_bar").removeClass("up");
    }
  });

  // Search btn
  $(".search_btn").click(function () {
    $(".search_form").toggleClass("move");
  });
  // Courses Slider
  $(".courses_slider").owlCarousel({
    loop: false,
    nav: false,
    dots: true,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1, margin: 5 },
      577: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
    },
  });
  // Tools Slider
  $(".tools_slider").owlCarousel({
    loop: false,
    nav: true,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1, nav: false, dots: true, margin: 5 },
      577: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
      1200: { items: 4 },
    },
  });
  // Related Course Slider
  $(".related_courses_slider").owlCarousel({
    loop: false,
    nav: true,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1, nav: false, dots: true, margin: 5 },
      577: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
    },
  });
  // Blog Slider
  $(".blog_slider").owlCarousel({
    loop: false,
    nav: false,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1 },
      768: { items: 1 },
      992: { items: 2 },
      1200: { items: 2 },
    },
  });
  // Team Slider
  $(".team_slider").owlCarousel({
    loop: false,
    nav: false,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
      1200: { items: 4 },
    },
  });
  // Partners Slider
  $(".partners_slider").owlCarousel({
    loop: false,
    nav: false,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
      1200: { items: 4 },
    },
  });
  // News Slider
  $(".news_slider").owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 3 },
      1200: { items: 3 },
    },
  });
  // Companies Slider
  $(".companies_slider").owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 0,
    autoplay: true,
    rtl: true,
    responsive: {
      0: { items: 1 },
    },
  });
  // Bookmark Btn
  $(".course .cover .act .icon_link").click(function () {
    $(this).toggleClass("clicked");
  });
  $(".tool_item .cont .w-100 .icon_link").click(function () {
    $(this).toggleClass("clicked");
  });
  // Up
  var scrollbutton = $(".up_btn");
  $(window).scroll(function () {
    $(this).scrollTop() >= 1000
      ? scrollbutton.addClass("show")
      : scrollbutton.removeClass("show");
  });
  scrollbutton.click(function () {
    $("html , body").animate(
      {
        scrollTop: 0,
      },
      600
    );
  });

  //  fancybox
  $("[data-fancybox]").fancybox({
    buttons: ["zoom", "slideShow", "fullScreen", "thumbs", "close"],
  });
  // Number
  $(".number-up").on("click", function () {
    var e = $(this).closest(".cat-number").find('input[type="number"]').val();
    return (
      $(this)
        .closest(".cat-number")
        .find('input[type="number"]')
        .val(parseFloat(e) + 1)
        .attr("value", parseFloat(e) + 1),
      !1
    );
  }),
    $(".number-down").on("click", function () {
      var e = $(this).closest(".cat-number").find('input[type="number"]').val();
      return (
        e > 1 &&
          $(this)
            .closest(".cat-number")
            .find('input[type="number"]')
            .val(parseFloat(e) - 1)
            .attr("value", parseFloat(e) - 1),
        !1
      );
    }),
    $(".cat-number")
      .find('input[type="number"]')
      .on("keyup", function () {
        $(this).attr("value", $(this).val());
      });
});
//bootstrap notify
function notification(type, message ,icon) {
    var content = {};

    content.message = message;
    content.icon = icon;

    var notify = $.notify(content, {
        type: type,
        allow_dismiss: false,
        newest_on_top: true,
        mouse_over: true,
        spacing: 10,
        timer: 2000,
        placement: {
            from: 'bottom',
            align: "left" // isRTL() ? 'left' :
        },
        offset: {
            x: 10,
            y: 10
        },
        delay: 1000,
        z_index: 99999999,
        animate: {
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown"
        }
    });
}