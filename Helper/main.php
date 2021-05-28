<?php

use Modules\Preference\Entities\HideColumn;
use Modules\Preference\Entities\HideInput;

/**
 * Get the boolean result if the column is visible
 * 
 * @param string $module
 * @return object|null
 */
function is_visible_column(string $module, string $column)
{
    $business_id = request()->session()->get('user.business_id');

    $column = HideColumn::where('business_id', $business_id)
        ->where('module_name', $module)
        ->where('column_name', $column)
        ->first();

    return $column ? false : true;
}


/**
 * Get the boolean result if the field is visible
 * 
 * @param string $module
 * @return object|null
 */
function is_visible_input(string $module, string $input)
{
    $business_id = request()->session()->get('user.business_id');

    $input = HideInput::where('business_id', $business_id)
        ->where('module_name', $module)
        ->where('input_name', $input)
        ->first();

    return $input ? false : true;
}