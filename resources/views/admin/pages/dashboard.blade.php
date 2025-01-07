@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

    <div class="col-lg-12">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Overview</h5>
                </div>
            </div>
            <div class="card-body pt-lg-10">
                <div class="row g-6">
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-primary rounded shadow-xs">
                                    <i class="ri-user-line ri-24px"></i> <!-- Accounts icon -->
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0">Accounts</p>
                                <h5 class="mb-0">245k</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-success rounded shadow-xs">
                                    <i class="ri-user-heart-line ri-24px"></i> <!-- Patients icon -->
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0">Patients</p>
                                <h5 class="mb-0">12.5k</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar">
                                <div class="avatar-initial bg-warning rounded shadow-xs">
                                    <i class="ri-calendar-line ri-24px"></i> <!-- Appointments icon -->
                                </div>
                            </div>
                            <div class="ms-3">
                                <p class="mb-0">Appointments</p>
                                <h5 class="mb-0">1.54k</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
