<?php

namespace App\Http\Controllers;

use App\Models\CampaignCategory;
use App\Http\Requests\StoreCampaignCategoryRequest;
use App\Http\Requests\UpdateCampaignCategoryRequest;
use Illuminate\Support\Str;

class CampaignCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "data" => CampaignCategory::latest()->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampaignCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignCategoryRequest $request)
    {
        $category = CampaignCategory::create([
            "name" => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return response()->json([
            "message" => 'Berhasil membuat kategori program wakaf baru'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignCategory  $campaignCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignCategory $campaignCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaignCategoryRequest  $request
     * @param  \App\Models\CampaignCategory  $campaignCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaignCategoryRequest $request, CampaignCategory $campaignCategory)
    {
        $campaignCategory->name = $request->name;
        $campaignCategory->slug = Str::slug($request->name);
        $campaignCategory->update();
        return response()->json([
            'message' => 'Berhasil merubah kategori program wakaf'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignCategory  $campaignCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignCategory $campaignCategory)
    {
        $campaignCategory->delete();

        return response()->json([
            'message' => 'Berhasil menghapus kategori program wakaf'
        ]);
    }
}
