<?php

namespace App\Services;

use App\Models\Statistic as ModelsStatistic;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class Statistic {
    public function recordStatistic($ip, $showId, $episodeId, $action, $audience_id) {

        $ipinfo = Location::get($ip);

        ModelsStatistic::create([
            'show_id' => $showId,
            'episode_id' => $episodeId,
            'ip_address' => $ip,
            'audience_id' => $audience_id,
            'city' => $ipinfo->cityName,
            'country' => $ipinfo->countryName,
            'action' => $action
        ]);
    }
}