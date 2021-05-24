<?php

use Modules\Preference\Entities\HideColumn;


/**
 * Get the boolean result if the field is hidden
 * 
 * @param string $module
 * @return object|null
 */
function is_hidden_column(string $module, string $column)
{
    $business_id = request()->session()->get('user.business_id');

    $column = HideColumn::where('business_id', $business_id)
        ->where('module_name', $module)
        ->where('column_name', $column)
        ->first();

    return $column ? false : true;
}
