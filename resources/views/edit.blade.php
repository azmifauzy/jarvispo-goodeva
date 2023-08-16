@extends('main')

@section('content')

    <div class="container">
        <div class="row d-flex">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-none" role="alert"></div>
                        <form action="/purchases/{{ $purchase->id }}" method="post" class="mt-3">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="no_purchase">No. Purchase</label>
                                        <input type="text" class="form-control" name="no_purchase" placeholder="Enter No. Purchase" value="{{ $purchase->no_purchase }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="customer">Customer</label>
                                        <input type="text" class="form-control" name="customer" placeholder="Enter Customer Name" value="{{ $purchase->customer }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control" id="">
                                            @if ($purchase->type === "In Order")
                                            <option value="In Order" selected>In Order</option>
                                            <option value="Out Order">Out Order</option>
                                            @else 
                                            <option value="Out Order" selected>Out Order</option>
                                            <option value="In Order">In Order</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="order_title">Order Title</label>
                                        <input type="text" class="form-control" name="order_title" placeholder="Enter Order Title" value="{{ $purchase->order_title }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control">
                                            @if ($purchase->status === "In Progress")
                                                <option value="In Progress" selected>In Progress</option>
                                                <option value="Done">Done</option>
                                            @else    
                                                <option value="Done" selected>Done</option>
                                                <option value="In Progress">In Progress</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="category">Category</label>
                                        <select name="category" class="form-control">
                                            
                                            @if ($purchase->category === "Service")
                                                <option value="Service" selected>Service</option>
                                                <option value="Outsource">Outsource</option>
                                                <option value="Product">Product</option>
                                            @elseif ($purchase->category === "Outsource")
                                                <option value="Service" selected>Service</option>
                                                <option value="Outsource" selected>Outsource</option>
                                                <option value="Product">Product</option>
                                            @else 
                                                <option value="Service" selected>Service</option>
                                                <option value="Outsource">Outsource</option>
                                                <option value="Product" selected>Product</option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="total_price">Total Price</label>
                                        @php
                                            $totalPrices = 0;
                                            $total_price = explode('.', $purchase->total_price)[1];
                                            $stringTotalPrice = explode(',', $total_price);
                                            $totalPrice = '';
                                            for ($i=0; $i < count($stringTotalPrice); $i++) { 
                                                $totalPrice .= $stringTotalPrice[$i];
                                            }
                                            $totalPrices += (int) $totalPrice;
                                        @endphp
                                        <input type="number" class="form-control" name="total_price" placeholder="Enter Total Price" value="{{ $totalPrices }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="deadline">Deadline</label>
                                        <input type="date" class="form-control" name="deadline" value="{{ $purchase->deadline }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-danger ml-1" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
