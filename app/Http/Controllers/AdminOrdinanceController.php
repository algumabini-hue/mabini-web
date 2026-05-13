<?php

namespace App\Http\Controllers;
use App\Models\Ordinance;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Http\Request;

class AdminOrdinanceController extends Controller
{
    public function store(Request $request)
    {
        $uploadedCount = 0;

        // Loop through the 4 boxes submitted from the form
        foreach ($request->input('ordinances', []) as $index => $ord) {

            // If the user filled out AT LEAST the subject for this box, save it
            if (!empty($ord['subject'])) {

                // --- NEW UPLOAD LOGIC STARTS HERE ---
                $attachmentData = [];

                // Check if files were uploaded for this specific ordinance box
                if ($request->hasFile("ordinances.{$index}.attachments")) {
                    $files = $request->file("ordinances.{$index}.attachments");

                    foreach ($files as $file) {
                        // 1. Save the file to the 'storage/app/public/ordinance-attachments' folder
                        $path = $file->store('ordinance-attachments', 'public');

                        // 2. Format the data exactly how your viewer modal expects it!
                        $attachmentData[] = [
                            'original_name' => $file->getClientOriginalName(),
                            'file_size' => $file->getSize(),
                            'file_path' => $path,
                        ];
                    }
                }
                // --- NEW UPLOAD LOGIC ENDS HERE ---

                Ordinance::create([
                    'date_implemented' => $ord['date_implemented'] ?? null,
                    'subject' => $ord['subject'] ?? null,
                    'attachments' => $attachmentData, // Add the files to the database!
                ]);

                $uploadedCount++;
            }
        }

        if ($uploadedCount > 0) {
            return redirect()->back()->with('success', "Successfully uploaded $uploadedCount Ordinance(s)!");
        }

        return redirect()->back()->with('error', 'Please fill out at least one ordinance subject completely.');
    }
    //edit and update functions for the edit form

    public function edit($id)
    {
        // 1. Find the specific ordinance in the database by its ID
        // findOrFail will automatically show a 404 error if the ID doesn't exist
        $ordinance = Ordinance::findOrFail($id);

        // 2. Return the edit view and pass the ordinance data to it
        // Make sure 'admin.ordinances.edit' matches the actual path to your blade file
        return view('admin.panel.ordinance.ord-edit', compact('ordinance'));
    }


    public function update(Request $request, $id)
    {
        // 1. Validate the text data
        $validatedData = $request->validate([
            'date_implemented' => 'nullable|date',
            'subject' => 'required|string',
            'new_attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480', // Max 20MB per file
            'remove_attachments' => 'nullable|array',
        ]);

        // 2. Find the exact ordinance
        $ordinance = Ordinance::findOrFail($id);

        // 3. Update the text fields
        $ordinance->date_implemented = $request->input('date_implemented');
        $ordinance->subject = $request->input('subject');

        // 4. Grab the current attachments array (or an empty array if none exist)
        $currentAttachments = $ordinance->attachments ?? [];

        // 5. Handle DELETIONS (if user clicked the red 'X')
        if ($request->has('remove_attachments')) {
            $toRemove = $request->input('remove_attachments');

            foreach ($toRemove as $pathToRemove) {
                // A. Delete the physical file from the storage folder
                Storage::disk('public')->delete($pathToRemove);

                // B. Filter it out of our data array
                $currentAttachments = array_filter($currentAttachments, function ($attachment) use ($pathToRemove) {
                    return $attachment['file_path'] !== $pathToRemove;
                });
            }
            // Re-index the array so it saves cleanly to JSON
            $currentAttachments = array_values($currentAttachments);
        }

        // 6. Handle NEW UPLOADS (if user dropped new files in the box)
        if ($request->hasFile('new_attachments')) {
            $files = $request->file('new_attachments');

            foreach ($files as $file) {
                // Save to 'storage/app/public/ordinance-attachments'
                $path = $file->store('ordinance-attachments', 'public');

                // Format the data exactly how your viewer modal expects it
                $currentAttachments[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_path' => $path,
                ];
            }
        }

        // 7. Save the updated attachments list back to the ordinance
        $ordinance->attachments = $currentAttachments;
        $ordinance->save();

        // Grab the uid from the hidden form field
        $uid = $request->input('uid');

        // Redirect back to list, maintaining the UID
        return redirect()->route('ord-uploaded', ['uid' => $uid])
            ->with('success', 'Ordinance updated successfully!');
    }

    // 1. ADD "Request $request" inside the parenthesis!
    public function destroy(Request $request, $id)
    {
        // 2. Find and delete the ordinance
        $ordinance = Ordinance::findOrFail($id);
        $ordinance->delete();

        // 3. Catch the UID from the mini-form
        $uid = $request->input('uid');

        // 4. Pass it back into the redirect!
        return redirect()->route('ord-uploaded', ['uid' => $uid])
            ->with('success', 'Ordinance deleted successfully!');
    }



    //----------------------------------------------------------------
}