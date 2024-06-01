<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use ModelTrait;
    use SoftDeletes;

    protected $fillable = [
        'read_at', 'from_id', 'from_type', 'to_id',
        'to_type', 'message_text', 'chat_id'];

}
