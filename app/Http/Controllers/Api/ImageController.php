<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        return Image::all();
    }

    public function show($id)
    {
        $image = Image::find($id);
        if ($image)
            return $image;

        return response()->json(['error' => 'Image not found']);
    }
}
