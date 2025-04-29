@extends('layouts.main')

@section('content')
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
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
@endsection
