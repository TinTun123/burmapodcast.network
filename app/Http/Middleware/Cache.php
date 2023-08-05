<?php

namespace App\Http\Middleware;

use App\Models\Show;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Response;

use Symfony\Component\HttpFoundation\Response;

class Cache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $showId = $request->route('id');

        $etag = $request->header('If-None-Match');
        $lastModified = $request->header('If-Modified-Since');

        if($request->is('api/show') && !$showId) {
            $shows = Show::get()->toArray();

            $etagValue = md5(json_encode($shows));
            $lastModifiedValue = DB::table('shows')->max('updated_at');

 
        } elseif ($request->is('api/show/*') && $showId) {

            $show = Show::with('seasons.episodes.users')->find($showId);

            $etagValue = md5(json_encode($show->toArray()));


            $lastModifiedSeason = DB::table('seasons')->max('updated_at');
            $lastModifiedEpisode = DB::table('episodes')->max('updated_at');

            if($lastModifiedEpisode && $lastModifiedSeason) {
                $lastModifiedValue = max($lastModifiedEpisode, $lastModifiedSeason);
            } else {
                $lastModifiedValue = '';
            }

        }



        if($etag === $etagValue && strtotime($lastModified) >= strtotime($lastModifiedValue)) {

            return response()->json([], 304);
        }

        return $response;
    }
}
