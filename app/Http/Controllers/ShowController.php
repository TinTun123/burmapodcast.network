<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Audience;
use App\Models\Episode;
use App\Models\Platform;
use App\Models\Seasons;
use App\Models\Show;
use App\Models\User;
use App\Services\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Undefined;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\isEmpty;

class ShowController extends Controller
{
    //
    protected $StaticService;

    public function __construct(Statistic $myStatistic)
    {
        $this->StaticService = $myStatistic;
    }

    public function createShow(Request $request) {


        $validator = Validator::make($request->all(), [
        
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'img_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'google_podcast' => 'nullable|url',
            'apple_podcast' => 'nullable|url',
            'sound_cloud' => 'nullable|url',
            'pod_beam' => 'nullable|url',
            'spotify' => 'nullable|url',
            'state' => ['required', Rule::in(['true', 'false'])]

        ]);

        if($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }

        $user = Auth::user();

        if ($user && $user->user_level !== 1 && $user->user_level !== 3) {
            return response()->json(['error' => 'Only Admin & co-host can edit show data'], 403);
        }

        $show = new Show();
        $show->id = $this->generateId('show');
        $show->title = $request->input('title');
        $show->description = $request->input('desc');
        $show->cover_img = $this->storeImage($request->file('img_file'), $show->id, 'show');
        $show->pod_beam = $request->input('pod_beam');
        $show->sound_cloud = $request->input('sound_cloud');
        $show->apple_podcast = $request->input('apple_podcast');
        $show->google_podcast = $request->input('google_podcast');
        $show->spotify = $request->input('spotify');

        if ($request->input('state') === 'true') {
            $show->state = 1;
        } else {
            $show->state = 0;
        }

        $show->save();

        ActivityLog::create([
            'name' => $user->name,
            'log_details' => "Created new show '$show->title'",
            'log_type' => 'create'
        ]);
        
        return response()->json(['success' => 'New show added', 'show' => $show], 200);
    }

    public function editShow(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'google_podcast' => 'nullable|url',
            'apple_podcast' => 'nullable|url',
            'sound_cloud' => 'nullable|url',
            'pod_beam' => 'nullable|url',
            'spotify' => 'nullable|url',
            'state' => ['required', Rule::in(['true', 'false'])],
        ]);

        if($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 402);

        }

        $user = Auth::user();

        if ($user && $user->user_level !== 1 && $user->user_level !== 3) {
            return response()->json(['error' => 'Only Admin & Co-host can edit show data'], 403);
        }

        $show = Show::with('seasons.episodes.users')->find($id);
        $show->title = $request->input('title');
        $show->description = $request->input('desc');
        if ($request->file('img_file')) {
            $show->cover_img = $this->storeImage($request->file('img_file'), $id, 'show');
        }
        $show->pod_beam = $request->input('pod_beam');
        $show->sound_cloud = $request->input('sound_cloud');
        $show->apple_podcast = $request->input('apple_podcast');
        $show->google_podcast = $request->input('google_podcast');
        $show->spotify = $request->input('spotify');

        if ($request->input('state') === 'true') {
            $show->state = 1;
        } else {
            $show->state = 0;
        }

        $show->save();

        ActivityLog::create([
            'name' => $user->name,
            'log_details' => "Edited $show->title show",
            'log_type' => 'Edit'
        ]);

        return response()->json(['success' => 'Show' . $request->input('title') . 'was updated!', 'show' => $show], 200);
    }

    public function deleteShow(Request $request, $showId) {
        DB::beginTransaction();

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 1 && $currentUser->user_level !== 3) {
            return response()->json(['error' => 'Only Admin & co-host can delete shows.'], 302);
        }

        try {
            $show = Show::findOrFail($showId);

            $this->deleteFile($show->id, 'show');

            $show->delete();

            DB::commit();

            ActivityLog::create([
                'name' => $user->name,
                'log_details' => "Delete $show->title show",
                'log_type' => 'delete'
            ]);

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
            'duration' => 'required|integer',
            'google_podcast' => 'nullable|url',
            'apple_podcast' => 'nullable|url',
            'sound_cloud' => 'nullable|url',
            'pod_beam' => 'nullable|url',
            'spotify' => 'nullable|url',
            'state' => ['required', Rule::in(['true', 'false'])]
        ]);


        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        if ($currentUser->user_level !== 3 && $currentUser->user_level !== 1) {

            return response()->json(['error' => 'Only Admin & Cohost can create episode.'], 302);

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

        $episode->pod_beam = $request->input('pod_beam');
        $episode->sound_cloud = $request->input('sound_cloud');
        $episode->apple_podcast = $request->input('apple_podcast');
        $episode->google_podcast = $request->input('google_podcast');
        $episode->spotify = $request->input('spotify');

        if ($request->input('state') === 'true') {
            $episode->state = 1;
        } else {
            $episode->state = 0;
        }

        $episode->save();

        $episode->users()->attach(array_map('intval', $request->input('host')));

        $episode->load('users');

        ActivityLog::create([
            'name' => $user->name,
            'log_details' => "Create new episode '$episode->title' ",
            'log_type' => 'create'
        ]);
        
        if (!$request->input('seasonId')) {
            $season['episodes'] = [ $episode ];
            return response()->json(['success' => 'Created Episode', 'season' => $season], 200);

        } else {
            return response()->json(['success' => 'create episode', 'episode' => $episode], 200);
        }
    }

    public function likeEpisode(Request $request, $epiId, Audience $audience) {

        $episode = Episode::with('season')->findOrFail($epiId);

        $episode->increment('number_of_likes');

        if(isset($audience)) {
            $this->StaticService->recordStatistic($request->ip(), $episode->season->show_id, $episode->id, 'like', $audience->id);
        }


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

    public function saveURL(Request $request) {

        $validator = Validator::make($request->all(), [
            'informm' => 'required|url',
            'youtube' => 'required|url',
             // Add "svg" to the allowed file types.
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 402);
        }

        if ($request->input('apple')) {
            Platform::where('name', 'Apple Podcast')->update(['url' => $request->input('apple')]);
        }

        if ($request->input('youtube')) {
            Platform::where('name', 'YouTube')->update(['url' => $request->input('youtube')]);
        }

        if ($request->input('spotify')) {
            Platform::where('name', 'Spotify')->update(['url' => $request->input('spotify')]);
        }

        if ($request->input('informm')) {
            Platform::where('name', 'InforMM')->update(['url' => $request->input('informm')]);
        }

        if ($request->file('thumb')) {
            Platform::where('name', 'InforMM')->update(['thumb_url' => $this->storeImage($request->file('thumb'), '1', 'urlThumb')]);
        }


        return response()->json(['message' => 'all fine'], 200);

    }

    public function saveSpotify(Request $request) {

        $validator = Validator::make($request->all(), [
            'showTitle' => 'required|string',
            'showUrl' => 'required|url',
            'showThumb' => 'required|image|mimes:jpeg,png,gif,svg,webp|max:2048', // Add "svg" to the allowed file types.
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 402);
        }

        if (strpos($request->input('showUrl'), 'spotify')) {

            $thumbUrl = $this->storeImage($request->file('showThumb'), 'spotify', 'spotify');


            $spotifylink = Platform::create([
                'name' => 'Spotify',
                'url' => $request->input('showUrl'),
                'showTitle' => $request->input('showTitle'),
                'showThumb' => $thumbUrl
            ]);
        } else if (strpos($request->input('showUrl'), 'apple')) {

            $thumbUrl = $this->storeImage($request->file('showThumb'), 'apple', 'apple');


            $spotifylink = Platform::create([
                'name' => 'Apple Podcast',
                'url' => $request->input('showUrl'),
                'showTitle' => $request->input('showTitle'),
                'showThumb' => $thumbUrl
            ]);
        } else {
            return response()->json(['errpr' => 'URL has to be related to Spotify or Apple podcast'], 402);
        }


        return response()->json(['message' => 'all find', 'spotifyShow' => $spotifylink], 200);
    }

    public function editSpotify(Request $request, Platform $platform) {

        $validator = Validator::make($request->all(), [
            'showTitle' => 'string',
            'showUrl' => 'url',
            'showThumb' => 'image|mimes:jpeg,png,gif,svg,webp|max:2048', // Add "svg" to the allowed file types.
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 402);
        }


        if($request->file('showThumb')) {
            if ($platform->name === 'Spotify') {
                $thumbUrl = $this->storeImage($request->file('showThumb'), 'spotify', 'spotify');
                $platform->showThumb = $thumbUrl;
            } else if ($platform->name === 'Apple Podcast') {
                $thumbUrl = $this->storeImage($request->file('showThumb'), 'apple', 'apple');
                $platform->showThumb = $thumbUrl;
            }


           
        }

        if($request->input('showTitle')) {
            $platform->showTitle = $request->input('showTitle');
        }

        if ($request->input('showUrl')) {
            $platform->url = $request->input('showUrl');
        }

        $platform->save();

        return response()->json(['message' => 'all fine', 'spotifyShow' => $platform], 200);

    }

    public function deleteSpotify(Request $request, Platform $platform) {

        $platform->delete();

        return response()->json(['message' => 'url deleted', 'id' => $platform->id], 200);

    }
    
    // public function addPlatform(Request $request) {

    //     Platform::create([
    //         'name' => 'Apple Podcast',
    //         'url' => 'https://chat.openai.com',
    //         'thumb' => null
    //     ]);

    //     Platform::create([
    //         'name' => 'YouTube',
    //         'url' => 'https://chat.openai.com',
    //         'thumb' => null
    //     ]);

    //     Platform::create([
    //         'name' => 'Spotify',
    //         'url' => 'https://chat.openai.com',
    //         'thumb' => null
    //     ]);

    //     Platform::create([
    //         'name' => 'InforMM',
    //         'url' => 'https://chat.openai.com',
    //         'thumb' => null
    //     ]);

    //     return response()->json(['msg' => 'all fine'], 200);

    // }

    public function getURLS(Request $request) {
        
        $platforms = Platform::all();

        Log::info('platforms: ', [
            $platforms
        ]);


        return response()->json(['urls' => $platforms], 200);
    }

    public function searchByHost(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required|integer'
        ]);

        $id = $validatedData['id'];

        $episodes = Episode::whereHas('users', function ($que) use ($id) {
            $que->where('user_id', $id);
        })->with(['season.show', 'users'])->withCount('comments')->get();

        return response()->json(['episodes' => $episodes], 200);
    }

    public function editEpisode(Request $request, $showId, $episodeId) {

        $validator = Validator::make($request->all(), [

            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'host' => 'required|array',
            'host.*' => 'integer',
            'date' => 'nullable|date',
            'seasonId' => 'integer',
            'google_podcast' => 'nullable|url',
            'apple_podcast' => 'nullable|url',
            'sound_cloud' => 'nullable|url',
            'pod_beam' => 'nullable|url',
            'spotify' => 'nullable|url',
            'state' => ['required', Rule::in(['true', 'false'])]

        ]);

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);


        if ($currentUser->user_level !== 3 && $currentUser->user_level !== 1) {

            return response()->json(['error' => 'Only Admin & Cohost can edit episode.'], 302);

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

            if ($request->file('img')) {
                $episode->img_url = $this->storeImage($request->file('img'), $episode->id, 'episode');
            }

            if ($request->file('audio')) {

                $episode->audio_url = $this->storeImage($request->file('audio'), $episode->id, 'audio');
                $episode->duration = $request->input('duration');
            }


            if ($request->input('state') === 'true') {
                $episode->state = 1;
            } else {
                $episode->state = 0;
            }

            $episode->pod_beam = $request->input('pod_beam');
            $episode->sound_cloud = $request->input('sound_cloud');
            $episode->apple_podcast = $request->input('apple_podcast');
            $episode->google_podcast = $request->input('google_podcast');
            $episode->spotify = $request->input('spotify');

        }

        $episode->users()->detach();

        $episode->users()->attach(array_map('intval', $request->input('host')));

        $episode->save();

        $episode->load('users');

        ActivityLog::create([
            'name' => $user->name,
            'log_details' => "Edited '$episode->title' episode",
            'log_type' => 'edit'
        ]);


        return response()->json(['success' => 'Episode ' . $episode->title . ' was edited.', 'episode' => $episode], 200);

    }

    public function deleteEpisode(Request $request, $epId) {

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);
        if ($currentUser->user_level !== 3 && $currentUser->user_level !== 1) {

            return response()->json(['error' => 'Only Admin & Cohost can delete episode.'], 302);

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

            ActivityLog::create([
                'name' => $user->name,
                'log_details' => "Delete '$episode->title' episode",
                'log_type' => 'delete'
            ]);

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

        if (Storage::exists($directory) && $id !== 'spotify' && $id !== 'apple') {
            Storage::deleteDirectory($directory);
        }

        $filename = $id . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('public/' . $type . '/' . $id, $filename);

        $storagePath = storage_path('app/' . $path);
        
        chmod(dirname($storagePath), 0755);


        $publicURL = asset('storage/' . $type . '/' . $id . '/' . $filename);



        return $publicURL;
    }

    public function listen(Request $request, Episode $episode) {

        if ($episode) {
            $episode->increment('listener_count');
        }

        if($request->query('audienceId')) {

            $this->StaticService->recordStatistic($request->ip(), $episode->season->show_id, $episode->id, 'listen', $request->query('audienceId'));
        }

        return response()->json(['msg' => 'all fine'], 200);
    }

    public function recordDownload(Request $request, $episodeId, $showId, $audienceId) {
    

        if ($audienceId && $showId && $episodeId) {
            $this->StaticService->recordStatistic($request->ip(), $showId, $episodeId, 'download', $audienceId);
        }

        return response()->json(['msg' => 'all fine'], 200);
        
    }

    public function recordShare(Request $request, $episodeId, $showId, $audienceId) {
        if ($audienceId && $showId && $episodeId) {
            $this->StaticService->recordStatistic($request->ip(), $showId, $episodeId, 'share', $audienceId);
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

     public function getShows(Request $request) {

            $shows = Show::with(['seasons.episodes' => function ($query) {
                $query->where('state', true)
                      ->select('id', 'season_id', 'number_of_likes', 'duration', 'listener_count');
            }])->where('state', true)->get()->toArray();
        
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

        $etag = md5(json_encode($shows));

        $lastModified = DB::table('shows')->max('updated_at');

        return response()->json(['success' => ' ', 'shows' => $shows], 200)
        ->header('ETag', $etag)
        ->header('Last-Modified', $lastModified);
    }


    public function getAdminShows() {


            $user = Auth::user();
    
            if ($user) {
                $userlevel = $user->user_level;
    
                if ($userlevel === 3 || $userlevel === 1 || $userlevel === 2) {
                    $shows = Show::with(['seasons.episodes' => function ($query) {
                        $query->select('id', 'season_id', 'number_of_likes', 'duration', 'listener_count');
                    }])->get()->toArray();
                }
    
            }
            
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

        // $show = Show::with(['seasons.episodes.users'])->whereHas('seasons.episodes', function ($query) {
        //     $query->where('state', 1);
        // })->find($showId);

        $show = Show::with(['seasons' => function ($query) {
            $query->with(['episodes' => function ($query) {
                $query->where('state', true)->with('users');
            }]);
        }])->find($showId);

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

    public function adminGetEpisodes(Request $request, $showId) {
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


