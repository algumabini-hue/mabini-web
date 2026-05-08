<?php

namespace App\Http\Controllers;

use function Symfony\Component\String\u;

use App\Models\MunicipalityEvent;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class AdminMunicipalityEventController extends Controller
{
    //
    public function uploadTemp(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Give it a unique name so files with the same name don't overwrite each other
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            // Save it to a temporary folder
            $path = $file->storeAs('temp-events', $filename, 'public');

            // Send the temporary path back to Dropzone
            return response()->json(['filePath' => $path]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    // 2. YOUR UPDATED STORE METHOD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'date' => 'required|date',
            // Changed from 'nullable' to 'required'!
            'temp_files' => 'required|array',
        ], [
            // Add a custom error message so the admin knows what went wrong
            'temp_files.required' => 'You must upload at least one image or video to post an event.'
        ]);

        $finalImagePaths = [];

        // Move the files from the "Waiting Room" to the final destination
        if (!empty($validated['temp_files'])) {
            foreach ($validated['temp_files'] as $tempFile) {
                if (Storage::disk('public')->exists($tempFile)) {
                    $newPath = 'municipality-events/' . basename($tempFile);
                    Storage::disk('public')->move($tempFile, $newPath);
                    $finalImagePaths[] = $newPath;
                }
            }
        }

        MunicipalityEvent::create([
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'date' => $validated['date'],
            'images' => $finalImagePaths,
        ]);

        return redirect()->back()->with('success', 'Municipality event uploaded successfully!');
    }

    public function getAll()
    {
        return MunicipalityEvent::latest()->get();
    }

    public function uploaded()
    {
        $title = request('title', '');
        $startDate = request('start_date', '');
        $endDate = request('end_date', '');

        $query = MunicipalityEvent::query();

        // Filter by title
        if (!empty($title)) {
            $query->where('title', 'like', "%{$title}%");
        }

        // Filter by date range
        if (!empty($startDate)) {
            $query->whereDate('date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('date', '<=', $endDate);
        }

        $events = $query->latest()->paginate(12);

        return view('admin.panel.event.municipalityeventsuploaded', [
            'events' => $events,
            'title' => $title,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function edit(MunicipalityEvent $event)
    {
        return view('admin.panel.event.municipality', ['editingEvent' => $event]);
    }

    public function update(Request $request, MunicipalityEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'date' => 'required|date',
            'existing_images' => 'nullable|array', // The photos you KEPT
            'temp_files' => 'nullable|array',      // The NEW photos from Dropzone
        ]);

        // --- STEP 1: CLEAN UP REMOVED PHOTOS ---
        $oldImages = $event->images ?? [];
        $keptImages = $request->input('existing_images', []);

        // Find images that were in the DB but are NOT in the 'kept' list
        $imagesToDelete = array_diff($oldImages, $keptImages);

        foreach ($imagesToDelete as $fileToDelete) {
            if (Storage::disk('public')->exists($fileToDelete)) {
                Storage::disk('public')->delete($fileToDelete);
            }
        }

        // --- STEP 2: PROCESS NEW UPLOADS ---
        $finalImagePaths = $keptImages; // Start our new list with the ones we kept

        if ($request->has('temp_files')) {
            foreach ($request->input('temp_files') as $tempFile) {
                if (Storage::disk('public')->exists($tempFile)) {
                    $newPath = 'municipality-events/' . basename($tempFile);
                    Storage::disk('public')->move($tempFile, $newPath);
                    $finalImagePaths[] = $newPath;
                }
            }
        }

        // --- STEP 3: SAVE TO DATABASE ---
        $event->update([
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'date' => $validated['date'],
            'images' => $finalImagePaths, // This overwrites the old array with the new one
        ]);

        return redirect()->route('municipality.uploaded')->with('success', 'Event updated and photos synchronized!');
    }

    public function destroy(MunicipalityEvent $event)
    {
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }

    public function show(MunicipalityEvent $event)
    {
        return response()->json([
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'caption' => $event->caption,
                'date_formatted' => $event->date->format('F d, Y'),
                'images' => $event->images ?? [],
                'created_at' => $event->created_at->diffForHumans(),
            ],
        ]);
    }
}
