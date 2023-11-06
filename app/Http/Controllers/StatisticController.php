<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Show;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticController extends Controller
{
    //
    public function getDataByWeek(Request $request, $episodeId, $showId) {
        
        $monthMapping = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];

        $startDate = now()->setYear(2023)->setMonth($monthMapping[$request->query('month')])->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        if ($episodeId === '0') {
            $statistic = DB::table('statistics')
            ->select(
                DB::raw('WEEK(created_at) as week_number'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('week_number')
            ->get();
        } else {
            $statistic = DB::table('statistics')
            ->select(
                DB::raw('WEEK(created_at) as week_number'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->where('episode_id', $episodeId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('week_number')
            ->get();
        }
        

        $minWeekNumber = $statistic->min('week_number');

        $firstDayOfMonth = $startDate->copy();
        $minWeekNumber = $firstDayOfMonth->weekOfYear; // Week number for the first day of the month

        $statistic = $statistic->map(function ($item) use ($firstDayOfMonth, $minWeekNumber) {

            $weekOfYear = $firstDayOfMonth->copy()->addWeeks($item->week_number - $minWeekNumber);
            $item->week_number = 'week-' . $weekOfYear->weekOfMonth;
            return $item;

        });

        return response()->json(['message' => 'all fine', 'statistic' => $statistic], 200);
    }

    public function getDataByMonth(Request $request, $episodeId, $showId) {

        $year = $request->query('year');

        if ($episodeId === '0') {
            $statistic = DB::table('statistics')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month')
            ->get();
        } else {

            $statistic = DB::table('statistics')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->where('episode_id', $episodeId)
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month')
            ->get();

        }
        
        
        return response()->json(['message' => 'all fine', 'statistic' => $statistic], 200);
    }

    public function getDataByYear(Request $request, $episodeId, $showId) {

        if ($episodeId === '0') {
            
            $statistic = DB::table('statistics')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                // DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->groupBy('year')
            ->get();

        } else {

            $statistic = DB::table('statistics')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                // DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
                DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
                DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
                DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
                DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
            )
            ->where('show_id', $showId)
            ->where('episode_id', $episodeId)
            ->groupBy('year')
            ->get();

        }
        

        return response()->json(['message' => 'all fine', 'statistic' => $statistic], 200);

    }

    public function getDataByGeo(Request $request, $episodeId, $showId) {

        $statistic = DB::table('statistics')
        ->select(
            'city', // Add 'city' to the select clause
            DB::raw('COUNT(CASE WHEN action = "download" THEN 1 ELSE NULL END) as download_count'),
            DB::raw('COUNT(CASE WHEN action = "like" THEN 1 ELSE NULL END) as like_count'),
            DB::raw('COUNT(CASE WHEN action = "listen" THEN 1 ELSE NULL END) as listen_count'),
            DB::raw('COUNT(CASE WHEN action = "share" THEN 1 ELSE NULL END) as share_count'),
            DB::raw('COUNT(CASE WHEN action = "comment" THEN 1 ELSE NULL END) as comment_count')
        )
        ->where('show_id', $showId)
        ->groupBy('city') // Group by 'city' instead of 'week_number'
        ->get();
       
        return response()->json(['message' => 'all fine', 'statistic' => $statistic], 200);
    } 

    public function getShowData(Request $request, Show $show) {

        $show = Show::with(['seasons.episodes.users', 'forum'])->find($show->id);

        $users = $show->seasons->flatMap(function ($season) {
            return $season->episodes->flatMap(function ($episode) {
                return $episode->users;
            });
        })->unique('id');

        Log::info('users: ', [
            $users
        ]);

        $episodes = $show->seasons->flatMap(function ($season) {
            return $season->episodes;
        })->all();

        $modifiedEpisodes = array_map(function ($episode) {
            return [
                'id' => $episode['id'],
                'title' => $episode['title'],
            ];
        }, $episodes);


        $totalEpisodeCount = $show->seasons->flatMap(function ($season) {
            return $season->episodes;
        })->count();

        $totalTopicsCount = $show->forum->count();

        $statistic = DB::table('statistics')
        ->select(
            'action',
            DB::raw('COUNT(*) as count')
        )
        ->where('show_id', $show->id)
        ->groupBy('action')
        ->get();

        $showData['users'] = $users;
        $showData['totalEpisodeCount'] = $totalEpisodeCount;
        $showData['totalTopicsCount'] = $totalTopicsCount;
        $showData['episodes'] = $modifiedEpisodes;
    
        foreach($statistic as $stat) {
            $showData[$stat->action . '_count'] = $stat->count;
        }

        $uniqueYears = DB::table('statistics')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->where('show_id', $show->id)
            ->distinct() // Ensure distinct years
            ->orderBy('year', 'asc') // Order by year in ascending order
            ->pluck('year');

        $showData['years'] = $uniqueYears;

        return response()->json(['message' => 'all fine', 'showData' => $showData], 200);
    }

        
}
