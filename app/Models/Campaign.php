<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'choice_amount' => 'array',
        "is_target" => "boolean",
        "is_hidden" => 'boolean',
        "is_selected" => 'boolean',
        "is_limited_time" => 'boolean',
        "is_completed" => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(CampaignCategory::class);
    }

    public function information()
    {
        return $this->hasMany(Information::class)->latest();
    }
}
