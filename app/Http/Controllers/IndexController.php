<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class IndexController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function postShow(Request $request)
    {
        dd($request->all());
    }

    public function uploader(Request $request)
    {
        if ($request->hasFile("files")) {
            $this->validate($request, [
                'files' => 'required|array|min:1',
                'files.*' => 'image|max:2000',
            ]);
            foreach ($request->file('files') as $file) {
                $out = ['files' => []];
                $filename = sha1(time() . uniqid()) . '.' . $file->extension();
                $file->storeAs("temp/", $filename, "local");
                $filename = "temp/" . $filename;
                $out['files'][] = [
                    'deleteType' => "GET",
                    'deleteUrl' => route("upload_handler", ['delete_file' => $filename]),
                    'name' => $file->getClientOriginalName(),
                    'size' => '187373',
                    'thumbnailUrl' => route('image_thumb', ['filename' => $filename]),
                    'url' => route('image_normal', ['filename' => $filename]),
                    'type' => \Storage::disk('local')->getMimeType($filename),
                    'path' => $filename
                ];
                return $out;
            }
        }
        if ($request->has("delete_file")) {
            \Storage::disk('local')->delete($request->input('delete_file'));
        }
        return ["status" => "error"];
    }

    public function imageNormal($filename)
    {
        return response()->file(\Storage::disk('local')->path($filename));
    }

    public function imageTmb($filename)
    {
        return Image::make(\Storage::disk('local')->path($filename))->fit(100, 100)->response();
    }
}
