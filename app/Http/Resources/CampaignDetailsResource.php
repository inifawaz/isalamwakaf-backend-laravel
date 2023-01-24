<?php

namespace App\Http\Resources;

use App\Models\ManualPayment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CampaignDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $manualPaymentSuccess = ManualPayment::where('campaign_id', $this->id)->where('status_code', 2);
        $totalAmount = $manualPaymentSuccess->sum('amount');
        $percent = ceil($totalAmount / $this->target_amount * 100);
        $backers = $manualPaymentSuccess->get(['amount', 'on_behalf', 'created_at', 'wos', 'is_anonim']);
        $isLogin = Auth::user();
        $isAdmin = $isLogin ? Auth::user()->hasRole('Admin') : false;
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "percent" => $this->when($this->is_target, $percent . '%'),
            "total_amount" => $totalAmount,
            "category" => $this->category->name ?? null,
            "featured_image_url" => $this->featured_image_url ? asset('/storage/featured-images/campaign/' . $this->featured_image_url) : null,
            "title" => $this->title,
            "slug" => $this->slug,
            "content" => $this->content,
            "maintenance_fee" => $this->maintenance_fee,
            "is_target" => $this->is_target,
            "target_amount" =>  $this->target_amount,
            "choice_amount" => $this->choice_amount,
            "is_limited_time" => $this->is_limited_time,
            "start_date" => $this->start_date ?    $this->start_date : '',
            "end_date" => $this->end_date ?  $this->end_date : '',
            "days_left" => $this->start_date && $this->end_date ? 'Berakhir ' . now()->diffInDays($this->end_date) . ' hari lagi' : '',
            "is_hidden" => $this->is_hidden,
            "is_selected" => $this->is_selected,
            "is_completed" => $this->is_completed,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "backers" => $backers,
            "payments" => $this->when($isAdmin, ManualPaymentItemResource::collection(ManualPayment::where('campaign_id', $this->id)->latest('updated_at')->get())),
            "information" => $this->information,
        ];
    }
}
