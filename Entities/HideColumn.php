<?php

namespace Modules\Preference\Entities;

use App\User;
use App\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HideColumn extends Model
{
    protected $fillable = [
        'business_id',
        'user_id',
        'module_name',
        'column_name',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public static function getColumns($module)
    {
        $columns = HideColumn::where('module_name', $module);
    }

    /**
     * Get the user that owns the HideColumn
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the business that owns the HideColumn
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
