<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordinance;
use App\Models\Official;
use App\Models\MunicipalityEvent;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('query');

        if (!$searchTerm) {
            return redirect()->back();
        }

        // 1. Search Database Models
        $events = MunicipalityEvent::where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('caption', 'LIKE', "%{$searchTerm}%")
            ->latest()->get();

        // FIX: Removed the 'description' search since that column doesn't exist on the Ordinance model!
        $ordinances = Ordinance::where('subject', 'LIKE', "%{$searchTerm}%")
            ->orderBy('date_implemented', 'desc')->get();

        $officials = Official::where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('position', 'LIKE', "%{$searchTerm}%")
            ->orWhere('department', 'LIKE', "%{$searchTerm}%")
            ->get();

        $staticPagesFound = [];

        // --- 1. SEARCH HISTORY PAGE ---
        try {
            $historyHtml = view('viewer.history')->render();
            $historyText = strip_tags($historyHtml);
            $historyTitle = "History of Mabini";

            if (stripos($historyTitle, $searchTerm) !== false || stripos($historyText, $searchTerm) !== false) {
                $staticPagesFound[] = [
                    'title' => $historyTitle,
                    'description' => 'Learn about the founding, background, and historical details of the Municipality of Mabini.',
                    'route' => route('history'),
                    'icon' => 'bi-clock-history'
                ];
            }
        } catch (\Exception $e) {
            // Ignore if view not found
        }

        // --- 2. SEARCH CONTACT PAGE ---
        try {
            // Make sure this path matches exactly where your contact blade is saved!
            // Based on your earlier code, it might be 'main-page.home-contact'
            $contactHtml = view('main-page.home-contact')->render();
            $contactText = strip_tags($contactHtml);
            $contactTitle = "Contact Us";

            // Safety net keywords in case they search for concepts instead of exact text
            $contactKeywords = "phone email address social media facebook twitter instagram youtube directory hotline";

            if (stripos($contactTitle, $searchTerm) !== false || stripos($contactText, $searchTerm) !== false || stripos($contactKeywords, $searchTerm) !== false) {
                $staticPagesFound[] = [
                    'title' => $contactTitle,
                    'description' => 'Find emergency hotlines, email addresses, and official social media links for the municipality.',
                    // This creates a link like: http://127.0.0.1:8000/home#contacts
                    'route' => route('home') . '#contacts',
                    'icon' => 'bi-telephone'
                ];
            }
        } catch (\Exception $e) {
            // Ignore if view not found
        }

        // 5. Send ALL variables to the results view
        return view('layout.search-results', compact('events', 'ordinances', 'officials', 'searchTerm', 'staticPagesFound'));
    }
}