<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['name', 'type', 'url', 'real_name'];

    public static function saveFromRequest(Request $request)
    {
        $files = [];
        foreach ($request->allFiles() as $file) {
            if ($file instanceof UploadedFile) {
                $path = '/storage/'.$file->storePublicly('files');
                $type = $file->extension();
                $name = $file->hashName();
                $realName = $file->getClientOriginalName();
                if ($path !== false) {
                    $file = new self([
                        'name' => $name,
                        'type' => $type,
                        'url' => $path,
                        'real_name' => $realName
                    ]);
                    $file->save();
                    $files[] = $file;
                    continue;
                }
            } elseif (gettype($file) === 'array') {
                foreach ($file as $f) {
                    if ($f instanceof UploadedFile) {
                        $path = '/storage/'.$f->storePublicly('files');
                        $type = $f->extension();
                        $name = $f->hashName();
                        $realName = $file->getClientOriginalName();
                        if ($path !== false) {
                            $x = new self([
                                'name' => $name,
                                'type' => $type,
                                'url' => $path,
                                'real_name' => $realName
                            ]);
                            $x->save();
                            $files[] = $x;
                            continue;
                        }
                    }
                }
            }
        }
        return $files;
    }

    public static function saveOne($f)
    {
        if($f instanceof UploadedFile)
        {
            $path = '/storage/'.$f->storePublicly('files');
            $type = $f->extension();
            $name = $f->hashName();
            $realName = $file->getClientOriginalName();
            if ($path !== false) {
                $file = new self([
                    'name' => $name,
                    'type' => $type,
                    'url' => $path,
                    'real_name' => $realName
                ]);
                $file->save();
                return $file;
            }
        }
        return false;
    }
}
