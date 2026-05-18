<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AdminOrdinanceController;
use App\Http\Controllers\AdminMunicipalityEventController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AdminOfficialController;
use App\Http\Controllers\MunicipalityEventController;
use App\Http\Controllers\SearchController;
use App\Models\Ordinance;
use App\Models\Official;
use App\Models\MunicipalityEvent;

require __DIR__ . '/webadmin.php';

//search route
Route::get('/search', [SearchController::class, 'index'])->name('search');






// event upload

Route::get('/events/create', function () {
    return view('admin.events.event-upload'); // Assuming your blade file is event-upload.blade.php
})->name('events.create');

Route::get('/admin/events/uploaded', [MunicipalityEventController::class, 'index'])
    ->name('admin.events.event-uploaded');



Route::get('/events-gallery', [MunicipalityEventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [MunicipalityEventController::class, 'show'])->name('events.show');

//------------------------------------------------------------------------------------









Route::get('/officials', function () {
    return view('viewer.officials');
})->name('officials');


// FIX 1: Point this directly to the index method you wrote
Route::get('/officials', [AdminOfficialController::class, 'index'])->name('officials');

// FIX 2: Add /{id} to the URL so it can catch the specific official being clicked
Route::get('/officials/profile/{id}', function ($id) {
    // findOrFail will grab the specific official, or throw a 404 error if it doesn't exist
    $official = Official::findOrFail($id);

    return view('officials.officials-personal', compact('official'));
})->name('officials.officials-personal');


//ADMIN PART IN VIEWER WHERE YOU CAN SEE THE ORDINANCES UPLOADED
Route::get('/ordinances', function (Request $request) {
    // 1. Start a fresh query
    $query = Ordinance::query();

    // 2. If the user selected a year, filter by the year of date_implemented
    if ($request->filled('year')) {
        $query->whereYear('date_implemented', $request->year);
    }

    // 3. If the user selected a month, filter by the month of date_implemented
    if ($request->filled('month')) {
        $query->whereMonth('date_implemented', $request->month);
    }

    // Add this block for the new standalone search bar:
    if (request()->has('search') && request('search') != '') {
        $searchTerm = request('search');

        // FIX: Removed the non-existent 'description' column from the search query!
        $query->where('subject', 'LIKE', '%' . $searchTerm . '%');
    }

    // 4. Get a list of all existing years dynamically for the dropdown
    // Since we are now using a full Date column, we extract just the YEAR() for the dropdown
    $availableYears = Ordinance::selectRaw('YEAR(date_implemented) as year')
        ->whereNotNull('date_implemented')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Handle the Sorting
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('date_implemented', 'asc');
                break;
            case 'title_asc': // Keeping the URL parameter name the same, but sorting by the new 'subject' column
                $query->orderBy('subject', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('subject', 'desc');
                break;
            case 'newest':
            default:
                // Default fallback: Newest first
                $query->orderBy('date_implemented', 'desc');
                break;
        }
    } else {
        // Default sorting if no option is selected
        $query->orderBy('date_implemented', 'desc');
    }

    // 5. Apply the pagination
    // (Note: Removed the hardcoded orderBy here so it respects your sort dropdown)
    $ordinances = $query->paginate(12); // Assuming 12 per page

    return view('viewer.ordinances', compact('ordinances', 'availableYears'));
})->name('ordinances');





// We add {id} to the URL so it knows which ordinance to fetch
Route::get('/ordinances/description/{id}', function ($id) {
    // findOrFail will grab the specific ordinance, or throw a 404 error if it doesn't exist
    $ordinance = Ordinance::findOrFail($id);

    return view('ordinances.ord-desc', compact('ordinance'));
})->name('ordinances.show');

//------------------------------------------------------------------------------------
Route::get('/', function () {

    // 1. Fetch the Ordinances (Your existing code)
    $ordinances = Ordinance::orderBy('date_implemented', 'desc')
        ->take(6)
        ->get();

    // 2. Fetch the Events (The new code)
    $latestEvents = MunicipalityEvent::orderBy('date', 'desc')
        ->take(9    )
        ->get();

    // 3. Pass BOTH variables to the main view
    return view('viewer.main', compact('ordinances', 'latestEvents'));

})->name('home');







Route::get('/history', function () {
    return view('viewer.history');
})->name('history');

Route::get('/history', [HistoryController::class, 'history'])->name('history');

Route::get('/events', function () {
    // 1. Fetch the events from the database
    $events = MunicipalityEvent::latest()->get();

    // 2. Pass the $events variable to the view
    return view('viewer.events', compact('events'));
})->name('events');

Route::get('/events', [MunicipalityEventController::class, 'viewerIndex'])->name('events');

// Viewer side: Single event description
Route::get('/events/details/{id}', [MunicipalityEventController::class, 'viewerShow'])
    ->name('events.events-desc');

    