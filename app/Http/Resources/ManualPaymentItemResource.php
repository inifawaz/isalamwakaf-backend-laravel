<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManualPaymentItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "reference" => $this->reference,
            "campaign_id" => $this->campaign_id,
            "campaign" => $this->campaign->title,
            "amount" => $this->amount,
            "maintenance_fee" => $this->maintenance_fee,
            "payer_id" => $this->payer_id,
            "payer" => $this->payer->name,
            "on_behalf" => $this->on_behalf,
            "status_code" => $this->status_code,
            "wos" => $this->wos,
            "is_anonim" => $this->is_anonim,
            "receipt_url" => $this->receipt_url ? asset('storage/receipt-images/campaign/' . $this->receipt_url) : null,
            "validator_id" => $this->validator_id,
            "validator" => $this->validator->name ?? null,
            "comment" => $this->comment,
            "created_at" => $this->created_at
        ];
    }
}
