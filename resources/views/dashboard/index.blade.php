@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.dashboard') }}
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow" style="display: none"></div> --}}
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


                <div class="main-content d-flex justify-content-center align-items-center min-vh-100 dashboard-wrapper"
                 style="margin-left: 0">
                    <div class="dashboard-content container-fluid px-4">
                        <div class="row align-items-start">
                            <div class="col-lg-12" style="align-items: center">
                               <div class="page-title" style="text-align: center; margin-bottom: 10px;">
                                    <div class="title" style="text-align: center !important; font-family: 'Dubai', sans-serif; float:none; direction: ltr;">
                                        <h3 style="color: white; font-family: 'Dubai', sans-serif;">{{ __('dashboard.dashboard') }}</h3>
                                        <p style="color: white; font-family: 'Dubai', sans-serif;">{{ __('dashboard.welcome_to_dashboard') }} {{ Auth::user()->name }}</p>
                                       <h3 style="color: white; font-family: 'Dubai', sans-serif;">{{ __('dashboard.number_of_members') }}: {{ $members }}</h3>
                                      </div>
                                </div> 
                            </div>



                            {{-- كروت الأرقام --}}
                            @php
                                $cards = [
                                    [
                                        'value' => $jobs,
                                        'text' => __('dashboard.number_of_jobs_this_Day'),
                                        'img' => 'details-icon-1.png',
                                    ],
                                    [
                                        'value' => $companies,
                                        'text' => __('dashboard.number_of_companies'),
                                        'img' => 'details-icon-4.png',
                                    ],
                                    [
                                        'value' => $employees,
                                        'text' => __('dashboard.number_of_employees'),
                                        'img' => 'menu-img-5.png',
                                    ],
                                    [
                                        'value' => $dailyAdvertises,
                                        'text' => __('dashboard.number_of_advertises_this_day'),
                                        'img' => 'details-icon-2.png',
                                    ],
                                ];
                            @endphp
                            @foreach ($cards as $card)
                            {{-- @if($card['text'] ==  __('dashboard.number_of_advertises_this_day'))
                            @dd($card)
                            @endif --}}
                            {{-- @dd($card) --}}
                                <div class="col-lg-3 col-md-6" >
                                    <div class="single-details text-center" 
                                    @if($card['text'] == __('dashboard.number_of_advertises_this_day')) style="background-color:#FF9F43;" 
                                    @elseif($card['text'] == __('dashboard.number_of_jobs_this_Day')) style="background-color:#FF6384;" 
                                    @elseif($card['text'] == __('dashboard.number_of_companies')) style="background-color:#6C5CE7;" 
                                    @elseif($card['text'] == __('dashboard.number_of_employees')) style="background-color:#5B3FFF;" 
                                    @endif>
                                        <div class="icon mb-2">
                                            <img src="{{ asset('assets/images/' . $card['img']) }}" alt="icon">
                                        </div>
                                        <h5 style="color: white">{{ $card['value'] }}</h5>
                                        <span style="color: white">{{ $card['text'] }}</span>
                                    </div>
                                </div>
                            @endforeach

                            {{-- الشارتات --}}
                            <div class="col-lg-6 mb-1">
                                <div class="revenu-chart">
                                    <div class="revenu-title d-flex justify-content-between">
                                        <h3>{{ __('dashboard.jobs') }}</h3>
                                    </div>
                                    <div class="revenu-heading d-flex justify-content-between">
                                        <div>
                                            <h5>{{ __('dashboard.all') }}</h5>
                                            <span>{{ $all_jobs }}</span>
                                        </div>
                                        <span>#</span>
                                    </div>
                                    {!! $chart->render() !!}
                                </div>
                            </div>

                            <div class="col-lg-6 mb-1">
                                <div class="revenu-chart">
                                    <div class="revenu-title d-flex justify-content-between">
                                        <h3>{{ __('dashboard.posts') }}</h3>
                                    </div>
                                    <div class="revenu-heading d-flex justify-content-between">
                                        <div>
                                            <h5>{{ __('dashboard.all') }}</h5>
                                            <span>{{ $Advertises }}</span>
                                        </div>
                                        <span>#</span>
                                    </div>
                                    {!! $chartPosts->render() !!}
                                </div>
                            </div>

                            {{-- تفاصيل الشركات --}}
                            <div class="col-lg-6 mb-4">
                                <div class="order-summery">
                                    <div class="summery-heading d-flex justify-content-between">
                                        <h5>{{ __('dashboard.details_of_companies') }}</h5>
                                        <span>#</span>
                                    </div>
                                    <div class="summerys d-flex justify-content-between">
                                        <div class="single-summery">
                                            <h4>{{ $disactiveCompanies }}</h4>
                                            <p>{{ __('dashboard.disactives') }}</p>
                                        </div>
                                        <div class="single-summery">
                                            <h4>{{ $activeCompanies }}</h4>
                                            <p>{{ __('dashboard.actives') }}</p>
                                        </div>
                                        <div class="single-summery">
                                            <h4>{{ $companies }}</h4>
                                            <p>{{ __('dashboard.total') }}</p>
                                        </div>
                                    </div>
                                    <div class="new-order d-flex justify-content-between align-items-center">
                                        <p>{{ __('dashboard.active_request') }}</p>
                                        <span class="number">{{ $disactiveCompanies }}</span>
                                        <a href="{{ route('admin.companies.index') }}" class="view-btn">
                                            {{ __('dashboard.view_all') }} <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- تفاصيل الموظفين --}}
                            <div class="col-lg-6 mb-4">
                                <div class="order-summery">
                                    <div class="summery-heading d-flex justify-content-between">
                                        <h5>{{ __('dashboard.details_of_employees') }}</h5>
                                        <span>#</span>
                                    </div>
                                    <div class="summerys d-flex justify-content-between">
                                        <div class="single-summery">
                                            <h4>{{ $disactiveEmployees }}</h4>
                                            <p>{{ __('dashboard.disactives') }}</p>
                                        </div>
                                        <div class="single-summery">
                                            <h4>{{ $activeEmployees }}</h4>
                                            <p>{{ __('dashboard.actives') }}</p>
                                        </div>
                                        <div class="single-summery">
                                            <h4>{{ $employees }}</h4>
                                            <p>{{ __('dashboard.total') }}</p>
                                        </div>
                                    </div>
                                    <div class="new-order d-flex justify-content-between align-items-center">
                                        <p>{{ __('dashboard.active_request') }}</p>
                                        <span class="number">{{ $disactiveEmployees }}</span>
                                        <a href="{{ route('admin.employees.index') }}" class="view-btn">
                                            {{ __('dashboard.view_all') }} <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    formatter: function(val) {
                        return val
                    }
                },
                y: {
                    formatter: function(val) {
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
                    formatter: function(val) {
                        return Math.abs(Math.round(val)) + "%"
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
