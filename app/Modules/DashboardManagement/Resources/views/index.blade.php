@extends('admin.main.app')
@section('content')
    <div class="row g-4 p-4 align-items-stretch">
        <div class="col-lg-12 col-md-12">
            <div class="amd-card shadow-sm p-4 h-100 rounded-4" style="background: #fff;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary">Summary</h6>
                    </div>
                </div>

                <div class="row g-4">
                    {{-- Total Dealers --}}
                    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                        <div class="small-card bg-pink shadow-sm rounded-3 text-center p-3 hover-card">
                            <div class="fs-3 mb-2 text-pink"><i class="fa-solid fa-store"></i></div>
                            <small class="text-muted d-block">Total Dealers</small>
                            <h4 class="fw-bold mt-2">{{ $data['dashboardData']['totalDealerCount'] ?? 0 }}</h4>
                        </div>
                    </div>

                    {{-- Total Employees --}}
                    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                        <div class="small-card bg-yellow shadow-sm rounded-3 text-center p-3 hover-card">
                            <div class="fs-3 mb-2 text-warning"><i class="fa-solid fa-user-tie"></i></div>
                            <small class="text-muted d-block">Employees</small>
                            <h4 class="fw-bold mt-2">{{ $data['dashboardData']['totalEmployees'] ?? 0 }}</h4>
                        </div>
                    </div>

                    {{-- Total Blogs --}}
                    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                        <div class="small-card bg-green shadow-sm rounded-3 text-center p-3 hover-card">
                            <div class="fs-3 mb-2 text-success"><i class="fa-solid fa-blog"></i></div>
                            <small class="text-muted d-block">Blogs</small>
                            <h4 class="fw-bold mt-2">{{ $data['dashboardData']['TotalBlog'] ?? 0 }}</h4>
                        </div>
                    </div>

                    {{-- Blog Categories --}}
                    <div class="col-xl-3 col-md-6 col-sm-6 col-12">
                        <div class="small-card bg-purple shadow-sm rounded-3 text-center p-3 hover-card">
                            <div class="fs-3 mb-2 text-purple"><i class="fa-solid fa-folder-tree"></i></div>
                            <small class="text-muted d-block">Blog Categories</small>
                            <h4 class="fw-bold mt-2">{{ $data['dashboardData']['TotalBlogCategory'] ?? 0 }}</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
