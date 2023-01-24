<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDetailsResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            if ($request->user()->hasRole('Admin')) {
                if ($request->has('search')) {
                    return response()->json([
                        "data" => UserDetailsResource::collection(User::where('email', 'LIKE', "%" . $request->search . "%")->orWhere('name', 'LIKE', "%" . $request->search . "%")->orderBy('id', 'desc')->get())
                    ]);
                }
                if ($request->has('type')) {
                    if ($request->type == 'admin') {
                        return response()->json([
                            "data" => UserDetailsResource::collection(User::role('admin')->latest()->get())
                        ]);
                    }
                    if ($request->type == 'suspended') {
                        return response()->json([
                            "data" => UserDetailsResource::collection(User::where('is_suspended', 1)->latest()->get())
                        ]);
                    }
                }
            }
        }
        return response()->json([
            "data" => UserDetailsResource::collection(User::latest()->orderBy('id', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->is_suspended = $request->is_suspended;
        if ($request->is_admin == true) {
            $user->assignRole('admin');
        }
        if ($request->is_admin == false) {
            $user->removeRole('admin');
        }
        $user->update();
        return response()->json([
            'message' => 'Berhasil merubah data pengguna'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'Berhasil menghapus pengguna'
        ]);
    }
}
