{{-- The Filter Form --}}
<form action="{{ url()->current() }}" method="GET" class="mb-5 scroll-fade-in">
    <div class="row g-3 align-items-end">

        {{-- Year Dropdown --}}
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark" style="font-size: 0.85rem; letter-spacing: 1px;">FILTER BY
                YEAR</label>
            <select name="year" class="form-select py-2 shadow-sm"
                style="border: 1.5px solid #e0e0e0; border-radius: 8px;">
                <option value="">All Years</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Month Dropdown --}}
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark" style="font-size: 0.85rem; letter-spacing: 1px;">FILTER BY
                MONTH</label>
            <select name="month" class="form-select py-2 shadow-sm"
                style="border: 1.5px solid #e0e0e0; border-radius: 8px;">
                <option value="">All Months</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sort Dropdown --}}
        <div class="col-md-3">
            <label class="form-label fw-bold text-dark" style="font-size: 0.85rem; letter-spacing: 1px;">SORT BY</label>
            <select name="sort" class="form-select py-2 shadow-sm"
                style="border: 1.5px solid #e0e0e0; border-radius: 8px;">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="col-md-3">
            <button type="submit" class="btn text-white fw-bold px-4 py-2 shadow-sm w-100 mb-2"
                style="background-color: #198754; border-radius: 8px;">
                <i class="fas fa-filter pe-2"></i> Apply
            </button>
            <a href="{{ url()->current() }}"
                class="btn btn-white text-dark fw-bold px-4 py-2 shadow-sm w-100"
                style="border: 1.5px solid #e0e0e0; border-radius: 8px;">
                Clear
            </a>
        </div>

    </div>
</form>