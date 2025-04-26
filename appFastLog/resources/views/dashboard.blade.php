<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>FastLog</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      @include('components.sidebar')
      <!-- End Sidebar -->

      <div class="main-panel">
        @include('components.header')
        @component('components.container')
            <div class="row">
                <!-- Delivery Statistics Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-primary card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Deliveries</p>
                                        <h4 class="card-title">150</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Transit Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-route"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">In Transit</p>
                                        <h4 class="card-title">45</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivered Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Delivered</p>
                                        <h4 class="card-title">95</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-warning card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Pending</p>
                                        <h4 class="card-title">10</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Delivery Timeline Chart -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Delivery Timeline</div>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="deliveryTimelineChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Status Distribution Chart -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Delivery Status Distribution</div>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="deliveryStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Performance Chart -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Monthly Delivery Performance</div>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="deliveryPerformanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Delivery Timeline Chart
    new Chart(document.getElementById('deliveryTimelineChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Deliveries',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#1572E8',
                tension: 0.1
            }]
        }
    });

    // Delivery Status Distribution Chart
    new Chart(document.getElementById('deliveryStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'In Transit', 'Pending'],
            datasets: [{
                data: [95, 45, 10],
                backgroundColor: ['#31CE36', '#48ABF7', '#FFAD46']
            }]
        }
    });

    // Delivery Performance Chart
    new Chart(document.getElementById('deliveryPerformanceChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'On-Time Deliveries',
                data: [90, 85, 88, 92, 87, 89],
                backgroundColor: '#1572E8'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>
            </div>
        @endcomponent

        @include('components.footer')
      </div>
    </div>

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>
  </body>
</html>
