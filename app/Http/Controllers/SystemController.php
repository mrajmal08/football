<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Show the Leaque.
     *
     * @return Response
     */
    public function systemSetting()
    {
        return view('league.index');
    }

    public function systemUpdate(Request $request)
    {
        $this->validate($request, [
            'sys_season_type' => 'required',
            'sys_season' => 'required',
            'sys_week' => 'required',
            'sys_waiver_period_enabled' => 'required',

        ],
        ['sys_season_type.required' => 'The system season type field is required.']);
        $setting_data = [
            'season'							=> $request->sys_season,
            'season_type'  						=> $request->sys_season_type,
            'week'     							=> $request->sys_week,
            'waiver_period_enabled'     		=> $request->sys_waiver_period_enabled,
            'display_ads'     					=> $request->sys_display_ads,
        ];

        $model = \App\Models\SystemSetting::updateOrCreate(
                            ['id'   => 1],
                            $setting_data
                        );
    }

    public function get_system_setting()
    {
        $systemSettings = SystemSetting::find(1);

        return response()->json($systemSettings);
    }
}
