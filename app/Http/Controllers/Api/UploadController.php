<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $user_id = Auth::user()->id;
        $fileAll = User::find($user_id)->file;
        $size = 0;
        foreach ($fileAll as $f => $key) {
            $size = $size + Storage::size($key['path']);
        }
        if ($size < 105000000) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:doc,docx,pdf,txt,csv|max:20000000'
            ]);

            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors()], 401);
            }


            if ($request->isMethod('post') && $request->file('file')) {

                $file = $request->file('file');
                $upload_folder = 'public/' . $user_id;
                $filename = $file->getClientOriginalName();

                Storage::putFileAs($upload_folder, $file, $filename);
                $save = new File();
                $save->name = $filename;
                $save->path = $upload_folder . '/' . $filename;
                $save->user_id = $user_id;
                $save->save();

                return response()->json([
                    "success" => true,
                    "message" => "File successfully uploaded",
                    "file" => $filename
                ]);
            }

        }
        else{
            return response()->json([
               'message' => 'size of all files bigger then 100mb'
            ]);
        }
    }
}
