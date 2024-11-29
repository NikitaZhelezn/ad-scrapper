<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * class PageUser;
 * @package App\Models;
 *
 * @property int $page_id;
 * @property int $user_id;
 */
class PageUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'page_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(AdPage::class, 'page_id', 'id');
    }
}
