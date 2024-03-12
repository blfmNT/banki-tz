<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

use App\Models\Image;
class ImageController extends Controller
{

    public function index(Request $request)
    {
        $query = DB::table('images');
        switch($request->get('sort'))
        {
            case 'filename':
                $query->OrderBy('filename', 'ASC');
                break;
            case 'created':
                $query->OrderBy('created_at', 'ASC');
                break;
            default:
                $query->OrderBy('id', 'DESC');
        }

        $images = $query->take(16)->get();

        return view('image.index', compact('images'));

    }
    public function download($id)
    {
        $image = Image::findOrfail($id);

        $zip_name = storage_path('app/tmp.zip');
        $zip = new ZipArchive();
        $zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile(public_path('images/') . $image->filename, $image->filename);
        $zip->close();

        return response()->download($zip_name)->deleteFileAfterSend(true);
    }
    public function store(StoreImageRequest $request)
    {
        $vdata = $request->validated();

        foreach($vdata['images'] as $image_data)
        {
            $image_data->move(public_path('images'), $image_data->imageName);
            $image = new Image();
            $image->filename = $image_data->imageName;
            $image->save();
        }

        $count = count($vdata['images']);

        return redirect('/')->with(['message' => "{$count} image(s) has been uploaded"]);
    }
}
