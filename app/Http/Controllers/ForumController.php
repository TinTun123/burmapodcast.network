<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Audience;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Forum;
use App\Models\Replie;
use App\Models\Show;
use App\Models\User;
use App\Services\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    //
    protected $StaticService;

    public function __construct(Statistic $myStatistic)
    {
        $this->StaticService = $myStatistic;
    }
    

    public function addForum(Request $request) {
        

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'showID' => 'required|integer',
            'topic' => 'required|string'
        ]);

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        // if ($currentUser->user_level !== 2) {
        //     return response()->json(['error' => 'Only hosts can create forums'], 304);
        // }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        $topic = Forum::create([
            'title' => $request->input('title'),
            'body' => $request->input('topic'),
            'show_id' => $request->input('showID')
        ]);

        $topic->answers = [];

        return response()->json([
            'success' => 'New Thread has been created', 
            'forum' => $topic
        ], 200);
        
    }

    public function deleteForum(Request $request, $forumId) {
        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        // if ($currentUser->user_level !== 3 || $currentUser->user_level !== 1) {
        //     return response()->json(['error' => 'Only Admin/host can delete forums'], 302);
        // }

        $forum = Forum::findOrFail($forumId);

        $forum->delete();

        return response()->json(['success' => $forum->title . ' was deleted.', 'forumId' => $forum->id], 200);
    }

    public function editForum(Request $request, Forum $forum) {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'showID' => 'required|integer',
            'topic' => 'required|string'
        ]);

        $user = Auth::user();

        $currentUser = User::findOrFail($user->id);

        // if ($currentUser->user_level !== 2) {
        //     return response()->json(['error' => 'Only hosts can edit forums'], 304);
        // }


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        $forum->show_id = $request->input('showID');
        $forum->title = $request->input('title');
        $forum->body = $request->input('topic');

        $forum->save();

        return response()->json(['success' => 'edit ok', 'forum' => $forum], 200);
        
    }

    public function getForum(Request $request) {
        $forums = Show::with([
            'forum.answers' => function ($query) {
                $query->with(['user', 'audience', 'replies' => function ($query) {
                    $query->with(['user', 'audience']);
                }]);
            }])->get(['id', 'title']);

            foreach($forums as $show) {
                foreach($show->forum as $forum) {
                    foreach($forum->answers as $answer) {
                        $answer->human_created_at = $answer->created_at->diffForHumans();

                        foreach($answer->replies as $reply) {
                            $reply->human_created_at = $reply->created_at->diffForHumans();
                            unset($reply->created_at);
                        }
                        unset($answer->created_at);
                    }

                }
            }
        
        return response()->json(['success' => '', 'forums' => $forums], 200);
    }

    public function createAnswer (Request $request, $forumId) {
        $validator = Validator::make($request->all(), [
            'answer' => 'required|string',
            'audienceId' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        $user = auth('sanctum')->user();
        

        if ($user && ($user->user_level === 1 || $user->user_level === 2 || $user->user_level === 3)) {
            $answer = Answer::create([
                'answer' => $request->input('answer'),
                'forum_id' => $forumId,
                'user_id' => $user->id
            ]);

            $answer->user =  $user;
            $answer->replies = [];

            return response()->json(['success' => 'responsed', 'answer' => $answer], 200);
        } else {
            $answer = Answer::create([
                'answer' => $request->input('answer'),
                'forum_id' => $forumId,
                'audience_id' => $request->input('audienceId')
            ]);
            $audience = Audience::findOrFail($request->input('audienceId'));
            $answer->audience = $audience;
            $answer->replies = [];

            return response()->json(['success' => 'responsed', 'answer' => $answer], 200);
        }
    }

    public function deleteAnswer(Request $request, $answerId) {
        $user = auth('sanctum')->user();

        if ($user->user_level >= 1) {
            $answer = Answer::findOrFail($answerId);

            $answer->delete();

            return response()->json(['success' => $answer->answer . ' was deleted'], 200);
        }
    }

    public function createReply(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string',
            'audienceId' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }


        $type = $request->query('type');

        if ($type === 'answer') {
            $user = auth('sanctum')->user();
            

            if ($user && ($user->user_level === 1 || $user->user_level === 2 || $user->user_level === 3)) {


                $reply = Replie::create([
                    'replyable_id' => $id,
                    'replyable_type' => Answer::class,
                    'content' => $request->input('reply'),
                    'user_id' => $user->id  
                ]);

                $reply->user = $user;

                return response()->json(['success' => 'Replied', 'reply' => $reply], 200);
            } else {
                $reply = Replie::create([
                    'replyable_id' => $id,
                    'replyable_type' => Answer::class,
                    'content' => $request->input('reply'),
                    'audience_id' => $request->input('audienceId') 
                ]);

                $audience = Audience::findOrFail($request->input('audienceId'));
                $reply->audience = $audience;

                return response()->json(['success' => 'Replied', 'reply' => $reply], 200);                
            }

        }
    }

    public function deleteReply(Request $request, $replyId) {
        $user = auth('sanctum')->user();

        if ($user->user_level >= 1) {
            $reply = Replie::findOrFail($replyId);

            $reply->delete();

            return response()->json(['success' => $reply->content . ' was deleted.', 'reply' => $reply], 200);
        }
    }

    public function createComment(Request $request, $episodeId) {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'audienceId' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        $user = auth('sanctum')->user();

        if ($user && ($user->user_level === 1 || $user->user_level === 2 || $user->user_level === 3)) {
            $comment = Comment::create([
                'content' => $request->input('comment'),
                'user_id' => $user->id,
                'episode_id' => (int) $episodeId
            ]);

            $comment->user = $user;

            $episode = [
                'episode_id' => (int) $episodeId,
                'comments' => $comment
            ];

            return response()->json(['success' => ' ', 'comment' => $episode], 200);

        } else {
            $comment = Comment::create([
                'content' => $request->input('comment'),
                'audience_id' => $request->input('audienceId'),
                'episode_id' => (int) $episodeId
            ]);

            $audience = Audience::findOrFail($request->input('audienceId'));
            $comment->audience = $audience;

            $episode = [
                'comments' => $comment,
                'episode_id' => (int) $episodeId
            ];

            $this->StaticService->recordStatistic($request->ip(), $request->input('showId'), $episodeId, 'comment', $audience->id);
            return response()->json(['success' => ' ', 'comment' => $episode], 200);
        }


    }

    public function deleteComment(Request $request, $commentId) {

        $user = auth('sanctum')->user();

        if ($user->user_level >= 1) {
            $comment = Comment::findOrFail($commentId);

            $comment->delete();

            return response()->json(['success' => '"' . $comment->content . '" was deleted!'], 200);
        }
    }

    public function getComments(Request $request, $episodeId) {

        $comment = Comment::where('episode_id', $episodeId)->with(['user', 'audience'])->get();

   

        if ($comment->isEmpty()) {
            $episode = [
                'episode_id' => null,
                'comments' => []
            ];
            return response()->json(['success' => 'No comments posted yet!', 'episode' => $episode], 200);

        }


        foreach($comment as $com) {
            $com->human_created_at = $com->created_at->diffForHumans();

            unset($com->created_at);
        }

        $episode = [
            'episode_id' => $episodeId,
            'comments' => $comment
        ];

        return response()->json(['success' => ' ', 'episode' => $episode], 200);

    }
}
