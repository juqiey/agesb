@extends('layouts.user_type.auth')

@section('title', 'Dashboard')

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-4 px-4">
                    <div class="row align-items-center">

                        <!-- Greeting -->
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center rounded-circle">
                                    <i class="ni ni-sun text-white text-lg"></i>
                                </div>

                                <div>
                                    <h4 class="mb-1 fw-bold text-dark" id="greeting">
                                        Good Morning
                                    </h4>
                                    <p class="mb-0 text-sm text-muted">
                                        Welcome back, {{ auth()->user()->name }}. Hope you have a productive day.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Clock -->
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <h5 class="fw-semibold text-dark mb-1" id="clock">
                            </h5>
                            <span class="text-xs text-muted" id="date">
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Overview</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Delivery Orders</h6>
                </div>
                <div class="card-body p-3">
                    <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                        <div class="chart">
                            <canvas id="chart-bars" class="chart-canvas" height="400"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('dashboard')
  <script>
    window.onload = function() {

        function updateGreetingAndClock() {
            const now = new Date();
            const hours = now.getHours();

            let greeting = "Hello";

            if (hours >= 5 && hours < 12) {
                greeting = "Good Morning ☀️";
            } else if (hours >= 12 && hours < 17) {
                greeting = "Good Afternoon 🌤️";
            } else if (hours >= 17 && hours < 21) {
                greeting = "Good Evening 🌆";
            } else {
                greeting = "Good Night 🌙";
            }

            document.getElementById("greeting").innerText = greeting;

            document.getElementById("clock").innerText =
                now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            document.getElementById("date").innerText =
                now.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }

        updateGreetingAndClock();
        setInterval(updateGreetingAndClock, 1000);

    const chartLabels = @json($months);
    const ssr = @json($ssr);
    const ssa = @json($ssa);
    const pr = @json($pr);

      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "SSR",
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: ssr,
                    },
                    {
                        label: "SSA",
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                        borderColor: "#3A416F",
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: ssa,
                    },
                    {
                        label: "PR",
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                        borderColor: "#17c1e8",
                        fill: false,
                        data: pr,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                },
            },
        });


        const delivery = @json($do);

        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: chartLabels,
                datasets: [{
                    label: "Total (RM)",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#fff",
                    data: delivery,
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 15,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            display: false
                        },
                    },
                },
            },
        });
    }


  </script>
@endpush

