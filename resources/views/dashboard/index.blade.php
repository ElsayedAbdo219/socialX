@extends('components.dashboard.layouts.master')
@section('title')
        {{__('dashboard.dashboard')}}
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                {{-- <section id="dashboard-analytics">
                    <div class="row" style="margin-right: 500px">
                         <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card bg-analytics text-white">
                                <div class="card-content">
                                    <div class="card-body text-center">
                                        <img src="{{asset('dashboardAssets/app-assets/images/elements/decore-left.png')}}" class="img-left" alt="
                                            card-img-left">
                                        <img src="{{asset('dashboardAssets/app-assets/images/elements/decore-right.png')}}" class="img-right" alt="
                                            card-img-right">
                                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-award white font-large-1"></i>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="mb-2 text-white">{{ auth()->user()->name }}</h1>
                                            <p class="m-auto w-75">{{__('dashboard.welcome_message')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>  --}}


                       

                       {{-- <div class="row">


                        <div class="col-lg-3 col-md-6 col-12 card_stats">
                            <div class="card">
                                <div class="card-header d-flex flex-column align-items-start pb-0">
                                    <div class="avatar bg-rgba-primary p-50 m-0">
                                        <div class="avatar-content" >
                                            <i class="feather icon-users text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700 mt-1 mb-25">{{ '--'}}</h2>
                                    <p class="mb-0">--</p>
                                </div>
                                <div class="card-content">
                                    <div id="subscribe-gain-chart"></div>
                                </div>
                            </div>
                        </div>  --}}


                       {{-- <div class="card_stats">
                        <div class="card-body">
                            <h5 class="card-title">الشركات</h5>
                            <div class="row">
                                <div class="col">
                                    <h6 style="font-weight: bold;">الاجمالي</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">{{ $activeMembers + $disactiveMembers }}</p>
                                </div>

                                <div class="col">
                                    <h6 style="font-weight: bold;">المستخدمين الفعالين </h6>
                                    <p class="card-text" style="color: green ; font-weight: bold">{{ $activeMembers }}</p>
                                </div>

                                
                                <div class="col">
                                    <h6 style="font-weight: bold;">المستخدمين الغير فعالين</h6>
                                    <p class="card-text" style="color: red ; font-weight: bold">{{ $disactiveMembers }}</p>
                                </div>
                               
                            </div>
                        </div>
                    </div> --}}
{{-- 
                    <div class="card_stats">
                        <div class="card-body">
                            <h5 class="card-title">المستقلين</h5>
                            <div class="row">
                                <div class="col">
                                    <h6 style="font-weight: bold;">الاجمالي</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">0</p>
                                </div>
                                <div class="col">
                                    <h6 style="font-weight: bold;">المستقلين الفعالين</h6>
                                    <p class="card-text"  style="color: green ; font-weight: bold">50</p>
                                </div>
                                <div class="col">
                                    <h6 style="font-weight: bold;">المستقلين الغير فعالين</h6>
                                    <p class="card-text" style="color: red ; font-weight: bold">800</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     --}}


                    {{-- <div class="card_stats">
                        <div class="card-body">
                            <h5 class="card-title">الوظائف</h5>
                            </h5>
                            <div class="row">
                                <div class="col">
                                    <h6 style="font-weight: bold;">عدد وظائف اليوم</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">1000</p>
                                </div>
                                <div class="col">
                                    <h6 style="font-weight: bold;">عدد المتقدمين</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">50</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    


                    {{-- <div class="card_stats">
                        <div class="card-body">
                            <h5 class="card-title">الشكاوي</h5>
                            <div class="row">
                                <div class="col">
                                    <h6 style="font-weight: bold;">عدد شكاوي اليوم </h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">1000</p>
                                </div>
                                <div class="col">
                                    <h6 style="font-weight: bold;">تم حلها </h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">50</p>
                                </div>
                                <div class="col">
                                    <h6 style="font-weight: bold;">جاري المعالجة</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">800</p>
                                </div>

                                <div class="col">
                                    <h6 style="font-weight: bold;"> لم يتم الرد</h6>
                                    <p class="card-text" style="color: white ; font-weight: bold">800</p>
                                </div>



                            </div>
                        </div>
                    </div>
                     --}}



 <div class="main-content" style="margin-right: 150px">
        <div class="dashboard-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <div class="title">
                                <h3>لوحة التحكم</h3>
                                <p>مرحبا بك في لوحة التحكم {{ Auth::user()->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-details">
                            <div class="icon">
                                <img src="{{ asset('assets/images/details-icon-1.png') }}" alt="images" />
                            </div>
                            <div class="details">
                                <h5>{{ $jobs }}</h5>
                                <span>عدد وظائف اليوم</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-details">
                            <div class="icon">
                                <img src="{{ asset('assets/images/details-icon-2.png') }}" alt="images" />
                            </div>
                            <div class="details">
                                <h5>{{ $companies }}</h5>
                                <span>عدد الشركات</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-details">
                            <div class="icon">
                                <img src="{{ asset('assets/images/details-icon-3.png') }}" alt="images" />
                            </div>
                            <div class="details">
                                <h5>{{ $employees }}</h5>
                                <span>عدد المستقلين</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-details">
                            <div class="icon">
                                <img src="{{ asset('assets/images/details-icon-4.png') }}" alt="images" />
                            </div>
                            <div class="details">
                                <h5>{{ $complains }}</h5>
                                <span>عدد الشكاوي اليوم</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="revenu-chart">
                            <div class="revenu-title">
                                <div class="title">
                                    <h3>الوظائف</h3>
                                </div>
                                <div class="page-title-sorts">
                                    <a href="#" class="sort-two">
                                        <span>شهريا</span>
                                        <i class="fas fa-sort-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="revenu-heading">
                                <div class="title">
                                    <h5>Income</h5>
                                    <span>$1236598</span>
                                </div>
                                <div class="summery-menu">
                                    <button class="active">يوميا</button>
                                    <button>اسبوعيا</button>
                                    <button>شهريا</button>
                                </div>
                            </div>
                            <canvas id="revenueChart" width="400" height="200"></canvas>
                        </div>
                       
                    </div>

                    
                    <div class="col-lg-6">
                        <div class="order-summery">
                            <div class="summery-heading">
                                <div class="title">
                                    <h5>تفاصيل الشركات</h5>
                                </div>
                                <div class="summery-menu">
                                    <button class="active">يوميا</button>
                                    <button>اسبوعيا</button>
                                    <button>شهريا</button>
                                </div>
                            </div>
                            <div class="summerys">
                                <div class="single-summery">
                                    <h4>{{ $disactiveCompanies }}</h4>
                                    <p>الغير فعالين</p>
                                </div>
                                <div class="single-summery">
                                    <h4>{{ $activeCompanies }}</h4>
                                    <p>الفعالين</p>
                                </div>
                                <div class="single-summery">
                                    <h4>{{ $companies }}</h4>
                                    <p>الاجمالي</p>
                                </div>
                            </div>
                            <div class="new-order">
                                <p>طلب تفعيل</p>
                                <div class="number">
                                    <span>{{ $disactiveCompanies }}</span>
                                </div>
                                <div class="view-btn">
                                    <a href="{{ route('admin.companies.index') }}">رؤية الكل <i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>


                            
                        </div>
                    
                    </div>


                    <div class="col-lg-6">
                        <div class="order-summery">
                            <div class="summery-heading">
                                <div class="title">
                                    <h5>تفاصيل المستقلين</h5>
                                </div>
                                <div class="summery-menu">
                                    <button class="active">يوميا</button>
                                    <button>اسبوعيا</button>
                                    <button>شهريا</button>
                                </div>
                            </div>
                            <div class="summerys">
                                <div class="single-summery">
                                    <h4>{{ $disactiveEmployees }}</h4>
                                    <p>الغير فعالين</p>
                                </div>
                                <div class="single-summery">
                                    <h4>{{ $activeEmployees }}</h4>
                                    <p>الفعالين</p>
                                </div>
                                <div class="single-summery">
                                    <h4>{{ $employees }}</h4>
                                    <p>الاجمالي</p>
                                </div>
                            </div>
                            <div class="new-order">
                                <p>طلب تفعيل</p>
                                <div class="number">
                                    <span>{{ $disactiveEmployees }}</span>
                                </div>
                                <div class="view-btn">
                                    <a href="{{ route('admin.employees.index') }}">رؤية الكل <i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>


                            
                        </div>
                    
                    </div>

                    
               
               
                   
                </div>
            </div>
        </div>
    </div>
    <!-- main-content end -->





                     


                       
                    </div>
                </section>
            </div>
        </div>
    </div>



    <script>


var ctx = document.getElementById('revenueChart').getContext('2d');
        var gradientColor = ctx.createLinearGradient(0, 0, 0, 400);
        gradientColor.addColorStop(0, "rgba(253, 104, 62, 1)");
        gradientColor.addColorStop(1, "rgba(255, 255, 255, 0)");
        var ctx = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: '',
                    data: [5, 25, 17, 36, 30, 50],
                    backgroundColor: gradientColor,
                    borderColor: gradientColor,
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                display: false,
                labels: {
                    fontColor: '#ffffff'
                }
            },
                scales: {
                    yAxes: [{
                        
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });







        var options = {
          series: [{
          name: 'Males',
          data: [0.4, 0.65, 0.76, 0.88, 1.5, 2.1, 2.9, 3.8, 3.9, 4.2, 4, 4.3, 4.1, 4.2, 4.5,
            3.9, 3.5, 3
          ]
        },
        {
          name: 'Females',
          data: [-0.8, -1.05, -1.06, -1.18, -1.4, -2.2, -2.85, -3.7, -3.96, -4.22, -4.3, -4.4,
            -4.1, -4, -4.1, -3.4, -3.1, -2.8
          ]
        }
        ],
        chart: {
          type: 'bar',
          height: 300,
          stacked: true,
          
        },
        colors: ['#FD683E', '#2BC155'],
        plotOptions: {
          bar: {
            horizontal: false,
            barHeight: '100%',
            // borderRadius: 7,
            radiusOnLastStackedBar: true,
          },
          
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: 1,
          colors: ["#fff"]
        },
        
        grid: {
          xaxis: {
            lines: {
              show: false
            }
          },
          yaxis: {
            lines: {
              show: true,
            }
          }
        },
        yaxis: {
          min: -15,
          max: 15,          
        },
        tooltip: {
          shared: false,
          x: {
            formatter: function (val) {
              return val
            }
          },
          y: {
            formatter: function (val) {
              return Math.abs(val) + "%"
            }
          }
        },
        xaxis: {
          categories: ['85+', '80-84', '75-79', '70-74', '65-69', '60-64', '55-59', '50-54',
            '45-49', '40-44', '35-39', '30-34', '25-29', '20-24', '15-19', '10-14', '5-9',
            '0-4'
          ],
          labels: {
            formatter: function (val) {
              return Math.abs(Math.round(val)) + "%"
            }
          }
        },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();




    </script>
@endsection
