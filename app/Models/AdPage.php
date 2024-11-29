<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * class AdPage;
 * @package App\Models;
 *
 * @property string $url;
 * @property int $previous_price;
 */
class AdPage extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'url',
        'previous_price',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'page_user', 'page_id', 'user_id');
    }
}
