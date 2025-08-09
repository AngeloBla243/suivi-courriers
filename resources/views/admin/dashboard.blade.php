@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Tableau de bord Admin</h1>
@stop

@section('content')
    <div class="row">
        {{-- Carte : Nombre total d’utilisateurs --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Utilisateurs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users') }}" class="small-box-footer">
                    Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Carte : Nombre total de courriers --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalCourriers }}</h3>
                    <p>Courriers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('admin.courriers.index') }}" class="small-box-footer">
                    Voir la liste <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Carte : Admins --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $countAdmin }}</h3>
                    <p>Admins</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        {{-- Carte : Secrétaires --}}
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
    <canvas id="userChart" width="400" height="200"></canvas>

    {{-- Graphique ligne évolution courrier --}}
    <div class="mt-4">
        <h3>Evolution du nombre de courriers (12 derniers mois)</h3>
        <canvas id="courrierChart" width="600" height="300"></canvas>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique nombre utilisateurs (barres)
        const ctxUser = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(ctxUser, {
            type: 'bar',
            data: {
                labels: ['Admins', 'Secrétaires'],
                datasets: [{
                    label: 'Nombre d\'utilisateurs',
                    data: [{{ $countAdmin }}, {{ $countSecretaire }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Graphique évolution courrier (ligne)
        const ctxCourrier = document.getElementById('courrierChart').getContext('2d');
        const courrierChart = new Chart(ctxCourrier, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Courriers par mois',
                    data: {!! json_encode($countsPerMonth) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
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
