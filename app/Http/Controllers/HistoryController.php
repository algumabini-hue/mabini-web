<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function history()
    {
        $historyItems = [
            [
                'image' => 'images/mun-history/baling.png',
                'title' => 'The Origins of Balincaguin',
                'description' => 'Discover the early beginnings of our beloved municipality.'
            ],
            [
                'image' => 'images/mun-history/baling.png',
                'title' => 'Rich Heritage',
                'description' => 'A journey through time and culture.'
            ],
            [
                'image' => 'images/MH.jpg',
                'title' => 'Mabini Town Hall',
                'description' => 'The center of our dedicated public service.'
            ],
        ];

        // Build the simple array of image URLs for the JavaScript Lightbox
        $lightboxImages = array_map(function($item) {
            return asset($item['image']);
        }, $historyItems);

        // Pass BOTH variables to your view
        return view('viewer.history', compact('historyItems', 'lightboxImages'));
    }
}

