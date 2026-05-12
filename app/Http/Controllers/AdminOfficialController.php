<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Official;
use Illuminate\Support\Facades\Storage; 

class AdminOfficialController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate that 'officials' is an array
        $request->validate([
            'officials' => 'required|array',
            'officials.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 2. Loop through each official position sent from the form
        foreach ($request->officials as $key => $data) {

            // Only process if a name was entered or a photo was uploaded
            if (!empty($data['name']) || isset($data['photo'])) {

                $officialData = [
                    'name' => $data['name'] ?? null,
                    'position' => $data['position'] ?? null,
                    'department' => $data['department'] ?? null,
                    'dob' => $data['dob'] ?? null,
                    'pob' => $data['pob'] ?? null,
                    'civil_status' => $data['civil_status'] ?? null,
                    'citizenship' => $data['citizenship'] ?? null,
                    'description' => $data['description'] ?? null,
                ];

                // 3. Handle File Upload if a new photo was added
                if (isset($data['photo'])) {
                    $file = $data['photo'];
                    $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();

                    // Saves to storage/app/public/officials
                    $path = $file->storeAs('officials', $filename, 'public');
                    $officialData['photo_path'] = '/storage/' . $path;
                }

                // 4. Update existing position (e.g., replacing the old Mayor) or create a new one
                Official::updateOrCreate(
                    ['position_key' => $key], // Search by the key (e.g., 'mayor')
                    $officialData // The data to update/insert
                );
            }
        }

        return redirect()->back()->with('success', 'Officials have been successfully uploaded and saved.');
    }

    public function index()
    {
        // Fetches all officials and allows you to call them by their key (e.g., $officials['mayor'])
        $officials = Official::all()->keyBy('position_key');

        return view('viewer.officials', compact('officials'));
    }

    public function show($id)
    {
        // Fetch the specific official by their ID, or throw a 404 error if not found
        $official = Official::findOrFail($id);

        // Pass that specific official to your personal description blade
        return view('officials.officials-personal', compact('official'));
    }   
}
