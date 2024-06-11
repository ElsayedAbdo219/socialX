(function($) {
"use strict";

    $("#metismenu").metisMenu();

    $('#toggle').on('click', function() {
        $('.left-sidebar').toggleClass('show');
   });

   $('#toggle').on('click', function() {
        $('.top-area').toggleClass('show');
    });

    $('#toggle').on('click', function() {
        $('.main-content').toggleClass('show');
    });

    $('#toggle').on('click', function() {
      $('.toogle-bar').toggleClass('show');
  });

  $('.options').on('click', function() {
    $(".popup").removeClass('show');
    $(this).prev(".popup").addClass('show');
  });
  
  
  
  
  

$('#piza').LineProgressbar({
  percentage: 40,
  fillBackgroundColor: "#624FD0",
  backgroundColor: "#EAEAEA",
  radius: 5,
  height: 3,
  unit: "%",
});
$('#Dessert').LineProgressbar({
  percentage: 50,
  fillBackgroundColor: "#634FD2",
  backgroundColor: "#EAEAEA",
  radius: 5,
  height: 3,
  unit: "%",
});
$('#juice').LineProgressbar({
  percentage: 80,
  fillBackgroundColor: "#FFA41D",
  backgroundColor: "#EAEAEA",
  radius: 5,
  height: 3,
  unit: "%",
});


    $('.upload-box').on('click', function() {
        $('#getFile').trigger('click');
    });

    $('.facilities-active').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>' ,
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>' ,
        responsive: [
            {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow:3,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 500,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          }
        ]
      });

      
       project ta ses kora den ajka


})(jQuery);