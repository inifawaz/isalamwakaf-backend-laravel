<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ArticleDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isLogin = Auth::check();
        $isAdmin = $isLogin ? Auth::user()->hasRole('admin') : false;
        return [
            "id" => $this->id,
            "featured_image_url" => $this->featured_image_url ? asset('/storage/featured-images/article/' . $this->featured_image_url) : null,
            "title" => $this->title,
            "slug" => $this->slug,
            "category_id" => $this->category_id,
            "category" => $this->category->name ?? null,
            "content" => $this->content,
            "is_hidden" => $this->is_hidden,
            "is_selected" => $this->is_selected,
            "creator_id" => $this->creator_id,
            "creator" => $this->creator->name ?? null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
