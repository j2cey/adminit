<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\BaseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer|null $status_id
 *
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @method static active()
 */
class BaseModel extends Model
{
    use BaseTrait;

    public function getRouteKeyName() { return 'uuid'; }

    #region Eloquent Relationships

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    #endregion

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    public function scopeActive($query) {
        return $query
            ->where('status_id', Status::active()->first()->id);
    }

    #endregion
}
