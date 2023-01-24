<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($request->hasFile('avatar_file')) {
            if (!empty($user->avatar_url)) {
                Storage::disk('public')->delete('avatar-images/' . $user->avatar_url);
            }
            $file = $request->file('avatar_file');
            $fileName = now()->format('Y_m_d_His') . '_' . Str::slug($user->name, '_') . '.' . $file->extension();
            $file->storeAs('avatar-images', $fileName, ['disk' => 'public']);
            $user->avatar_url = $fileName;
        }
        if ($request->avatar_url == 'null') {
            Storage::disk('public')->delete('avatar-images/' . $user->avatar_url);
            $user->avatar_url = null;
        }
        $user->name = $request->name;
        $user->address = $request->address;
        $user->mobile = $request->mobile;
        if (strlen($request->new_password) > 0) {
            $user->password = Hash::make($request->new_password);
        }

        $user->update();

        return response()->json([
            'message' => 'Berhasil merubah data diri',
            "data" => new UserDetailsResource($user)
        ]);
    }
}
