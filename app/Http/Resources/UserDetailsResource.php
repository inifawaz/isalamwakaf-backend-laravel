<?php

namespace App\Http\Resources;

use App\Models\ManualPayment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isLogin = Auth::user();
        $isAdmin = $isLogin ? Auth::user()->hasRole('Admin') : false;
        return [
            "id" => $this->id,
            "name" => $this->name,
            "address" => $this->address,
            "mobile" => $this->mobile,
            "email" => $this->email,
            'is_suspended' => $this->is_suspended,
            "roles" => $this->getRoleNames(),
            "avatar_url" => $this->avatar_url ? asset('/storage/avatar-images/' . $this->avatar_url) : null,
            $this->mergeWhen($isAdmin, [
                "payment_waiting" => ManualPayment::where('status_code', 1)->count()
            ]),
            "payment_pending" => ManualPayment::where('payer_id', Auth::user()->id)->where('status_code', 0)->count()
        ];
    }
}
