<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = "visitors";

    protected $fillable = [
        "full_name",
        "phone_number",
        "identity_number",
        "address",
        "id_card_image_id",
    ];

    public function idCardImage()
    {
        return $this->belongsTo(Image::class, 'id_card_image_id', 'id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'visitor_id', 'id');
    }
}
