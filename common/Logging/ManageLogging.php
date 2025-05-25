<?php

namespace Common\Logging;

use Common\Services\PanelService;
use Illuminate\Support\Facades\Log;

class ManageLogging
{
    public static function createLog(array $data)
    {
        $panel = request()->segment(1);
        if(in_array($panel, PanelService::panels)){
            $panel = $panel;
        }else{
            $panel = PanelService::USER_PANEL;
        }

        Log::info('panel: '.$panel.' '.json_encode($data));
    }
}
