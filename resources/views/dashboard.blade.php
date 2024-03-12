@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-lg-9">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-3 text-right">
                {{-- <input type="text" class="form-control" id="daterange" name="" value="01/01/2018 - 01/15/2018" /> --}}
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard" id="dashboard-stats-url" data-statsurl="{{ url('admin/dashboard') }}/stats">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="get_sales">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Sales <span>| <span id="sales_loader"> Today</span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="sales_count">{{ $records['sales'] }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->


                    <!-- Revenue Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="get_revenue">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Revenue <span>| <span id="revenue_loader"> Today</span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>$<span id="revenue_sum">{{ $records['revenue'] }}</span></h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    {{-- <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> Last 7 days Earning</h5>

              <!-- Line Chart -->
              <canvas id="lineChart" style="max-height: 400px; display: block; box-sizing: border-box; height: 199px; width: 399px;" width="599" height="299"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#lineChart'), {
                    type: 'line',
                    data: {
                      labels: ['monday', 'teusday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                      datasets: [{
                        label: 'Line Chart',
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Line CHart -->

            </div>
          </div>
        </div> --}}

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subscription Wise Earning</h5>
                                {{-- @php
                print_r($records['subscription_wise_earning']);

                // echo implode(''', $records['subscription_wise_earning']['labels']);
                echo json_encode($records['subscription_wise_earning']['labels']);
                
              @endphp --}}

                                <!-- Bar Chart -->
                                <canvas id="barChart"
                                    style="max-height: 400px; display: block; box-sizing: border-box; height: 199px; width: 399px;"
                                    width="599" height="299"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {

                                        new Chart(document.querySelector('#barChart'), {
                                            type: 'bar',
                                            data: {
                                                labels: @php echo json_encode($records['subscription_wise_earning']['labels']) @endphp,
                                                datasets: [{
                                                    label: 'Bar Chart',
                                                    data: @php echo json_encode($records['subscription_wise_earning']['prices']) @endphp,
                                                    backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)',
                                                        'rgba(255, 205, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(153, 102, 255, 0.2)',
                                                        'rgba(201, 203, 207, 0.2)'
                                                    ],
                                                    borderColor: [
                                                        'rgb(255, 255, 255)',
                                                        'rgb(255, 255, 255)',
                                                        'rgb(255, 255, 255)',
                                                        'rgb(75, 192, 192)',
                                                        'rgb(54, 162, 235)',
                                                        'rgb(153, 102, 255)',
                                                        'rgb(201, 203, 207)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <!-- End Bar CHart -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Signups</h5>
                                {{-- @php
                print_r($records['subscription_wise_earning']);

                // echo implode(''', $records['subscription_wise_earning']['labels']);
                echo json_encode($records['subscription_wise_earning']['labels']);
                
              @endphp --}}

                                <!-- Bar Chart -->
                                {{-- {{json_encode($records['signups']['signups'])}} --}}
                                <canvas id="signups"
                                    style="max-height: 400px; display: block; box-sizing: border-box; height: 199px; width: 399px;"
                                    width="599" height="299"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#signups'), {
                                            type: 'line',
                                            data: {
                                                labels: @php echo json_encode($records['signups']['labels']) @endphp,
                                                datasets: @php echo json_encode($records['signups']['signups']) @endphp
                                                //                 [
                                                //   {
                                                //     label: 'SignUps',
                                                //     backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                                //     borderColor: 'rgba(255, 99, 132, 1)',
                                                //     borderWidth: 2,
                                                //     data: [12, 19, 3, 5, 2]
                                                //   },
                                                //   {
                                                //     label: 'Companies',
                                                //     backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                //     borderColor: 'rgba(54, 162, 235, 1)',
                                                //     borderWidth: 2,
                                                //     data: [7, 11, 5, 8, 3]
                                                //   },
                                                //   {
                                                //     label: 'Job Seekers',
                                                //     backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                //     borderColor: 'rgba(75, 192, 192, 1)',
                                                //     borderWidth: 2,
                                                //     data: [9, 15, 8, 12, 6]
                                                //   }
                                                // ]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <!-- End Bar CHart -->

                            </div>
                        </div>
                    </div>





                    {{-- <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Quaterly Earning</h5>

              <!-- Bar Chart -->
              <canvas id="barChart1" style="max-height: 400px; display: block; box-sizing: border-box; height: 199px; width: 399px;" width="599" height="299"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#barChart1'), {
                    type: 'bar',
                    data: {
                      labels: ['First Quater', 'Second Quater', 'Third Quater', 'Forth Quater'],
                      datasets: [{
                        label: 'Bar Chart',
                        data: [65, 59, 80, 81],
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
   
                        ],
                        borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
        
                        ],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
        </div> --}}


                    <!-- Sales Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Signups </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $records['companies'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Companies</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6><?= $records['job_seekers'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Job Seekers</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6>{{ $records['companies'] + $records['job_seekers'] }}</h6>
                                                <span class="text-success small pt-1 fw-bold">Total Signups</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <h5 class="card-title">Companies</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-building"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $records['active_jobs'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Active Jobs</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6><?= $records['expired_jobs'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Expired Jobs</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6><?= $records['jobs'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Total Jobs</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div><!-- End Sales Card -->
                    <!-- Sales Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Job Seekers Applications</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-check"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $records['accepted_app'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Shortlisted
                                                    Application</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6><?= $records['rejected_app'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Rejected Applications</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <div class="ps-3">
                                                <h6><?= $records['applications'] ?></h6>
                                                <span class="text-success small pt-1 fw-bold">Total Applications</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div><!-- End Sales Card -->


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jobs</h5>
                                @php
                                    $pi_job_data = [
                                        $records['jobs'],
                                        $records['active_jobs'],
                                        $records['expired_jobs'],
                                    ];
                                @endphp
                                <!-- Pie Chart -->
                                <canvas id="pieChart" style="max-height: 400px;"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#pieChart'), {
                                            type: 'pie',
                                            data: {
                                                labels: [
                                                    'Total',
                                                    'Active',
                                                    'Expired'
                                                ],
                                                datasets: [{
                                                    label: 'Number of jobs',
                                                    data: @php echo json_encode($pi_job_data) @endphp,
                                                    backgroundColor: [
                                                        'rgb(255, 99, 132)',
                                                        'rgb(54, 162, 235)',
                                                        'rgb(255, 205, 86)'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            }
                                        });
                                    });
                                </script>
                                <!-- End Pie CHart -->

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Applications</h5>

                                <!-- Pie Chart -->
                                <canvas id="pieChart1" style="max-height: 400px;"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#pieChart1'), {
                                            type: 'pie',
                                            data: {
                                                labels: [
                                                    'Total',
                                                    'Shortlisted',
                                                    'Rejected'
                                                ],
                                                datasets: [{
                                                    label: 'Number of applications',
                                                    data: @php echo json_encode([$records['applications'], $records['accepted_app'], $records['rejected_app']]) @endphp,
                                                    backgroundColor: [
                                                        'rgb(255, 99, 132)',
                                                        'rgb(54, 162, 235)',
                                                        'rgb(255, 205, 86)'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            }
                                        });
                                    });
                                </script>
                                <!-- End Pie CHart -->

                            </div>
                        </div>
                    </div>


                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Employers</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Company</th>
                                            <th scope="col">Jobs</th>
                                            <th scope="col">Application</th>
                                            <th scope="col">Subscriptions</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($records['top_employers'] as $company)
                                            <tr>
                                                <td><a href="{{ route('companies.show', $company->id) }}"
                                                        class="text-primary fw-bold">{{ $company->name }}</a></td>
                                                <td>{{ $company->jobs_count }}</td>
                                                <td>{{ $company->applications_count }}</td>
                                                <td>{{ $company->owner->subscriptions->count() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Candidates</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Jobs</th>
                                            <th scope="col">Application</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($records['top_candidates'] as $candidate)
                                            <tr>
                                                <td><a href="{{ route('job_seekers.show', $candidate->id) }}"
                                                        class="text-primary fw-bold">{{ $candidate->name }}</a></td>
                                                <td>{{ $candidate->applications_count }}</td>
                                                <td>{{ $candidate->applications_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->



                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subscription</h5>
                                <!-- Bar Chart -->
                                <canvas id="barChart2"
                                    style="max-height: 400px; display: block; box-sizing: border-box; height: 199px; width: 399px;"
                                    width="599" height="299"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const packages = @json($records['packages']);
                                        const labels = packages.map(package => package.name);
                                        const data = packages.map(package => package.subscriptions_count);
                                        new Chart(document.querySelector('#barChart2'), {
                                            type: 'bar',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'Top package with subscription',
                                                    data: data,
                                                    backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)',
                                                        'rgba(255, 205, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        // Add more colors if needed
                                                    ],
                                                    borderColor: [
                                                        'rgb(255, 99, 132)',
                                                        'rgb(255, 159, 64)',
                                                        'rgb(255, 205, 86)',
                                                        'rgb(75, 192, 192)',
                                                        // Add more colors if needed
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                                <!-- End Bar CHart -->

                            </div>
                        </div>
                    </div>




                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Top 10 Categories</h5>
                                <!-- List group With badges -->
                                <ul class="list-group">
                                    @foreach ($records['categories'] as $category)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $category->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $category->jobs_count }}</span>
                                        </li>
                                    @endforeach

                                </ul><!-- End List With badges -->

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Top 10 Companies</h5>
                                <!-- List group With badges -->
                                <ul class="list-group">
                                    @foreach ($records['top_employers'] as $company)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $company->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $company->owner->subscriptions_count }}</span>
                                        </li>
                                    @endforeach

                                </ul><!-- End List With badges -->
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Most Popular Skills</h5>

                                <!-- List group With badges -->
                                <ul class="list-group">
                                    @foreach ($records['top_skills'] as $skill)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $skill->name }}
                                            <span class="badge bg-primary rounded-pill">14</span>
                                        </li>
                                    @endforeach

                                </ul><!-- End List With badges -->

                            </div>
                        </div>

                    </div> --}}
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Posted Jobs<span> | <span id="jobs_loader"> </span></span></h5>
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="get_jobs">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="activity" id="jobs_container">
                            {!! $records['jobs_posted'] !!}
                        </div>

                    </div>
                </div><!-- End Recent Activity -->


                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Most Viewed Jobs</h5>

                        <!-- List group With badges -->
                        <ul class="list-group">
                            @foreach ($records['most_viewed'] as $viewed_job)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $viewed_job->job_title }}
                                    <span class="badge bg-primary rounded-pill">{{ $viewed_job->view_jobs_count }}</span>
                                </li>
                            @endforeach
                        </ul><!-- End List With badges -->
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Most Applied Jobs</h5>
                        <!-- List group With badges -->
                        <ul class="list-group">
                            @foreach ($records['applied_jobs'] as $job)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $job->job_title }}
                                    <span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span>
                                </li>
                            @endforeach

                        </ul><!-- End List With badges -->

                    </div>
                </div>


                {{-- <!-- Recent Activity -->
            <div class="card">
   

              <div class="card-body">
                <h5 class="card-title">New Messages</h5>
      
                <div class="activity">
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">32 min</div>
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                      Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                    </div>
                  </div><!-- End activity item-->
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">56 min</div>
                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                    <div class="activity-content">
                      Voluptatem blanditiis blanditiis eveniet
                    </div>
                  </div><!-- End activity item-->
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">2 hrs</div>
                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                    <div class="activity-content">
                      Voluptates corrupti molestias voluptatem
                    </div>
                  </div><!-- End activity item-->
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">1 day</div>
                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                    <div class="activity-content">
                      Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                    </div>
                  </div><!-- End activity item-->
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">2 days</div>
                    <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                    <div class="activity-content">
                      Est sit eum reiciendis exercitationem
                    </div>
                  </div><!-- End activity item-->
      
                  <div class="activity-item d-flex">
                    <div class="activite-label">4 weeks</div>
                    <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                    <div class="activity-content">
                      Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                    </div>
                  </div><!-- End activity item-->
      
                </div>
      
              </div>
            </div><!-- End Recent Activity --> --}}


                {{-- <!-- Recent Activity -->
      <div class="card">
   

        <div class="card-body">
          <h5 class="card-title">Notification</h5>

          <div class="activity">

            <div class="activity-item d-flex">
              <div class="activite-label">32 min</div>
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">56 min</div>
              <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
              <div class="activity-content">
                Voluptatem blanditiis blanditiis eveniet
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">2 hrs</div>
              <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
              <div class="activity-content">
                Voluptates corrupti molestias voluptatem
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">1 day</div>
              <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
              <div class="activity-content">
                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">2 days</div>
              <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
              <div class="activity-content">
                Est sit eum reiciendis exercitationem
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">4 weeks</div>
              <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
              <div class="activity-content">
                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
              </div>
            </div><!-- End activity item-->

          </div>

        </div>
      </div><!-- End Recent Activity --> --}}





            </div><!-- End Right side columns -->

        </div>
    </section>




    </div>
    </section>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        $(document).ready(function() {

            $('#daterange').daterangepicker();
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                console.log(picker.startDate.format('YYYY-MM-DD'));
                console.log(picker.endDate.format('YYYY-MM-DD'));
                var queryString = '?start=' + picker.startDate.format('YYYY-MM-DD') + '&end=' + picker
                    .endDate.format('YYYY-MM-DD');
                window.location.href = window.location.pathname + queryString;
            });


            // sales ajax call
            $("#get_sales li a").click(function() {
                var time = $(this).text();
                var stat_type = 'sales';
                var site_url = $('#dashboard-stats-url').attr("data-statsurl") + '?time=' + time +
                    '&state_type=' + stat_type;

                $('#sales_loader').html(
                    '<div class="spinner-border bb-spinner spinner-border-sm text-dark" role="status"><span class="visually-hidden">Loading...</span></div>'
                );

                $.ajax({
                    url: site_url,
                    method: 'get',
                    dataType: 'json',

                    success: function(response) {
                        if (response.status) {
                            $("#sales_count").html(response.data);
                            $('#sales_loader').html(time);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

            });

            // sales ajax call
            $("#get_revenue li a").click(function() {
                var time = $(this).text();
                var stat_type = 'revenue';
                var site_url = $('#dashboard-stats-url').attr("data-statsurl") + '?time=' + time +
                    '&state_type=' + stat_type;

                $('#revenue_loader').html(
                    '<div class="spinner-border bb-spinner spinner-border-sm text-dark" role="status"><span class="visually-hidden">Loading...</span></div>'
                );

                $.ajax({
                    url: site_url,
                    method: 'get',
                    dataType: 'json',

                    success: function(response) {
                        if (response.status) {
                            $("#revenue_sum").html(response.data);
                            $('#revenue_loader').html(time);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

            });

            // sales ajax call
            $("#get_signups li a").click(function() {
                var time = $(this).text();
                var stat_type = 'signups';
                var site_url = $('#dashboard-stats-url').attr("data-statsurl") + '?time=' + time +
                    '&state_type=' + stat_type;

                $('#revenue_loader').html(
                    '<div class="spinner-border bb-spinner spinner-border-sm text-dark" role="status"><span class="visually-hidden">Loading...</span></div>'
                );

                $.ajax({
                    url: site_url,
                    method: 'get',
                    dataType: 'json',

                    success: function(response) {
                        if (response.status) {
                            $("#revenue_sum").html(response.data);
                            $('#revenue_loader').html(time);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

            });


            $("#get_jobs li a").click(function() {
                var time = $(this).text();
                var stat_type = 'jobs';
                var site_url = $('#dashboard-stats-url').attr("data-statsurl") + '?time=' + time +
                    '&state_type=' + stat_type;

                $('#jobs_loader').html(
                    '<div class="spinner-border bb-spinner spinner-border-sm text-dark" role="status"><span class="visually-hidden">Loading...</span></div>'
                );

                $.ajax({
                    url: site_url,
                    method: 'get',
                    dataType: 'json',

                    success: function(response) {
                        if (response.status) {
                            $("#jobs_container").html(response.data);
                            $('#jobs_loader').html(time);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

            });


        });
    </script>
@endsection
