<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['name', 'type', 'url'];

    public static function saveFrom(Request $request)
    {
        $files = [];
        foreach ($request->allFiles() as $file) {
            if ($file instanceof UploadedFile) {
                $path = $file->storePublicly();
                $type = $file->extension();
                $name = $file->hashName();
                if ($path === false) {
                    $file = new self([
                        'name' => $name,
                        'type' => $type,
                        'url' => $url,
                    ]);
                    $file->save();
                    $files[] = $file;
                    continue;
                }
            } elseif (gettype($file) === 'array') {
                foreach ($file as $f) {
                    if ($f instanceof UploadedFile) {
                        $path = $f->storePublicly();
                        $type = $f->extension();
                        $name = $f->hashName();
                        if ($path === false) {
                            $file = new self([
                                'name' => $name,
                                'type' => $type,
                                'url' => $url,
                            ]);
                            $file->save();
                            $files[] = $file;
                            continue;
                        }
                    }
                }
            }
        }
        return $files;
    }
}
