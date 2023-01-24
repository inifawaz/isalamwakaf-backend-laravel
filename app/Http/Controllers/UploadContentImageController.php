<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadContentImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->hasFile('content_image')) {
            $file = $request->file('content_image');
            $fileName = now()->format('Y_m_d_His') . '_' . random_int(100, 999)  . '.' . $file->extension();
            $file->storeAs('content-images/', $fileName, ['disk' => 'public']);
            return response()->json([
                "url" => asset('storage/content-images/' . $fileName)
            ]);
        }
    }
}
