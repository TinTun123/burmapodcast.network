<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Seasons;
use App\Models\Show;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ShowController extends Controller
{
    //
    public function createShow(Request $request) {
        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'img_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048'

        ]);

        if($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }

        $show = new Show();
        $show->id = $this->generateId('show');
        $show->title = $request->input('title');
        $show->description = $request->input('desc');
        $show->cover_img = $this->storeImage($request->file('img_file'), $show->id, 'show');
        $show->save();
        
        return response()->json(['success' => 'New show added', 'show' => $show], 200);
    }

    public function editShow(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'img_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'

        ]);

        if($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }

        $user = Auth::user();

        if ($user && $user->user_level !== 2) {
            return response()->json(['error' => 'Only host can edit show data'], 403);
        }

        $show = Show::findOrFail($id);
        $show->title = $request->input('title');
        $show->description = $request->input('desc');
        $show->cover_img = $this->storeImage($request->file('img_file'), $id, 'show');

        $show->save();

        return response()->json(['success' => 'Show' . $request->input('title') . 'was updated!', 'show' => $show], 200);
    }

    public function deleteShow(Request $request, $showId) {
        DB::beginTransaction();

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'Only host can delete shows.'], 304);
        }

        try {
            $show = Show::findOrFail($showId);

            $this->deleteFile($show->id, 'show');

            $show->delete();

            DB::commit();

            return response()->json(['success' => $show->title . ' was deleted.', 'showId' => $show->id], 200);
            } catch (\Exception $ex) {
                DB::rollBack();

                return response()->json(['error' => 'Deleting ' . $show->title . ' failed. Try again.'], 500);
            }
    }
 
    public function createEpisode(Request $request, $showId) {

        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'audio' => 'required|file|mimes:mp3,ogg,wav',
            'host' => 'required|array',
            'host.*' => 'integer',
            'date' => 'nullable|date',
            'seasonId' => 'integer',
            'duration' => 'required|integer'
        ]);


        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 2) {

            return response()->json(['error' => 'Only host can create episode.'], 304);

        }

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }


        if (!$request->input('date')) {

            $date = now();

        } else {

            $date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d H:i:s');

        }

        if (!$request->input('seasonId')) {
            $maxSeasonNumber = Seasons::where('show_id', $showId)->max('season_number');
            $seasonNumber = $maxSeasonNumber + 1;
        
            $season = Seasons::create([
                'season_number' => $seasonNumber,
                'show_id' => $showId
            ]);
        } else {
            $season = Seasons::findOrFail($request->input('seasonId'));
        }

        $episode = new Episode();
        $episodeId = $this->generateId('episode');
        $episode->id = $episodeId;
        $episode->season_id = $season->id;

        $ep_number = $season->episodes()->max('episode_number');

        if ($ep_number) {
            $episode_number = $ep_number + 1;
        } else {
            $episode_number = 1;
        }
        $episode->episode_number = $episode_number;
        $episode->title = $request->input('title');
        $episode->description = $request->input('desc');
        $episode->img_url = $this->storeImage($request->file('img'), $episodeId, 'episode');
        $episode->audio_url = $this->storeImage($request->file('audio'), $episodeId, 'audio');
        $episode->number_of_likes = 0;
        $episode->created_at = $date;
        $episode->duration = $request->input('duration');
        $episode->save();

        $episode->users()->attach(array_map('intval', $request->input('host')));

        $episode->load('users');
        
        if (!$request->input('seasonId')) {
            $season['episodes'] = [ $episode ];
            return response()->json(['success' => 'Created Episode', 'season' => $season], 200);

        } else {
            return response()->json(['success' => 'create episode', 'episode' => $episode], 200);
        }
    }

    public function likeEpisode(Request $request, $epiId) {

        $episode = Episode::findOrFail($epiId);

        $episode->increment('number_of_likes');

        return response()->json(['epiId' => $episode->id]);

    }

    public function search(Request $request) {

        $validator = Validator::make($request->all(), [
            'query' => 'required|string|max:255',
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }

        $query = $request->input('query');
        $category = $request->input('category');
        $episodes = [];

        switch ($category) {
            case 'shows':
                # code...
                $episodes = Episode::whereHas('season.show', function ($que) use ($query) {
                    $que->where('title', 'LIKE', "%$query%");
                })->with(['season.show' => function ($query) {
                    $query->select('id', 'title');
                }, 'users'])->withCount('comments')->get();
                if(count($episodes) > 0) {
                    return response()->json(['msg' => 'found ' . $episodes->count() . ' episodes of ' . $episodes[0]->season->show->title, 'episodes' => $episodes], 200);
                }

                return response()->json(['msg' => 'No episode was found', 'episodes' => $episodes], 200);

                break;
            
            case 'hosts' :

                $episodes = Episode::whereHas('users', function ($que) use ($query) {
                    $que->where('name', 'LIKE', "%$query%");
                })->with(['season.show', 'users'])->withCount('comments')->get();

                if(count($episodes) > 0) {
                    return response()->json(['msg' => 'found ' . $episodes->count() . ' episodes of ' . $episodes[0]->season->show->title, 'episodes' => $episodes], 200);
                }

                return response()->json(['msg' => 'No episode was found', 'episodes' => $episodes], 200);
                break;

            case 'episodes':

                $episodes = Episode::where('title', 'LIKE', "%$query%")->with(['season.show', 'users'])->withCount('comments')->get();

                if(count($episodes) > 0) {
                    return response()->json(['msg' => 'found ' . $episodes->count() . ' episodes of ' . $episodes[0]->season->show->title, 'episodes' => $episodes], 200);
                }

                return response()->json(['msg' => 'No episode was found', 'episodes' => $episodes], 200);

                break;

            case 'most':
                $episodes = Episode::orderByDesc('number_of_likes')
                ->limit(5)
                ->with(['season.show', 'users'])
                ->withCount('comments')
                ->get();

                if(count($episodes) > 0) {
                    return response()->json(['msg' => 'found ' . $episodes->count() . ' episodes of ' . $episodes[0]->season->show->title, 'episodes' => $episodes], 200);
                }

                return response()->json(['msg' => 'No episode was found', 'episodes' => $episodes], 200);
                break;
            default:
                # code...
                break;
        }



        return response()->json(['success' => 'No episode was found.'], 401);
    }

    public function editEpisode(Request $request, $showId, $episodeId) {

        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'audio' => 'required|file|mimes:mp3,ogg,wav',
            'host' => 'required|array',
            'host.*' => 'integer',
            'date' => 'nullable|date',
            'seasonId' => 'integer',
            'duration' => 'required|integer'

        ]);

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'Only host can edit episodes.'], 304);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        if (!$request->input('date')) {
            $date = now();
        } else {
            $date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d H:i:s');
        }

        if (!$request->input('seasonId')) {
            return response()->json(['error' => 'Season number missing.'], 402);
        } else {
            $season = Seasons::findOrFail($request->input('seasonId'));
        }

        $episode = Episode::findOrFail($episodeId);
        
        if ($episode) {
            $episode->title = $request->input('title');
            $episode->description = $request->input('desc');
            $episode->created_at = $date;
            $episode->img_url = $this->storeImage($request->file('img'), $episode->id, 'episode');
            $episode->audio_url = $this->storeImage($request->file('audio'), $episode->id, 'audio');
            $episode->duration = $request->input('duration');
        }

        $episode->users()->detach();

        $episode->users()->attach(array_map('intval', $request->input('host')));

        $episode->save();

        $episode->load('users');


        return response()->json(['success' => 'Episode ' . $episode->title . ' was edited.', 'episode' => $episode], 200);

    }

    public function deleteEpisode(Request $request, $epId) {

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'Only host can delete episodes.'], 304);
        }

        DB::beginTransaction();

        try {

            $episode = Episode::findOrFail($epId);
            $seasonId = $episode->season_id;
            $maxEpisodeNumber = Episode::where('season_id', $seasonId)->max('episode_number');
    
            if ($episode->episode_number < $maxEpisodeNumber) {
                Episode::where('season_id', $seasonId)
                ->where('episode_number', '>', $episode->episode_number)
                ->decrement('episode_number');
            }
    
            $this->deleteFile($episode->id, 'audio');
            $this->deleteFile($episode->id, 'episode');
    
            $episode->delete();

            $remainingEpisodes = Episode::where('season_id', $seasonId)->count();

            if ($remainingEpisodes === 0) {
                $season = Seasons::find($seasonId);
                $season->delete();
            }
    
            DB::commit();

            return response()->json([
                'success' => $episode->title . ' was deleted',
                'epId' => $episode->id, 
                'seasonId' => $episode->season_id], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['error' => 'An error during delete operation.'], 500);

        }


    }

    private function deleteFile($id, $type) {
        $directory = 'public/' . $type . '/' . $id;

        if (Storage::exists($directory)) {
            Storage::deleteDirectory($directory);
        }
    }

    private function storeImage($file, $id, $type) {

        $directory = 'public/' . $type . '/' . $id;

        if (Storage::exists($directory)) {
            Storage::deleteDirectory($directory);
        }

        $filename = $id . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('public/' . $type . '/' . $id, $filename);

        $storagePath = storage_path('app/' . $path);
        
        chmod(dirname($storagePath), 0755);


        $publicURL = asset('storage/' . $type . '/' . $id . '/' . $filename);



        return $publicURL;
    }

    public function listen(Episode $episode) {

        if ($episode) {
            $episode->increment('listener_count');
        }

        return response()->json(['msg' => 'all fine'], 200);
    }

    private function generateId($type) {
        if ($type === 'show') {
            $lastId = Show::max('id');
        } else if ($type === 'episode') {
            $lastId = Episode::max('id');
        }

        $nextId = ($lastId !== null) ? $lastId + 1 : 1;
        return $nextId;
    }

     public function getShows() {

        $shows = Show::with(['seasons.episodes' => function ($query) {
            $query->select('id', 'season_id', 'number_of_likes', 'duration', 'listener_count');
        }])->get()->toArray();
        
        foreach($shows as &$show) {
            $totallikes = 0;
            $totalduration = 0;
            $totalEpisode = 0;
            $totalPlay = 0;
            foreach($show['seasons'] as $season) {
                foreach($season['episodes'] as $epi) {
                    $totallikes += $epi['number_of_likes'];
                    $totalduration += $epi['duration'];
                    $totalEpisode += 1;
                    $totalPlay += $epi['listener_count'];
                }
            }

            $show['total_likes'] = $totallikes;
            $show['total_duration'] = $totalduration;
            $show['totalEpisodes'] = $totalEpisode;
            $show['listener_count'] = $totalPlay;
            unset($show['seasons']);
        }

        Log::info('shows', [
            $shows
        ]);

        $etag = md5(json_encode($shows));

        $lastModified = DB::table('shows')->max('updated_at');

        return response()->json(['success' => ' ', 'shows' => $shows], 200)
        ->header('ETag', $etag)
        ->header('Last-Modified', $lastModified);
    }

    public function getLatest (Request $request) {
        $latestEpisode = Episode::with(['season.show', 'users'])->withCount('comments')->orderBy('created_at', 'desc')->take(2)->get();


        return response()->json(['episode' => $latestEpisode, 'type' => 'Latest'], 200);
    }

    public function getMostListen(Request $request) {

        $mostListenEpi = Episode::with(['season.show', 'users'])->withCount('comments')->orderBy('number_of_likes', 'desc')->take(2)->get();

        return response()->json(['episode' => $mostListenEpi, 'type' => 'Most Listen'], 200);

    }

    public function getEpisode(Request $request, $showId) {

        $show = Show::with('seasons.episodes.users')->find($showId);

        $etag = md5(json_encode($show));

        $lastModifiedSeason = DB::table('seasons')->max('updated_at');
        $lastModifiedEpisode = DB::table('episodes')->max('updated_at');

        if($lastModifiedSeason && $lastModifiedEpisode) {
            $lastModified = max($lastModifiedEpisode, $lastModifiedSeason);
        } else {
            $lastModified = '';
        }

 
        
        return response()->json(['success' => ' ', 'episodes' => $show], 200)
        ->header('ETag', $etag)
        ->header('Last-Modified', $lastModified);
    }
}
