<?php

namespace App\Models;

use App\Traits\Base\Uuidable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Status
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $code
 * @property string $name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Status extends Model
{
    use HasFactory, Uuidable;

    protected $guarded = [];

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    public function scopeActive($query) {
        return $query
            ->where('code', 'active');
    }

    public function scopeInactive($query) {
        return $query
            ->where('code', 'inactive');
    }

    #endregion
}
