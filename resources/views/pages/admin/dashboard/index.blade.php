@extends('layouts.admin.dashboard')



@section('content')

           

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Projects</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Projects</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row project-wrapper">
                            <div class="col-xxl-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                            <i class="ri-user-3-line text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">NEW USERS</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="825">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
                                                            <i class="ri-group-line text-warning"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="text-uppercase fw-medium text-muted mb-0">TOTAL USERS</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="7522">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i class="ri-car-fill
                                                            text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">NEW TRIP</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-danger text-danger rounded-2 fs-2">
                                                            <i class="ri-map-pin-time-line text-danger"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">COMPLETED TRIP</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
                                                            <i class="ri-money-dollar-circle-line text-success"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">TOTAL EARNING</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->
                                    
                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-success text-success rounded-2 fs-2">
                                                            <i class="ri-money-dollar-circle-line text-success"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">EARNING THIS MONTH</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-dark text-dark rounded-2 fs-2">
                                                            <i class="ri-flight-takeoff-line text-dark"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">NEW TRIP INQUIRY</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-dark text-dark rounded-2 fs-2">
                                                            <i class="ri-hotel-line
                                                            text-dark"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">NEW PACKAGE INQUIRY</p>
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="1500">0</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                </div><!-- end row -->

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Monthly Enquiries</h4>
                                            </div><!-- end card header -->

                                            
                                            <div class="card-body p-0 pb-2">
                                                <div>
                                                    <div id="projects-overview-chart" data-colors='["--vz-primary", "--vz-warning", "--vz-success"]' class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div><!-- end col -->

                            
                        </div><!-- end row -->

                        
                    </div>  
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

      @stop          
           

      @section('javascript')

      <!-- apexcharts -->
      <script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>
      <!-- projects js -->
      <script src="{{ asset('admin/js/pages/dashboard-projects.init.js') }}"></script>

      @stop