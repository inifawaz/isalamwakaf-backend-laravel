<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Resources\CampaignDetailsResource;
use App\Http\Resources\CampaignItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
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
                        "data" => CampaignItemResource::collection(Campaign::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('id', 'desc')->get())
                    ]);
                }
                if ($request->has('type')) {
                    if ($request->type == 'hidden') {
                        return response()->json([
                            "data" => CampaignItemResource::collection(Campaign::where('is_hidden', 1)->latest()->get())
                        ]);
                    }
                    if ($request->type == 'selected') {
                        return response()->json([
                            "data" => CampaignItemResource::collection(Campaign::where('is_selected', 1)->latest()->get())
                        ]);
                    }
                    if ($request->type == 'completed') {
                        return response()->json([
                            "data" => CampaignItemResource::collection(Campaign::where('is_completed', 1)->latest()->get())
                        ]);
                    }
                }
                if ($request->has('category')) {
                    return response()->json([
                        "data" => CampaignItemResource::collection(Campaign::where('category_id', $request->category)->latest()->get())
                    ]);
                }


                return response()->json([
                    "data" => CampaignItemResource::collection(Campaign::latest()->orderBy('id', 'desc')->get())
                ]);
            }
        }
        if ($request->has('category')) {
            return response()->json([
                "data" => CampaignItemResource::collection(Campaign::where('is_hidden', 0)->where('category_id', $request->category)->latest()->get())
            ]);
        }

        if ($request->type == 'selected') {
            return response()->json([
                "data" => CampaignItemResource::collection(Campaign::where('is_hidden', 0)->where('is_selected', 1)->latest()->get())
            ]);
        }
        if ($request->type == 'completed') {
            return response()->json([
                "data" => CampaignItemResource::collection(Campaign::where('is_hidden', 0)->where('is_completed', 1)->latest()->get())
            ]);
        }

        return response()->json([
            "data" => CampaignItemResource::collection(Campaign::where('is_hidden', 0)->latest()->orderBy('id', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRequest $request)
    {
        $campaign = new Campaign();

        if ($request->hasFile('featured_image_file')) {
            Storage::disk('public')->delete('featured-images/campaign/' . $campaign->featured_image_url);
            $file = $request->file('featured_image_file');
            $fileName = now()->format('Y_m_d_His') . '_' . Str::slug($request->title, '_') . '.' . $file->extension();
            $file->storeAs('featured-images/campaign', $fileName, ['disk' => 'public']);
            $campaign->featured_image_url = $fileName;
        }
        $campaign->title = $request->title;
        $campaign->slug = Str::slug($request->title);
        $campaign->category_id = $request->category_id == '' ? null : $request->category_id;
        $campaign->maintenance_fee = $request->maintenance_fee;
        $campaign->is_target = $request->is_target;
        $campaign->target_amount = $request->target_amount;
        $campaign->is_limited_time = $request->is_limited_time;
        $campaign->start_date = $request->start_date;
        $campaign->end_date = $request->end_date;
        $campaign->choice_amount = json_decode($request->choice_amount, true);
        $campaign->content = $request->content;
        $campaign->is_hidden = $request->is_hidden;
        $campaign->is_selected = $request->is_selected;
        $campaign->is_completed = $request->is_completed;
        $campaign->creator_id = Auth::user()->id;
        $campaign->save();
        return response()->json([
            "message" => "Berhasil membuat program wakaf baru",
            "data" => new CampaignDetailsResource($campaign->fresh())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return response()->json([
            "data" =>  new CampaignDetailsResource($campaign)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaignRequest  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        if ($request->featured_image_url == 'null') {
            Storage::disk('public')->delete('featured-images/campaign/' . $campaign->featured_image_url);
            $campaign->featured_image_url = null;
        }
        if ($request->hasFile('featured_image_file')) {
            Storage::disk('public')->delete('featured-images/campaign/' . $campaign->featured_image_url);
            $file = $request->file('featured_image_file');
            $fileName = now()->format('Y_m_d_His') . '_' . Str::slug($request->title, '_') . '.' . $file->extension();
            $file->storeAs('featured-images/campaign', $fileName, ['disk' => 'public']);
            $campaign->featured_image_url = $fileName;
        }
        $campaign->title = $request->title;
        $campaign->slug = Str::slug($request->title);

        $campaign->category_id = $request->category_id == '' ? null : $request->category_id;
        $campaign->maintenance_fee = $request->maintenance_fee;
        $campaign->is_target = $request->is_target;
        $campaign->target_amount = $request->target_amount;
        $campaign->is_limited_time = $request->is_limited_time;
        $campaign->start_date = $request->start_date;
        $campaign->end_date = $request->end_date;
        $campaign->choice_amount = json_decode($request->choice_amount, true);
        $campaign->content = $request->content;
        $campaign->is_hidden = $request->is_hidden;
        $campaign->is_selected = $request->is_selected;
        $campaign->is_completed = $request->is_completed;
        $campaign->update();
        return response()->json([
            "message" => "Berhasil merubah program wakaf",
            "data" => new CampaignDetailsResource($campaign->fresh())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->json([
            "message" => 'Berhasil menghapus program wakaf'
        ]);
    }
}
