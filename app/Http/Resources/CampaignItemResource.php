<?php

namespace App\Http\Resources;

use App\Models\ManualPayment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CampaignItemResource extends JsonResource
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

        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "category" => $this->category->name ?? null,
            "featured_image_url" => $this->featured_image_url ? asset('/storage/featured-images/campaign/' . $this->featured_image_url) : null,
            "title" => $this->title,
            "slug" => $this->slug,
            "is_target" => $this->is_target,
            "total_amount" => $totalAmount,
            "percent" => $this->when($this->is_target, $percent . '%'),
            "target_amount" => $this->when($this->is_target, $this->target_amount),
            "is_limited_time" => $this->is_limited_time,
            $this->mergeWhen($this->is_limited_time, [
                "start_date" => $this->start_date ?    Carbon::createFromFormat('Y-m-d', $this->start_date)->format('d F Y') : '',
                "end_date" => $this->end_date ?  Carbon::createFromFormat('Y-m-d', $this->end_date)->format('d F Y') : '',
                "days_left" => $this->start_date && $this->end_date ? 'Berakhir ' . now()->diffInDays($this->end_date) . ' hari lagi' : ''
            ]),
            "is_hidden" => $this->is_hidden,
            "is_selected" => $this->is_selected,
            "is_completed" => $this->is_completed,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "backers" => $backers
        ];
    }
}
