/*=========================================================================================
    File Name: dashboard-ecommerce.js
    Description: dashboard ecommerce page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function () {

  var $primary = '#7367F0';
  var $success = '#28C76F';
  var $danger = '#EA5455';
  var $warning = '#FF9F43';
  var $info = '#00cfe8';
  var $primary_light = '#A9A2F6';
  var $danger_light = '#f29292';
  var $success_light = '#55DD92';
  var $warning_light = '#ffc085';
  var $info_light = '#1fcadb';
  var $strok_color = '#b9c3cd';
  var $label_color = '#e7e7e7';
  var $white = '#fff';


  // Line Area Chart - 1
  // ----------------------------------

  var gainedlineChartoptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0
        }
      },
    },
    colors: [$primary],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'Subscribers',
      data: [28, 40, 36, 52, 38, 60, 55]
    }],

    xaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      }
    },
    yaxis: [{
      y: 0,
      offsetX: 0,
      offsetY: 0,
      padding: { left: 0, right: 0 },
    }],
    tooltip: {
      x: { show: false }
    },
  }

  var gainedlineChart = new ApexCharts(
    document.querySelector("#line-area-chart-1"),
    gainedlineChartoptions
  );

  gainedlineChart.render();

});


// Chat Application
(function ($) {
  "use strict";
  // Chat area
  if ($('.chat-application .user-chats').length > 0) {
    var chat_user = new PerfectScrollbar(".user-chats", { wheelPropagation: false });
  }

})(jQuery);

