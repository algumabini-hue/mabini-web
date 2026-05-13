<?php

use App\Http\Controllers\AdminOfficialController;
use App\Http\Controllers\AdminOrdinanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MunicipalityEventController;
use App\Http\Controllers\AdminMunicipalityEventController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SearchController;
use App\Models\MunicipalityEvent;
use App\Http\Controllers\OrdinanceController;
use App\Models\Ordinance;
use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/login', function () {
    return view('admin.login'); // <-- Added 'admin.' here
})->name('login');

Route::get('/ord-uploaded/description/{id}', function ($id) {
    $ordinance = Ordinance::findOrFail($id);
    return view('admin.panel.ordinance.ord-description', compact('ordinance'));
});

// ---signup---//
Route::get('/signup', [SignupController::class, 'signup'])->name('signup');
Route::post('/signup', [SignupController::class, 'store']);

// ---login---//
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// ---logout---//
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ---dashboard---//
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// ---municipality---//
Route::post('/events', [AdminMunicipalityEventController::class, 'store'])->name('events.store');
Route::post('/events/upload-temp', [App\Http\Controllers\AdminMunicipalityEventController::class, 'uploadTemp'])->name('events.upload-temp');

Route::get('/municipality', [DashboardController::class, 'municipality'])->middleware('auth')->name('municipality');
Route::post('/municipality/store', [AdminMunicipalityEventController::class, 'store'])->middleware('auth')->name('municipality.store');
Route::get('/municipality/uploaded', [AdminMunicipalityEventController::class, 'uploaded'])->middleware('auth')->name('municipality.uploaded');
Route::get('/municipality/{event}/edit', [AdminMunicipalityEventController::class, 'edit'])->middleware('auth')->name('municipality.edit');
Route::put('/municipality/{event}', [AdminMunicipalityEventController::class, 'update'])->middleware('auth')->name('municipality.update');
Route::delete('/municipality/{event}', [AdminMunicipalityEventController::class, 'destroy'])->middleware('auth')->name('municipality.destroy');

// API endpoint for fetching event details
Route::get('/api/municipality-events/{event}', [MunicipalityEventController::class, 'show'])->middleware('auth');

// ==========================================
// ---ORDINANCES----
// ==========================================

// Viewer Page (Short URL: /ordinances)
Route::get('/ordinances', [DashboardController::class, 'ordinances'])->middleware('auth')->name('ordinances');

// ==========================================================
// SECURE ADMIN ROUTE GROUP
// All routes inside this block require the user to be logged in.
// ==========================================================
Route::middleware(['auth'])->group(function () {

    // ==========================================
    // --- ORDINANCES ---
    // ==========================================

    // The Upload Form (Short URL: /ord-upload)
    Route::get('/ord-upload', function () {
        return view('admin.panel.ordinance.ord-upload');
    })->name('ordinance');

    // Saving the Upload (Hidden action)
    Route::post('/ord-upload', [AdminOrdinanceController::class, 'store'])->name('ord-upload.store');

    // The Uploaded List (Short URL: /ord-uploaded)
    Route::get('/ord-uploaded', function (Request $request) {
        $query = Ordinance::query();

        if ($request->filled('year')) {
            $query->whereYear('date_implemented', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('date_implemented', $request->month);
        }

        $availableYears = Ordinance::selectRaw('YEAR(date_implemented) as year')
            ->whereNotNull('date_implemented')->distinct()->orderBy('year', 'desc')->pluck('year');

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('date_implemented', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('subject', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('subject', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('date_implemented', 'desc');
                    break;
            }
        } else {
            $query->orderBy('date_implemented', 'desc');
        }

        $ordinances = $query->paginate(12);
        return view('admin.panel.ordinance.ord-uploaded', compact('ordinances', 'availableYears'));
    })->name('ord-uploaded');

    Route::post('/ord-uploaded', [AdminOrdinanceController::class, 'show'])->name('ord-uploaded.show');

    // Ordinance Actions
    Route::get('/ord-uploaded/{id}/edit', [AdminOrdinanceController::class, 'edit'])->name('ord-edit');
    Route::put('/ord-uploaded/{id}', [AdminOrdinanceController::class, 'update'])->name('ord-update');
    Route::delete('/ord-uploaded/{id}', [AdminOrdinanceController::class, 'destroy'])->name('ord-delete');


    // ==========================================
    // --- OFFICIALS ---
    // ==========================================

    // Viewer Page (Short URL: /officials)
    Route::get('/officials', [DashboardController::class, 'officials'])->name('officials');

    // Official Upload Action
    Route::post('/officials/store', [AdminOfficialController::class, 'store'])->name('admin.officials.store');

    // The Upload/Manage Form
    Route::get('/officials-upload', function () {
        $officials = Official::all()->keyBy('position_key');
        return view('admin.panel.official.officials', compact('officials'));
    })->name('official');

});
// === END OF SECURE ADMIN ROUTES ===