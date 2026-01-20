@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Dasbor Analitik</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dasbor</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Analitik</div>
                    </li>
                </ul>
            </div>

            {{-- Today's Statistics Cards --}}
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="icon-trending-up"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Pendapatan Hari Ini</h6>
                            <h3>Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="icon-shopping-cart"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Pesanan Hari Ini</h6>
                            <h3>{{ $todayOrders }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="icon-users"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Pelanggan Baru</h6>
                            <h3>{{ $newCustomersThisMonth }}</h3>
                            <small class="text-muted">Bulan ini</small>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Charts Row --}}
            <div class="row mt-5">
                <div class="col-lg-8 mb-4">
                    <div class="wg-box">
                        <h5 class="mb-3">Tren Pendapatan (30 Hari Terakhir)</h5>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="wg-box">
                        <h5 class="mb-3">Pendapatan per Kategori</h5>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Top Products Table --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="wg-box">
                        <h5 class="mb-3">Produk Terlaris</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Nama Produk</th>
                                        <th>Unit Terjual</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topProducts as $index => $product)
                                        <tr>
                                            <td><strong>#{{ $index + 1 }}</strong></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->total_sold }}</td>
                                            <td class="text-success">Rp {{ number_format($product->revenue, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Regional Sales Table --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="wg-box">
                        <h5 class="mb-3">Analitik Penjualan Regional</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Petani</th>
                                        <th>Daerah</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($regionalSales as $region)
                                        <tr>
                                            <td>{{ $region->farmer_name }}</td>
                                            <td>{{ $region->name }}</td>
                                            <td class="text-success">Rp {{ number_format($region->revenue, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Trend Line Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueTrend->pluck('date')->map(fn($date) => date('M d', strtotime($date)))) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($revenueTrend->pluck('revenue')) !!},
                    backgroundColor: 'rgba(34, 139, 34, 0.1)',
                    borderColor: 'rgba(34, 139, 34, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2.5,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Category Revenue Pie Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryRevenue->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($categoryRevenue->pluck('revenue')) !!},
                    backgroundColor: [
                        'rgba(34, 139, 34, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
