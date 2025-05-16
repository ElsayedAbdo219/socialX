<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = ['over_view_id','comment'];
    protected $with = ['overview'];

    # Relations
    public function overview()
    {
        return $this->belongsTo(OverView::class);
    }
}
