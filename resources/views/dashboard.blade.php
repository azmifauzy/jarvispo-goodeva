@extends('main')

@section('content')
    <!-- *************************************************************** -->
    <!-- Start First Cards -->
    <!-- *************************************************************** -->
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $poDone }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Done Purchase</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-danger"><i class="fas fa-clipboard-check"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">{{ $poInProgress }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">In Progress Purchase</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-cyan">
                            <i data-feather="sliders"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $poAlltime->count() }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Purchase All of Time</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-warning">
                            <i class="fas fa-archive"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup class="set-doller">Rp</sup>{{ number_format($profits) }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Profit All of Time
                        </h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row d-flex">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <canvas id="purchasesChart" width="100%" height="50%"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <canvas id="rpmPurchasesChart" width="100%" height="50%"></canvas>
                    </div>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between">
                            <h5>Purchases</h5>
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalImportExcel">
                                    <i class="fas fa-upload"></i> Import Excel
                                </button>
                                <a href="/purchases/exports" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Export Excel
                                </a>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </button>
                            </div>
                            <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data PO</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-success d-none" role="alert"></div>
                                            <form action="/purchases" method="post" class="mt-3">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="no_purchase">No. Purchase</label>
                                                            <input type="text" class="form-control" name="no_purchase" placeholder="Enter No. Purchase">
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="customer">Customer</label>
                                                            <input type="text" class="form-control" name="customer" placeholder="Enter Customer Name">
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="type">Type</label>
                                                            <select name="type" class="form-control" id="">
                                                                <option value="In Order">In Order</option>
                                                                <option value="Out Order">Out Order</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="order_title">Order Title</label>
                                                            <input type="text" class="form-control" name="order_title" placeholder="Enter Order Title">
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="status">Status</label>
                                                            <select name="status" class="form-control" id="">
                                                                <option value="In Progress">In Progress</option>
                                                                <option value="Done">Done</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="category">Category</label>
                                                            <select name="category" class="form-control" id="">
                                                                <option value="Service">Service</option>
                                                                <option value="Outsource">Outsource</option>
                                                                <option value="Product">Product</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="total_price">Total Price</label>
                                                            <input type="number" class="form-control" name="total_price" placeholder="Enter Total Price">
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="deadline">Deadline</label>
                                                            <input type="date" class="form-control" name="deadline">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary">Add</button>
                                                            <button type="button" class="btn btn-danger ml-1" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalImportExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-success d-none" role="alert"></div>
                                            <form action="/purchases/imports" method="post" class="mt-3" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-between">
                                                                <label for="">File (.csv, .xls, .xlsx) :</label>
                                                                <a href="/purchases/import_excel">Lihat Data Import</a>
                                                            </div>
                                                            <input type="file" class="form-control" name="excel" placeholder="Enter Category">
                                                            <small class="text-danger" id="textDangerCategory"></small>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary">Import</button>
                                                            <button type="button" class="btn btn-danger ml-1" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Order Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($poAlltime as $purchase)
                                        <tr>
                                            <td>{{ $purchase->customer }}</td>
                                            <td><a href="/purchases/{{ $purchase->id }}" class="font-weight-medium link">{{ $purchase->order_title }}</a></td>
                                            <td class="text-primary">
                                                @if ($purchase->status === "In Progress")
                                                    <span class="badge badge-warning">{{ $purchase->status }}</span>
                                                @else
                                                    <span class="badge badge-success">{{ $purchase->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/purchases/{{ $purchase->id }}/edit" class="btn btn-primary">Edit</a>
                                                <form action="/purchases/{{ $purchase->id }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger mr-2" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="reimbursesChart" width="100%" height="50%"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <canvas id="halfCircleChart" width="400" height="400"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Login Info</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="id" required value="Azmi" disabled>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="id" required value="Direktur" disabled>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="id" required value="Jl. Jalan" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- dataTable --}}
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
<script>
    $(document).ready(async function() {
        showPurchasesChart()
        showPurchaseByCategory()
        showRpmPurchasesChart()
        showHalfCircleChart()
    });

    let colorz = [
        '#003f5c',
        '#2f4b7c',
        '#665191',
        '#a05195',
        '#d45087',
        '#f95d6a',
        '#ff7c43',
        '#ffa600',
        '#003f5c',
        '#2f4b7c',
        '#665191',
        '#a05195',
        '#d45087',
        '#f95d6a',
        '#ff7c43',
        '#ffa600',
    ];

    async function showHalfCircleChart() {
        const dataStatistik = await getStatistik()
        console.log(dataStatistik.purchaseHalfCircle)
        var data = {
            labels: Object.keys(dataStatistik.purchaseHalfCircle),
            datasets: [
                {
                    data: Object.values(dataStatistik.purchaseHalfCircle),
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ]
                }]
        };

        var ctx = document.getElementById("halfCircleChart");

        // And for a doughnut chart
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                rotation: -90,
                circumference: 180,
            }
        });
    }

    async function showPurchasesChart() {
        const nowYear = new Date()
        const dataStatistik = await getStatistik()
        const ctx = document.getElementById('purchasesChart');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(dataStatistik.purchasesStatistik),
                datasets: [{
                    label: `Purchases All of Time`,
                    data: Object.values(dataStatistik.purchasesStatistik),
                    backgroundColor: colorz,
                    borderColor: colorz,
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
    }

    async function showPurchaseByCategory() {
        const dataStatistik = await getStatistik()
        const data = {
            labels: Object.keys(dataStatistik.purchaseByCategory),
            datasets: [{
                data: Object.values(dataStatistik.purchaseByCategory),
                backgroundColor: colorz,
                hoverOffset: 4
            }]
        };
        const reimbursesChart = document.getElementById('reimbursesChart');
        const theChart = new Chart(reimbursesChart, {
            type: 'pie',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Purchases By Category',
                    }
                }
            }
        });
    }

    async function showRpmPurchasesChart() 
    {
        const dataStatistik = await getStatistik()
        const data = {
            labels: Object.keys(dataStatistik.rpmData.rpm_month),
            datasets: [
                {
                label: 'Purchase In',
                data: Object.values(dataStatistik.rpmData.in),
                borderColor: '#ffa600',
                backgroundColor: '#ffa600',
                },
                {
                label: 'Purchase Out',
                data: Object.values(dataStatistik.rpmData.out),
                borderColor: '#a05195',
                backgroundColor: '#a05195',
                }
            ]
        };
    
        const config = {
            type: 'line',
            data: data,
            options: {}
        };
        rpmPurchasesChart = new Chart(
            document.getElementById('rpmPurchasesChart'),
            config
        );
    }


    async function getStatistik() {
        const result = await fetch(`/statistics`).then(res => res.json()).then(data => data);
        return result;
    }
</script>
