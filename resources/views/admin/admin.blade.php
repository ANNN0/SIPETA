@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">

        <div class="main-content-wrap">
            {{-- Modern Dashboard Header --}}
            <div class="flex items-center justify-between mb-40 flex-wrap-mobile gap20"
                style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div>
                    <h2 class="mb-1" style="font-size: 1.85rem; font-weight: 700; color: #1a7a3e; letter-spacing: -0.5px;">
                        Dashboard </h2>
                    <p style="color: #777; font-size: 0.95rem; font-weight: 400;">Selamat datang kembali! Berikut adalah
                        ringkasan performa toko Anda hari ini.</p>
                </div>
                <div class="flex gap15">
                    <a href="{{ route('admin.dashboard.export') }}" class="btn-export-modern">
                        <i class="icon-download" style="font-size: 1.1rem; vertical-align: middle;"></i>
                        <span>Export Laporan PDF</span>
                    </a>
                </div>
            </div>

            <style>
                .btn-export-modern {
                    display: inline-flex;
                    align-items: center;
                    gap: 10px;
                    padding: 12px 24px;
                    background-color: #1a7a3e;
                    color: white !important;
                    border: 2px solid #1a7a3e;
                    border-radius: 10px;
                    font-weight: 600;
                    font-size: 0.95rem;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    text-decoration: none;
                    box-shadow: 0 4px 12px rgba(26, 122, 62, 0.2);
                }

                .btn-export-modern:hover {
                    background-color: transparent;
                    color: #1a7a3e !important;
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(26, 122, 62, 0.15);
                }

                .flex-wrap-mobile {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                @media (max-width: 768px) {
                    .flex-wrap-mobile {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 20px;
                    }
                }
            </style>

            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Pesanan</div>
                                        <h4>{{ $dashboardDatas[0]->Total }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-trending-up"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Pendapatan</div>
                                        <h4>Rp {{ number_format($dashboardDatas[0]->TotalAmount, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Menunggu</div>
                                        <h4>{{ $dashboardDatas[0]->TotalOrdered }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-trending-up"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Menunggu</div>
                                        <h4>Rp {{ number_format($dashboardDatas[0]->TotalOrderedAmount, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Terkirim</div>
                                        <h4>{{ $dashboardDatas[0]->TotalDelivered }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-trending-up"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Terkirim</div>
                                        <h4>Rp {{ number_format($dashboardDatas[0]->TotalDeliveredAmount, 0, ',', '.') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pesanan Dibatalkan</div>
                                        <h4>{{ $dashboardDatas[0]->TotalCanceled }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-trending-up"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Nilai Pesanan Dibatalkan</div>
                                        <h4>Rp {{ number_format($dashboardDatas[0]->TotalCanceledAmount, 0, ',', '.') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Pendapatan Bulanan</h5>
                    </div>
                    <div class="flex flex-wrap" style="gap: 10px; display: flex;">
                        <div style="min-width: 135px; flex: 1 1 auto;">
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Total</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h5 style="font-size: 16px; margin: 0; white-space: nowrap;">Rp
                                    {{ number_format($TotalAmount, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                        <div style="min-width: 135px; flex: 1 1 auto;">
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Menunggu</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h5 style="font-size: 16px; margin: 0; white-space: nowrap;">Rp
                                    {{ number_format($TotalOrderedAmount, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div style="min-width: 135px; flex: 1 1 auto;">
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Terkirim</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h5 style="font-size: 16px; margin: 0; white-space: nowrap;">Rp
                                    {{ number_format($TotalDeliveredAmount, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div style="min-width: 135px; flex: 1 1 auto;">
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Dibatalkan</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h5 style="font-size: 16px; margin: 0; white-space: nowrap;">Rp
                                    {{ number_format($TotalCanceledAmount, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Pesanan Terbaru</h5>
                        <div class="dropdown default">
                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                                <span class="view-all">Lihat Semua</span>
                            </a>
                        </div>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:70px">No. Pesanan</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Pajak</th>
                                        <th class="text-center">Total</th>

                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal Pesanan</th>
                                        <th class="text-center">Total Item</th>
                                        <th class="text-center">Dikirim Pada</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $orders->firstItem() + $loop->index }}</td>
                                            <td class="text-center">{{ $order->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                                            <td class="text-center">Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @if ($order->status == 'delivered')
                                                    <span class="badge bg-success">Terkirim</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @else
                                                    <span class="badge bg-warning">Dipesan</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->created_at }}</td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                            <td class="text-center">{{ $order->delivered_date }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn-action-dots" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="dot"></span>
                                                        <span class="dot"></span>
                                                        <span class="dot"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.order.details', ['order_id' => $order->id]) }}">
                                                                Detail
                                                            </a>
                                                        </li>
                                                        @if ($order->status != 'delivered')
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                                                                    method="POST"
                                                                    id="deleteFormDashboard{{ $order->id }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger delete">
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        <x-table-pagination :paginator="$orders" />
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        (function($) {

            var tfLineChart = (function() {

                var chartBar = function() {

                    var options = {
                        series: [{
                                name: 'Total',
                                data: [{{ $AmountM }}]
                            }, {
                                name: 'Menunggu',
                                data: [{{ $OrderedAmountM }}]
                            },
                            {
                                name: 'Terkirim',
                                data: [{{ $DeliveredAmountM }}]
                            }, {
                                name: 'Dibatalkan',
                                data: [{{ $CanceledAmountM }}]
                            }
                        ],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Oct', 'Nov', 'Dec'
                            ],
                        },
                        yaxis: {
                            show: false,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "Rp " + val.toLocaleString('id-ID')
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function() {},

                    load: function() {
                        chartBar();
                    },
                    resize: function() {},
                };
            })();

            jQuery(document).ready(function() {});

            jQuery(window).on("load", function() {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function() {});
        })(jQuery);

        // Delete confirmation for orders
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Anda ingin menghapus pesanan ini?",
                    type: "warning",
                    buttons: ["Tidak", "Ya"],
                    confirmButtonColor: "#dc3545",
                }).then(function(result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
