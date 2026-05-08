<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Ordinance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.panel.dashboard');
    }

    public function municipality()
    {
        return view('admin.panel.event.municipality');
    }

    public function ordinances(Request $request)
    {
        // Start fresh query
        $query = Ordinance::query();

        // Pull in the filter values from the query string (if any)
        $filterYear = $request->input('filter.year');
        $filterMonth = $request->input('filter.month');
        $filterSort = $request->input('filter.sort');

        // Filter by year if provided
        if ($filterYear) {
            $query->whereYear('date_implemented', $filterYear);
        }

        // Filter by month if provided
        if ($filterMonth) {
            $query->whereMonth('date_implemented', $filterMonth);
        }

        // Get available years for filter dropdown
        $availableYears = Ordinance::selectRaw('YEAR(date_implemented) as year')
            ->whereNotNull('date_implemented')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Handle sorting
        switch ($filterSort) {
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

        // Paginate results
        $ordinances = $query->paginate(12);

        return view('admin.panel.ordinances', compact('ordinances', 'availableYears'));
    }

    public function officials()
    {
        $officials = Official::all()->keyBy('position_key');

        return view('admin.panel.officials', ['officials' => $officials]);
    }
}
