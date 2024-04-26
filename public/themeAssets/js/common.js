//=========================================================================================================================

$(document).ready(function () {
  $("#matchQue").owlCarousel({
    loop: true,
    autoplay: false,
    autoplayTimeout: 7000,
    smartSpeed: 800,
    nav: false,
    dots: true,
    items: 1,
  });
  $(".navbar-toggler").on("click", function () {
    $(this).toggleClass("on");
  });
});
