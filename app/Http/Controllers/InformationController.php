<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInformationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInformationRequest $request)
    {
        $information = new Information();
        $information->campaign_id = $request->campaign_id;
        $information->title = $request->title;
        $information->content = $request->content;
        $information->creator_id = Auth::user()->id;
        $information->save();
        return response()->json([
            "message" => 'Berhasil menambah informasi baru'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInformationRequest  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInformationRequest $request, Information $information)
    {
        $information->title = $request->title;
        $information->content = $request->content;
        $information->creator_id = Auth::user()->id;
        $information->update();
        return response()->json([
            "message" => 'Berhasil merubah informasi'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return response()->json([
            "message" => "Berhasil menghapus informasi"
        ]);
    }
}
