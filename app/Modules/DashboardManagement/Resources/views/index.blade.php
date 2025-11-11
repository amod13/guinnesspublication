@extends('admin.main.app')
@section('content')

        <div class="row g-4 p-4 align-items-stretch">
            <div class="col-lg-7 col-md-12">
                <div class="amd-card shadow-sm p-4 h-100 rounded-4" style="background: #fff;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="mb-1 fw-bold text-primary">Dashboard</h6>
                            <small class="text-muted">Summary</small>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                            <div class="small-card bg-pink shadow-sm rounded-3 text-center p-3 hover-card">
                                <div class="fs-3 mb-2 text-pink"><i class="fa-solid fa-chart-line"></i></div>
                                <small class="text-muted d-block">Total Sales</small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                            <div class="small-card bg-yellow shadow-sm rounded-3 text-center p-3 hover-card">
                                <div class="fs-3 mb-2 text-warning"><i class="fa-solid fa-receipt"></i></div>
                                <small class="text-muted d-block">Total Orders</small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                            <div class="small-card bg-green shadow-sm rounded-3 text-center p-3 hover-card">
                                <div class="fs-3 mb-2 text-success"><i class="fa-solid fa-check-circle"></i></div>
                                <small class="text-muted d-block">Product Sold</small>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                            <div class="small-card bg-purple shadow-sm rounded-3 text-center p-3 hover-card">
                                <div class="fs-3 mb-2 text-purple"><i class="fa-solid fa-users"></i></div>
                                <small class="text-muted d-block">Customers</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="card shadow-sm bg-white rounded-4 p-3 h-100">
                    <h6 class="fw-bold mb-2">Visitor Insights</h6>
                    <canvas id="visitorChart" height="140"></canvas>
                    <div
                        class="d-flex flex-wrap justify-content-center justify-content-md-around text-muted mt-2 small gap-2">
                        <span class="text-purple">🟣 Loyal Customers</span>
                        <span class="text-danger">🔴 New Customers</span>
                        <span class="text-success">🟢 Unique Customers</span>
                    </div>
                </div>
            </div>
        </div>

    @endsection
