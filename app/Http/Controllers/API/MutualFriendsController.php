<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Http\Resources\MutualFriendResource;
use App\Services\FriendsService;
use App\Vk\Entities\Friend;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MutualFriendsController extends Controller
{
    public function __construct(private FriendsService $friendService)
    {
    }

    public function show($mutualId, Request $request)
    {
        $friends = $this->friendService->getMutualFriends(Auth::id(), (int) $mutualId, (int) $request->input('page'));

        return MutualFriendResource::collection($friends)->preserveQuery();
    }
}
