
@include('layout.page-header', [
    'title' => 'MUNICIPAL OFFICIALS',
    'bgImage' => 'images/councilors.png'
])

<div class="container-fluid px-4 px-xl-5 scroll-fade-in mb-5 mt-5">


    {{-- THE FRAMED WRAPPER: Applying the white envelope & watermark --}}
    <div class="officials-watermark-wrapper border border-2 rounded-4 p-4 p-md-5 bg-white shadow-sm position-relative">

        <div class="container-fluid d-flex align-items-center justify-content-center mb-5 px-3">
        
            {{-- The Left Logo (Bayan ng Mabini) --}}
            {{-- Added flex-shrink-0 so the flexbox never squishes it --}}
            <img src="{{ asset('/images/logo.png') }}" alt="Bayan ng Mabini Logo" class="img-fluid me-3 me-md-5 shrink-0"
                style="width: 140px; height: 140px; object-fit: contain;">
        
            {{-- The Text Block --}}
            <div class="d-flex flex-column text-center officials-header">
                
                <span class="brand-text-sm">Republic of the Philippines</span>
                <span class="brand-text-md fw-bold">PROVINCE OF PANGASINAN</span>
                <span class="brand-text-lg fw-bolder">MUNICIPALITY OF MABINI</span>
            
            </div>
        
            {{-- The Right Logo (Sangguniang Bayan) --}}
            {{-- 1. Added flex-shrink-0 --}}
            {{-- 2. Added transform: scale(1.2) to zoom past the invisible transparent padding in the file! --}}
            <img src="{{ asset('/images/sb.png') }}" alt="Sangguniang Bayan Logo" class="img-fluid ms-3 ms-md-5 shrink-0"
                style="width: 140px; height: 140px; object-fit: contain; transform: scale(1.11);">
        
        </div>

        {{-- Z-index wrapper to ensure the profiles sit ABOVE the faint background watermark --}}
        <div class="position-relative z-1 pt-4">

            {{-- MAYOR --}}
            @if(isset($officials['mayor']) && $officials['mayor']->name)
            <div class="row justify-content-center mb-5 scroll-fade-in">
                <div class="col-12 text-center scroll-fade-in">
                    <a href="{{ route('officials.officials-personal', $officials['mayor']->id) }}" class="profile-link">
                        <div class="profile-img-container scroll-fade-in">
                            <img src="{{ $officials['mayor']->photo_path ? asset($officials['mayor']->photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $officials['mayor']->name }}" 
                                 class="profile-img mx-auto" style="object-fit: cover;">
                        </div>
                        <h3 class="profile-name mt-3 scroll-fade-in text-uppercase">HON. {{ $officials['mayor']->name }}</h3>
                        <p class="profile-position scroll-fade-in text-uppercase">{{ $officials['mayor']->position ?? 'MUNICIPAL MAYOR' }}</p>
                    </a>
                </div>
            </div>
            @endif

            {{-- VICE MAYOR --}}
            @if(isset($officials['vice_mayor']) && $officials['vice_mayor']->name)
            <div class="row justify-content-center mb-5 scroll-fade-in">
                <div class="col-12 text-center scroll-fade-in">
                    <a href="{{ route('officials.officials-personal', $officials['vice_mayor']->id) }}" class="profile-link">
                        <div class="profile-img-container scroll-fade-in">
                            <img src="{{ $officials['vice_mayor']->photo_path ? asset($officials['vice_mayor']->photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $officials['vice_mayor']->name }}" 
                                 class="profile-img mx-auto" style="object-fit: cover;">
                        </div>
                        <h3 class="profile-name mt-3 scroll-fade-in text-uppercase">HON. {{ $officials['vice_mayor']->name }}</h3>
                        <p class="profile-position scroll-fade-in text-uppercase">{{ $officials['vice_mayor']->position ?? 'MUNICIPAL VICE MAYOR' }}</p>
                    </a>
                </div>
            </div>
            @endif

            {{-- COUNCILORS (Loops through 1 to 8) --}}
            {{-- ========================================== --}}
            {{-- SKF, ABC, AND SB SECRETARY ROW             --}}
            {{-- ========================================== --}}
            <div class="row justify-content-center g-5 mt-2 scroll-fade-in">
                
                {{-- SK FEDERATION PRESIDENT --}}
                @if(isset($officials['skf']) && $officials['skf']->name)
                <div class="col-12 col-md-4 text-center scroll-fade-in">
                    <a href="{{ route('officials.officials-personal', $officials['skf']->id) }}" class="profile-link">
                        <div class="profile-img-container">
                            <img src="{{ $officials['skf']->photo_path ? asset($officials['skf']->photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $officials['skf']->name }}" 
                                 class="profile-img mx-auto" style="object-fit: cover;">
                        </div>
                        <h3 class="profile-name mt-3 text-uppercase">HON. {{ $officials['skf']->name }}</h3>
                        <p class="profile-position text-uppercase">{{ $officials['skf']->position ?? 'SKF PRESIDENT' }}</p>
                    </a>
                </div>
                @endif

                {{-- ABC PRESIDENT --}}
                @if(isset($officials['abc']) && $officials['abc']->name)
                <div class="col-12 col-md-4 text-center scroll-fade-in">
                    <a href="{{ route('officials.officials-personal', $officials['abc']->id) }}" class="profile-link">
                        <div class="profile-img-container">
                            <img src="{{ $officials['abc']->photo_path ? asset($officials['abc']->photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $officials['abc']->name }}" 
                                 class="profile-img mx-auto" style="object-fit: cover;">
                        </div>
                        <h3 class="profile-name mt-3 text-uppercase">HON. {{ $officials['abc']->name }}</h3>
                        <p class="profile-position text-uppercase">{{ $officials['abc']->position ?? 'ABC PRESIDENT' }}</p>
                    </a>
                </div>
                @endif

                {{-- SB SECRETARY --}}
                @if(isset($officials['sbsec']) && $officials['sbsec']->name)
                <div class="col-12 col-md-4 text-center scroll-fade-in">
                    <a href="{{ route('officials.officials-personal', $officials['sbsec']->id) }}" class="profile-link">
                        <div class="profile-img-container">
                            <img src="{{ $officials['sbsec']->photo_path ? asset($officials['sbsec']->photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $officials['sbsec']->name }}" 
                                 class="profile-img mx-auto" style="object-fit: cover;">
                        </div>
                        <h3 class="profile-name mt-3 text-uppercase">{{ $officials['sbsec']->name }}</h3>
                        <p class="profile-position text-uppercase">{{ $officials['sbsec']->position ?? 'SB SECRETARY' }}</p>
                    </a>
                </div>
                @endif

            </div>

        </div> {{-- End Z-1 Wrapper --}}

    </div> {{-- End of Framed Wrapper --}}

</div>