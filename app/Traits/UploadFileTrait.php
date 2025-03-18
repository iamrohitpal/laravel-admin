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

        $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();

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
