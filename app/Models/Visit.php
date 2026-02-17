<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visits";

    protected $fillable = [
        "visitor_id",
        "visit_id",
        "purpose",
        "visit_date",
        "check_in",
        "check_out",
        "status",
        "selfie_image_id"
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }

    public function selfieImage()
    {
        return $this->belongsTo(Image::class, 'selfie_image_id', 'id');
    }
}
