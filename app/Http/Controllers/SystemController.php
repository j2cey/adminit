<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Controllers\Authorization\PermissionController;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $statuses = Status::all();
        //$settings = Setting::whereNotNull('value')->get()->load('group');
        //$settings = Setting::get()->load('group');
        /*$grouped = $settings->groupBy(function ($item, $key) {
            return $item['group'].$item['name'];
        });*/
        $settings_grouped = Setting::whereNull('value')
            ->whereNull('main_group_id')
            ->get()->load(['mainsubsettings']);
        //$settings_grouped = Setting::getAllGrouped();

        $permissions = (new PermissionController())->fetchall();
        $roles = Role::all()->load('permissions');
        $users = User::all()->load(['roles','status']); // UserResource::collection(User::all());

        return view('systems.index')
            ->with('statuses', $statuses)
            //->with('settings', $settings)
            ->with('settings_grouped', $settings_grouped)
            ->with('permissions', $permissions)
            ->with('roles', $roles)
            ->with('users', $users)
            ;
    }
}
