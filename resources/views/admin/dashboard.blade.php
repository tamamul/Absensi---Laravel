@extends('layouts.master')
@section('title', 'atlantis')
@section('content')

    <div class="container py-4">
        <h1 class="mb-4 fw-bold text-primary">Welcome Admin!</h1>
        {{-- <div class="container ms-4 mb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger btn-sm" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div> --}}

        <div class="row g-4 mt-2">
            <div class="col-md-3">
                <div class="card shadow border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <span
                                class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center"
                                style="width:48px; height:48px; font-size:1.5rem;">
                                <i class="bi bi-person-badge"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold text-secondary">Total Satpam</div>
                            <div class="display-6 fw-bold text-primary">{{ $totalSatpam }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <span
                                class="rounded-circle bg-success bg-gradient text-white d-flex align-items-center justify-content-center"
                                style="width:48px; height:48px; font-size:1.5rem;">
                                <i class="bi bi-building"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold text-secondary">Total UPT</div>
                            <div class="display-6 fw-bold text-success">{{ $totalUpt }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <span
                                class="rounded-circle bg-info bg-gradient text-white d-flex align-items-center justify-content-center"
                                style="width:48px; height:48px; font-size:1.5rem;">
                                <i class="bi bi-diagram-3"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold text-secondary">Total ULTG</div>
                            <div class="display-6 fw-bold text-info">{{ $totalUltg }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <span
                                class="rounded-circle bg-warning bg-gradient text-white d-flex align-items-center justify-content-center"
                                style="width:48px; height:48px; font-size:1.5rem;">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold text-secondary">Total Lokasi Kerja</div>
                            <div class="display-6 fw-bold text-warning">{{ $totalLoker }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card .display-6 {
            font-size: 2.2rem;
        }

        .card .fw-semibold {
            font-size: 1rem;
        }
    </style>
@endsection
