@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1 class="fw-bold" style="color:#1f94d2!important;">
        <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord Admin
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
        }

        /* Small box revamp */
        .small-box {
            border-radius: 14px !important;
            padding-bottom: .6rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }

        .small-box .inner h3 {
            font-size: 2.2rem;
            font-weight: 800;
        }

        .small-box .icon {
            opacity: 0.18;
            right: 15px;
            top: 12px;
            font-size: 4.2rem;
        }

        /* Dégradés par couleur */
        .bg-info {
            background: linear-gradient(145deg, var(--main-blue), #5cbff0) !important;
            color: #fff !important;
        }

        .bg-success {
            background: linear-gradient(145deg, #2fb36a, #43d182) !important;
        }

        .bg-primary {
            background: linear-gradient(145deg, #3742fa, #5a69f0) !important;
        }

        .bg-warning {
            background: linear-gradient(145deg, var(--main-yellow), #ffd84a) !important;
            color: #1a1a1a !important;
        }

        /* Footer small box */
        .small-box-footer {
            background-color: rgba(0, 0, 0, 0.07) !important;
            font-weight: 600;
            border-radius: 0 0 14px 14px;
        }

        /* Card chart */
        .chart-card {
            border-radius: 14px;
            box-shadow: 0 3px 14px rgba(31, 148, 210, 0.08);
            background: #fff;
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }

        .chart-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--main-blue);
            margin-bottom: 1rem;
        }
    </style>

    <div class="row">
        <!-- Utilisateurs -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info text-white">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Utilisateurs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users') }}" class="small-box-footer text-white">
                    Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Courriers -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success text-white">
                <div class="inner">
                    <h3>{{ $totalCourriers }}</h3>
                    <p>Courriers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('admin.courriers.index') }}" class="small-box-footer text-white">
                    Voir la liste <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Admins -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary text-white">
                <div class="inner">
                    <h3>{{ $countAdmin }}</h3>
                    <p>Admins</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Secrétaires -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $countSecretaire }}</h3>
                    <p>Secrétaires</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphique barres utilisateurs --}}
    <div class="chart-card">
        <h3><i class="fas fa-chart-bar me-2"></i>Répartition des utilisateurs</h3>
        <canvas id="userChart" style="max-height: 300px;"></canvas>
    </div>

    {{-- Graphique ligne courriers --}}
    <div class="chart-card">
        <h3><i class="fas fa-chart-line me-2"></i>Évolution du nombre de courriers (12 derniers mois)</h3>
        <canvas id="courrierChart" style="max-height: 350px;"></canvas>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique utilisateurs
        const ctxUser = document.getElementById('userChart').getContext('2d');
        new Chart(ctxUser, {
            type: 'bar',
            data: {
                labels: ['Admins', 'Secrétaires'],
                datasets: [{
                    label: 'Nombre d\'utilisateurs',
                    data: [{{ $countAdmin }}, {{ $countSecretaire }}],
                    backgroundColor: ['rgba(31, 148, 210, 0.8)', 'rgba(255, 226, 67, 0.8)'],
                    borderColor: ['rgba(31, 148, 210, 1)', 'rgba(255, 226, 67, 1)'],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Graphique courriers
        const ctxCourrier = document.getElementById('courrierChart').getContext('2d');
        new Chart(ctxCourrier, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Courriers par mois',
                    data: {!! json_encode($countsPerMonth) !!},
                    borderColor: 'rgba(31, 148, 210, 0.9)',
                    backgroundColor: 'rgba(31, 148, 210, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: 'rgba(255, 226, 67, 1)',
                    pointBorderColor: '#1f94d2',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@stop
