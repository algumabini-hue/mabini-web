<?php

namespace App\Http\Controllers;

use App\Models\MunicipalityEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MunicipalityEventController extends Controller
{
    // 1. THE BRAND NEW TEMP UPLOAD METHOD
   

    public function index()
    {
        $events = MunicipalityEvent::latest()->get();
        return view('admin.events.event-uploaded', compact('events'));
    }

    public function show($id)
    {
        $event = MunicipalityEvent::findOrFail($id);
        return view('admin.events.event-description', compact('event'));
    }

    // Viewer side: List of events
    // Viewer side: List of events
    public function viewerIndex(Request $request)
    {
        // 1. Start building the query
        $query = MunicipalityEvent::query();

        // 2. Filter by Year (if the user selected one)
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // 3. Filter by Month (if the user selected one)
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // ==========================================
        // 4. THE NEW SEARCH BAR LOGIC
        // ==========================================
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            // We use a logical group (closure) here so the "OR" doesn't mess up the Year/Month filters!
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('caption', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        // ==========================================

        // 5. Sort the results based on the dropdown
        $sort = $request->input('sort', 'newest'); // 'newest' is the default

        if ($sort === 'oldest') {
            $query->orderBy('date', 'asc');
        } elseif ($sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            // Default: Newest first
            $query->orderBy('date', 'desc');
        }

        // 6. Execute the query and paginate (e.g., 9 events per page)
        // withQueryString() ensures that if a user is filtering by "Year 2026", 
        // that filter doesn't disappear when they click "Page 2"!
        $events = $query->paginate(9)->withQueryString();

        // 7. Fetch all unique years from the database for the dropdown
        $availableYears = MunicipalityEvent::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 8. Send BOTH variables to the view
        return view('viewer.events', compact('events', 'availableYears'));
    }

    public function viewerShow($id)
    {
        // Find the specific event by its ID
        $event = MunicipalityEvent::findOrFail($id);

        // Pass the $event variable to your viewer description blade
        // Looking at your VS Code sidebar, the folder is 'events' and file is 'events-desc'
        return view('events.events-desc', compact('event'));
    }
}