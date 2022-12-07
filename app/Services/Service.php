<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Service
{
    public function deleteFiles($id,$fileId){
        $allFiles = User::find($id)->file;
        $files = $allFiles->find($fileId);
        $path = $files['path'];
        Storage::delete($path);
        File::destroy($files['id']);
    }

    public function renameFiles($user_id,$fileId,$newName,$file){
        $allFiles = User::find($user_id)->file;
        $files = $allFiles->find($fileId);
        $oldPath  = explode('/',$files['path']);
        $lenMas = count($oldPath) - 1;
        $newPath = $oldPath;
        $newPath[$lenMas] = $newName;
        $newestPath = implode('/',$newPath);
        $renameOldPath = $oldPath;
        $renameOldPath[0] = 'storage';
        $renameNewPath = $newPath;
        $renameNewPath[0] = $renameOldPath[0];
        $folderNewPath = implode('/',$renameNewPath);
        $folderOldPath = implode('/',$renameOldPath);
        rename($folderOldPath,$folderNewPath);
        $data = [
            'name' => $newName,
            'path' => $newestPath,
        ];
        $file->update($data);
    }

}
