<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $casts = [
        "is_hidden" => 'boolean',
        "is_selected" => "boolean"
    ];
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
