<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends BaseController
{
    public function userInfo()
    {
        // TODO: Implement __invoke() method.
        $user = auth()->user();
        return $user;
    }
    public function createDirectory(Request $request, User $user){
        $user_id = Auth::user()->id;
        Storage::makeDirectory('public/'. $user_id);
        return response()->json([
            'message' => 'success',
        ]);
    }
    public function getFiles()
    {
        $files = Auth::user()->file;
        return response()->json([
            $files,
        ]);
    }
    public function getAllFiles()
    {
        $folder = 'public';
        $f = Storage::allFiles($folder);
        return $f;
    }
    public function deleteFiles(Request $request,File $file)
    {
        $id  = Auth::user()->id;
        $fileId = $file->id;
        $this->service->deleteFiles($id,$fileId);
        return response()->json([
            'message' => 'success',
        ]);
    }
    public function renameFile(File $file, Request $request){
        $user_id  = Auth::user()->id;
        $fileId = $file->id;
        $newName = $request->newFileName;
        $this->service->renameFiles($user_id,$fileId,$newName,$file);

        return response()->json([
            "success" => true,
            "message" => "File successfully rename",
            "file" => $newName
        ]);
    }
    public function downloadFiles(File $file){
        $allFiles = Auth::user()->file;
        $fileId = $file->id;
        $files = $allFiles->find($fileId);
        return Storage::download($files['path'],$files['name']);
    }
    public function getAllFileSize()
    {
        $folder = 'public';
        $fileAll = Storage::allFiles($folder);
        $size = 0;
        foreach ($fileAll as $f) {
            $size = $size + Storage::size($f);
        }
        return response()->json([
            'size' => $size,
        ]);
    }
}
