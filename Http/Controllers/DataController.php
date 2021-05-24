<?php

namespace Modules\Preference\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Nwidart\Menus\Facades\Menu;
use Illuminate\Routing\Controller;

class DataController extends Controller
{
    /**
     * Adds Essentials menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        if (auth()->user()->can('superadmin'))
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->url(
                    action('\Modules\Preference\Http\Controllers\PreferenceController@index'),
                    __('Preferences'),
                    ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(1) == 'preferences', 'style' => config('app.env') == 'demo' ? 'background-color: #605ca8 !important;' : '']
                )
                    ->order(80);
            });
    }
}
