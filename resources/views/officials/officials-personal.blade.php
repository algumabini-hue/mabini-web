@extends('layout.master')
@section('officials')

    <div class="officials-typography">
        {{-- custom-header.css --}}
        <header class="custom-hero-section scroll-fade-in" style="background-image: url('{{ asset('images/bg.jpg') }}');">
            <div class="custom-hero-overlay"></div>

            <div class="container custom-hero-content scroll-fade-in">
                <div class="row justify-content-center text-center scroll-fade-in">
                    <div class="col-12 col-md-10 col-lg-8 py-5">

                        {{-- DYNAMIC POSITION HEADER --}}
                        <h1 class="custom-hero-title display-4 fw-bold text-white text-shadow text-uppercase">
                            {{ str_contains(strtolower($official->position_key), 'councilor') ? 'Councilor' : ($official->position ?? 'Municipal Official') }}
                        </h1>
                        <h2 class="display-6 fw-bold text-white text-shadow text-uppercase">TERM 2025 - 2028</h2>

                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid py-5 px-md-5 min-vh-100 scroll-fade-in">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">

                    <div class="mb-4 text-start scroll-fade-in">
                        <a href="{{ route('officials') }}"
                            class="btn btn-outline-dark shadow-sm px-4 fw-bold text-uppercase">
                            <i class="fa-solid fa-arrow-left me-2 scroll-fade-in"></i> Back to Officials
                        </a>
                    </div>

                    {{-- Added bg-white, rounded, and shadow-soft to match your clean document styling --}}
                    <div class="personal-info-container mb-5 scroll-fade-in bg-white shadow-soft rounded p-4 p-md-5">
                        <div class="personal-info-content">

                            <div class="text-center mb-5">
                                {{-- DYNAMIC NAME --}}
                                <h1 class="profile-header-name text-uppercase mb-0 scroll-fade-in fw-bold">
                                    HON. {{ $official->name }}
                                </h1>
                            </div>

                            <div class="row mb-5 align-items-start">

                                <div class="col-12 col-md-5 col-lg-4 text-center text-md-start mb-4 mb-md-0 scroll-fade-in">
                                    {{-- DYNAMIC IMAGE WITH FALLBACK --}}
                                    <img src="{{ $official->photo_path ? asset($official->photo_path) : asset('images/default-avatar.png') }}"
                                        alt="Hon. {{ $official->name }}"
                                        class="official-portrait img-fluid rounded border shadow-sm"
                                        style="max-height: 400px; object-fit: cover; width: 100%;">
                                </div>

                                <div class="col-12 col-md-7 col-lg-8 ps-md-4 pt-md-2">
                                    <h5
                                        class="info-section-title text-uppercase mb-4 scroll-fade-in fw-bold border-bottom pb-2">
                                        Personal Information</h5>

                                    {{-- DYNAMIC FIELDS --}}
                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Position/Office:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ str_contains(strtolower($official->position_key), 'councilor') ? 'Councilor' : ($official->position ?? 'N/A') }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Department/Committee:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ $official->department ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Date of Birth:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ $official->dob ? \Carbon\Carbon::parse($official->dob)->format('F d, Y') : 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Place of Birth:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ $official->pob ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Civil Status:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ $official->civil_status ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div
                                            class="col-sm-5 col-md-6 col-lg-4 info-label scroll-fade-in fw-bold text-uppercase">
                                            Citizenship:</div>
                                        <div class="col-sm-7 col-md-6 col-lg-8 info-value scroll-fade-in text-uppercase">
                                            {{ $official->citizenship ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- DYNAMIC BIO/DESCRIPTION --}}
                            @if($official->description)
                                <div class="official-bio-text mt-4 border-top pt-4 scroll-fade-in">
                                    <h5 class="info-section-title text-uppercase mb-4 fw-bold">Description / Biography</h5>

                                    {{-- Uses nl2br to respect line breaks from the admin text area --}}
                                    <p class="scroll-fade-in text-uppercase" style="line-height: 1.8; text-align: justify;">
                                        {!! nl2br(e($official->description)) !!}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection