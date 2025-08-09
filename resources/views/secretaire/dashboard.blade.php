@extends('adminlte::page')

@section('title', 'Dashboard Secrétaire')

@section('content_header')
    <h1>Tableau de bord Secrétaire</h1>
    <p>Ceci est votre tableau de bord personnalisé avec AdminLTE.</p>
@stop

@section('content')

    <div class="row">
        <!-- Small box : Nombre total de courriers traités -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalCourriers ?? 0 }}</h3>
                    <p>Courriers traités</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                {{-- <a href="{{ route('courriers.index') }}" class="small-box-footer">
                    Voir les courriers <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>

        <!-- Small box : Courriers en attente -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $courriersEnAttente ?? 0 }}</h3>
                    <p>Courriers en attente</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                {{-- <a href="{{ route('courriers.index', ['status' => 'pending']) }}" class="small-box-footer">
                    Voir en attente <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>

        <!-- Small box : Nombre d’expéditions créées -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalExpeditions ?? 0 }}</h3>
                    <p>Expéditions créées</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                {{-- <a href="{{ route('courriers.index', ['mouvement' => 'expedition']) }}" class="small-box-footer">
                    Voir expéditions <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>

        <!-- Small box : Nombre de réceptions -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalReceptions ?? 0 }}</h3>
                    <p>Réceptions enregistrées</p>
                </div>
                <div class="icon">
                    <i class="fas fa-inbox"></i>
                </div>
                {{-- <a href="{{ route('courriers.index', ['mouvement' => 'reception']) }}" class="small-box-footer">
                    Voir réceptions <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>
    </div>

    {{-- Exemple de section de graphiques, si nécessaire --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Statistiques mensuelles des courriers</h3>
        </div>
        <div class="card-body">
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
                        backgroundColor: '#17a2b8',
                        data: {!! json_encode($graphReceptionData ?? []) !!}
                    },
                    {
                        label: 'Courriers envoyés',
                        backgroundColor: '#28a745',
                        data: {!! json_encode($graphExpeditionData ?? []) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
@stop
