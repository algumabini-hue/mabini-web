@extends('layout.layout-admin')
@section('ord-upload')

    <div class="container py-5">

        {{-- Alerts for Success/Error --}}
        @include('admin.alert-message')

        <form action="{{ route('admin.ordinances.ord-upload.store') }}" method="POST">
            @csrf

            {{-- Top Header Bar --}}
            <div class="d-flex justify-content-between align-items-center mb-5">
                <a href="{{ url()->previous() }}" class="btn btn-white border border-dark rounded fw-bold px-4 text-dark"
                    style="box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
                    BACK
                </a>

                <h4 class="mb-0 fw-bold text-secondary" style="letter-spacing: 3px;">ORDINANCE UPLOAD</h4>

                <button type="submit" class="btn fw-bold px-4 text-dark"
                    style="background-color: #6eff6e; border: 1px solid #4ade4a; box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
                    UPLOAD
                </button>
            </div>

            {{-- The Upload Grid --}}
            <div class="row g-4">
                {{-- Loop 4 times to generate the boxes --}}
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-12"> {{-- Changed to col-12 for better spacing --}}
                        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e0e0e0;">

                            {{-- Form Header --}}
                            <div class="card-header text-white text-center py-2"
                                style="background-color: #333; border-radius: 12px 12px 0 0;">
                                <h6 class="mb-0 fw-bold" style="letter-spacing: 2px;">ORDINANCE ENTRY </h6>
                            </div>

                            <div class="card-body p-4 p-md-5">

                                {{-- Section 1: Core Details --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-dark"
                                        style="font-size: 0.8rem; letter-spacing: 1px;">DATE IMPLEMENTED</label>
                                    <input type="date" name="ordinances[{{ $i }}][date_implemented]" class="form-control py-2"
                                        style="border: 1.5px solid #333; border-radius: 6px;">
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"
                                            style="font-size: 0.8rem; letter-spacing: 1px;">SUBJECT</label>
                                        {{-- Converted to textarea with resize: vertical --}}
                                        <textarea name="ordinances[{{ $i }}][subject]" class="form-control" rows="2"
                                            style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"
                                            style="font-size: 0.8rem; letter-spacing: 1px;">LEGAL BASIS</label>
                                        {{-- Converted to textarea with resize: vertical --}}
                                        <textarea name="ordinances[{{ $i }}][legal_basis]" class="form-control" rows="2"
                                            style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;"></textarea>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark"
                                        style="font-size: 0.8rem; letter-spacing: 1px;">FINDINGS AND RECOMMENDATION</label>
                                    {{-- Changed resize: none to resize: vertical and increased base rows slightly --}}
                                    <textarea name="ordinances[{{ $i }}][findings]" class="form-control" rows="4"
                                        style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;"></textarea>
                                </div>



                                <hr class="my-4" style="border-color: #ccc;">

                                {{-- Section 2: Authorship & Signatures --}}
                                <h6 class="fw-bold text-dark mb-3" style="letter-spacing: 1px;"><i
                                        class="fas fa-users pe-2"></i>AUTHORSHIP</h6>

                                <label class="form-label fw-bold text-dark mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">SIGNED BY
                                    MEMBERS</label>
                                <div class="row g-2 mb-4">
                                    @for ($m = 0; $m < 5; $m++)
                                        @php
                                            // Determine the specific role based on the loop index
                                            if ($m == 0) {
                                                $role = 'Committee Chairman';
                                            } elseif ($m == 1) {
                                                $role = 'Committee Vice-Chairman';
                                            } else {
                                                $role = 'Member ' . ($m + 1); // Outputs Member 3, Member 4, Member 5
                                            }
                                        @endphp

                                        <div class="col-md-4 col-lg-2 grow">
                                            <input type="text" name="ordinances[{{ $i }}][signed_by][{{ $m }}]" placeholder="{{ $role }}"
                                                class="form-control py-2 text-center" style="border: 1.5px solid #333; border-radius: 6px;">
                                        </div>
                                    @endfor
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark"
                                        style="font-size: 0.8rem; letter-spacing: 1px;">DRAFT RESOLUTION BY</label>
                                    <input type="text" name="ordinances[{{ $i }}][drafted_by]" class="form-control py-2"
                                        placeholder="Enter Name" style="border: 1.5px solid #333; border-radius: 6px;">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark"
                                        style="font-size: 0.8rem; letter-spacing: 1px;">ORDINANCE
                                        DESCRIPTION</label>
                                    {{-- Changed resize: none to resize: vertical and increased base rows to 8 --}}
                                    <textarea name="ordinances[{{ $i }}][description]" class="form-control" rows="8"
                                        style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;"></textarea>
                                </div>



                                <hr class="my-4" style="border-color: #ccc;">

                                {{-- Section 3: The 10 Sections --}}
                                <h6 class="fw-bold text-dark mb-3" style="letter-spacing: 1px;"><i
                                        class="fas fa-list-ol pe-2"></i>ORDINANCE SECTIONS</h6>

                                <div class="row g-3">
                                    @for ($s = 1; $s <= 10; $s++)
                                        <div class="col-md-6">
                                            <div class="p-3 h-100"
                                                style="background-color: #f8f9fa; border: 1px solid #d1d5db; border-radius: 8px;">
                                                <h6 class="fw-bold text-secondary mb-3" style="font-size: 0.85rem;">SECTION {{ $s }}
                                                </h6>

                                                <div class="mb-2">
                                                    <label class="form-label fw-bold text-dark"
                                                        style="font-size: 0.75rem;">TITLE</label>
                                                    <input type="text" name="ordinances[{{ $i }}][sections][{{ $s }}][title]"
                                                        class="form-control form-control-sm" style="border: 1px solid #9ca3af;">
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-bold text-dark"
                                                        style="font-size: 0.75rem;">DESCRIPTION</label>
                                                    {{-- Changed resize: none to resize: vertical and increased base rows to 4 --}}
                                                    <textarea name="ordinances[{{ $i }}][sections][{{ $s }}][description]"
                                                        class="form-control form-control-sm" rows="4"
                                                        style="border: 1px solid #9ca3af; resize: vertical;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </form>

        <div class="mb-4 mt-4 text-center scroll-fade-in">
            <a href="{{ route('admin.ordinances.ord-uploaded') }}" class="btn btn-outline-dark shadow-sm px-4 fw-bold ">
                <i class="fas fa-file-lines pe-3"></i> Go to Uploaded Ordinances
            </a>
        </div>
    </div>

@endsection