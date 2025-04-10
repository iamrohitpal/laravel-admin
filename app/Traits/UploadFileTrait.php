<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UploadFileTrait
{
    public function fileupload($file, $type, $id = null)
    {
        $path = public_path("upload_image/" . $type);

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $originalName = $file->getClientOriginalName();
        $cleanName = str_replace(' ', '-', $originalName);
        $cleanName = preg_replace('/[^A-Za-z0-9\.\-]/', '', $cleanName);

        $filename = time() . '-' . $type . '-' . $cleanName;

        $file->move($path, $filename);

        if ($id) {
            DB::table('images')->insert([
                'product_id' => $id,
                'name'       => $filename,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $filename;
    }
}
