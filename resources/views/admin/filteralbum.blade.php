{{-- Reusable Filter Form for Municipality Albums --}}
<div class="card shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <h5 class="mb-3">Filter Events</h5>
        <form method="GET" action="{{ route('municipality.uploaded') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search Title</label>
                <input type="text" name="title" class="form-control border-dark"
                    placeholder="Search event title..." value="{{ $title ?? '' }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control border-dark" value="{{ $startDate ?? '' }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control border-dark" value="{{ $endDate ?? '' }}">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <div class="mt-2">
            <a href="{{ route('municipality.uploaded') }}" class="btn btn-outline-secondary btn-sm">Clear Filters</a>
        </div>
    </div>
</div>

