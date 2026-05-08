@extends('layout.layout-admin')
@section('ord-description')

    <div class="container-fluid py-5 px-md-5 min-vh-100 ordinance-typography">
        <div class="row justify-content-center ">
            <div class="col-12">

                {{-- Back Button --}}
                <div class="mb-4 text-start">
                    <a href="{{ route('admin.ordinances.ord-uploaded') }}"
                        class="btn btn-outline-dark shadow-sm px-4 fw-bold">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back
                    </a>
                </div>

                {{-- Main Document Card --}}
                <div class="ordinance-document mb-5 p-4 p-md-5 shadow-soft rounded bg-white">

                    {{-- Admin Action Buttons (Edit/Delete) --}}
                    <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                        <a href="{{ route('admin.ord-uploaded.ord-edit', $ordinance->id) }}"
                            class="btn btn-sm btn-primary me-1 shadow-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.ord-upload.destroy', $ordinance->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                onclick="return confirm('Are you sure you want to delete this ordinance?')">
                                Delete
                            </button>
                        </form>
                    </div>

                    <div class="ordinance-content">

                        {{-- Header: Logo & Committee Text --}}
                        <div class="container-fluid d-flex align-items-center justify-content-center mb-5">
                            <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="img-fluid me-4 w-100"
                                style="max-width: 150px;">

                            {{-- Replaced inline styles with .committee-header --}}
                            <div class="d-flex flex-column text-center committee-header">
                                <span>COMMITTEE ON JUSTICE HUMAN RIGHTS,</span>
                                <span>LAWS AND ORDINANCES</span>
                            </div>
                        </div>

                        {{-- DATE IMPLEMENTED --}}
                        <div class="text-end mb-5 fw-bold text-uppercase" style="font-size: 1.1rem; letter-spacing: 1px;">
                            {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'DATE NOT SPECIFIED' }}
                        </div>

                        {{-- SUBJECT --}}
                        @if(!empty($ordinance->subject))
                            <div class="mb-4">
                                <h5 class="fw-bold text-uppercase mb-2">SUBJECT:</h5>
                                <p class="ordinance-title text-uppercase ps-md-5 mb-0">
                                    {!! nl2br(e($ordinance->subject)) !!}
                                </p>
                            </div>
                        @endif

                        {{-- LEGAL BASIS --}}
                        @if(!empty($ordinance->legal_basis))
                            <div class="mb-4">
                                <h5 class="fw-bold text-uppercase mb-2">LEGAL BASIS:</h5>
                                <p class="ordinance-body text-uppercase ps-md-5 mb-0">
                                    {!! nl2br(e($ordinance->legal_basis)) !!}
                                </p>
                            </div>
                        @endif

                        {{-- FINDINGS AND RECOMMENDATION --}}
                        @if(!empty($ordinance->findings))
                            <div class="mb-5">
                                <h5 class="fw-bold text-uppercase mb-2">Findings and Recommendation :</h5>
                                <p class="ordinance-body text-uppercase mb-0">
                                    {!! nl2br(e($ordinance->findings)) !!}
                                </p>
                            </div>
                        @endif

                        {{-- DRAFTED BY --}}
                        @if(!empty($ordinance->drafted_by))
                            <div class="mb-4">
                                <h5 class="fw-bold mb-2 text-uppercase" style="font-size: 1.1rem;">Draft Resolution by
                                    {{ $ordinance->drafted_by }}
                                </h5>
                            </div>
                        @endif

                        {{-- MAIN ORDINANCE DESCRIPTION --}}
                        @if(!empty($ordinance->description))
                            <div class="ordinance-body mb-5">
                                <p class="mb-0 text-uppercase">
                                    {!! nl2br(e($ordinance->description)) !!}
                                </p>
                            </div>
                        @endif

                        {{-- SECTIONS --}}
                        @if(!empty($ordinance->sections) && is_array($ordinance->sections))
                            <div class="ordinance-sections mb-5">
                                @foreach($ordinance->sections as $index => $section)
                                    @if(!empty($section['title']) || !empty($section['description']))
                                        <div class="mb-4">
                                            <h6 class="fw-bold text-uppercase mb-2" style="font-size: 1.1rem;">
                                                SECTION {{ $index }}. {{ $section['title'] ?? '' }}
                                            </h6>
                                            <p class="ordinance-body text-uppercase mb-0">
                                                {!! nl2br(e($section['description'] ?? '')) !!}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- SIGNATURES BLOCK --}}
                        @if(!empty($ordinance->signed_by) && is_array($ordinance->signed_by))
                            <div class="mt-5 pt-5">

                                {{-- Top Row: Chairman and Vice-Chairman --}}
                                <div class="row g-4 text-center justify-content-between mb-5">
                                    @foreach($ordinance->signed_by as $index => $member)
                                        @if(!empty($member) && $index < 2)
                                            <div class="col-md-5">
                                                <div class="mt-4">
                                                    {{-- Replaced inline underline with .signature-name --}}
                                                    <h6 class="fw-bold text-uppercase mb-0 signature-name">
                                                        HON. {{ $member }}
                                                    </h6>
                                                    <p class="fw-bold text-uppercase mt-2 mb-0" style="font-size: 0.85rem;">
                                                        {{ $index == 0 ? 'COMMITTEE CHAIRMAN' : 'COMMITTEE VICE-CHAIRMAN' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                @php
                                    $hasMembers = false;
                                    foreach ($ordinance->signed_by as $index => $member) {
                                        if ($index >= 2 && !empty($member))
                                            $hasMembers = true;
                                    }
                                @endphp

                                {{-- Bottom Row: Regular Members --}}
                                @if($hasMembers)
                                    <h6 class="fw-bold text-center mb-4 text-uppercase">MEMBERS</h6>

                                    <div class="row g-4 text-center justify-content-center">
                                        @foreach($ordinance->signed_by as $index => $member)
                                            @if(!empty($member) && $index >= 2)
                                                <div class="col-md-4 col-lg-4 grow">
                                                    <div class="mt-2">
                                                        {{-- Replaced inline underline with .signature-name --}}
                                                        <h6 class="fw-bold text-uppercase mb-0 signature-name">
                                                            HON. {{ $member }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection