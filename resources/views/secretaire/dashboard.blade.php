@extends('adminlte::page')

@section('title', 'Dashboard Secrétaire')

@section('content_header')
    <h1 class="fw-bold text-primary" style="color:#1f94d2!important;">
        <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord Secrétaire
    </h1>
    <p class="text-muted mb-0">Ceci est votre tableau de bord personnalisé avec AdminLTE.</p>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
        }

        /* Small box custom */
        .small-box {
            border-radius: 12px !important;
            padding-bottom: .6rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .small-box .inner h3 {
            font-size: 2.1rem;
            font-weight: 800;
        }

        .small-box .icon {
            opacity: 0.25;
            right: 15px;
            top: 10px;
            font-size: 4.2rem;
        }

        /* Dégradés spécifiques */
        .bg-info {
            background: linear-gradient(145deg, var(--main-blue), #5cbff0) !important;
        }

        .bg-warning {
            background: linear-gradient(145deg, var(--main-yellow), #ffd84a) !important;
            color: #1b1b1b !important;
        }

        .bg-success {
            background: linear-gradient(145deg, #2fb36a, #43d182) !important;
        }

        .bg-danger {
            background: linear-gradient(145deg, var(--main-red), #ff6161) !important;
        }

        .small-box-footer {
            background-color: rgba(0, 0, 0, 0.05) !important;
            color: #fff !important;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
        }

        .bg-warning .small-box-footer {
            color: #222 !important;
        }

        /* Card Chart */
        .card {
            border-radius: 14px;
            box-shadow: 0 3px 14px rgba(31, 148, 210, 0.08);
        }

        .card-header {
            border-bottom: none;
            background: var(--main-blue);
            color: #fff;
            border-radius: 14px 14px 0 0 !important;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.15rem;
        }
    </style>

    <div class="row">
        <!-- Courriers traités -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info text-white">
                <div class="inner">
                    <h3>{{ $totalCourriers ?? 0 }}</h3>
                    <p>Courriers traités</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <a href="{{ route('courriers.reception.index') }}" class="small-box-footer">
                    Voir les courriers <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- En attente -->
        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $courriersEnAttente ?? 0 }}</h3>
                    <p>Courriers en attente</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('courriers.reception.index', ['status' => 'pending']) }}" class="small-box-footer">
                    Voir en attente <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> --}}

        <!-- Expéditions -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalExpeditions ?? 0 }}</h3>
                    <p>Expéditions créées</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('courriers.reception.index', ['mouvement' => 'expedition']) }}" class="small-box-footer">
                    Voir expéditions <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Réceptions -->
        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger text-white">
                <div class="inner">
                    <h3>{{ $totalReceptions ?? 0 }}</h3>
                    <p>Réceptions enregistrées</p>
                </div>
                <div class="icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <a href="{{ route('courriers.reception.index', ['mouvement' => 'reception']) }}" class="small-box-footer">
                    Voir réceptions <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> --}}
    </div>

    {{-- Graphique --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-bar me-2"></i>Statistiques mensuelles des courriers</h3>
        </div>
        <div class="card-body bg-white rounded-bottom">
            <canvas id="courrierChart" style="min-height: 250px; height: 250px;"></canvas>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('courrierChart').getContext('2d');
        const courrierChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($graphLabels ?? []) !!},
                datasets: [{
                        label: 'Courriers reçus',
                        backgroundColor: '#1f94d2',
                        borderRadius: 6,
                        data: {!! json_encode($graphReceptionData ?? []) !!}
                    },
                    {
                        label: 'Courriers envoyés',
                        backgroundColor: '#28a745',
                        borderRadius: 6,
                        data: {!! json_encode($graphExpeditionData ?? []) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
