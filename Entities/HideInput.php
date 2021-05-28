<?php

namespace Modules\Preference\Entities;

use Illuminate\Database\Eloquent\Model;

class HideInput extends Model
{
    protected $fillable = [
        'business_id',
        'user_id',
        'module_name',
        'input_name',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public static function getInputs($module)
    {
        $columns = HideInput::where('module_name', $module);
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
