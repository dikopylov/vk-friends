<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTagRequest;
use App\Http\Resources\FriendResource;
use App\Services\FriendsService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function __construct(private FriendsService $friendService, private TagService $tagService)
    {
    }

    public function index(Request $request)
    {
        $friends = $this->friendService->getFriends(Auth::id(), (int) $request->get('page', 0));

        return FriendResource::collection($friends)->preserveQuery();
    }

    public function attachTag($friendId, AttachTagRequest $request)
    {
        return $this->tagService->attachTagToFriend($friendId, $request->getId());
    }

    public function detachTag($friendId, AttachTagRequest $request)
    {
        return $this->tagService->attachTagToFriend($friendId, $request->getId());
    }
}
