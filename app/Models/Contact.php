<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_QUEUED = 'QUEUED';

    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    public const STATUS_COMPLETE = 'COMPLETE';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_QUEUED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETE,
    ];

    protected $fillable = [
        'title',
        'email',
        'phone_number',
        'user_id',
        'contents',
        'default_image',
        'url',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
