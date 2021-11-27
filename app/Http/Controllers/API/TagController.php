<?php

declare(strict_types=1);


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;

class TagController extends Controller
{
    public function __construct(private TagService $tagService)
    {
    }

    public function index()
    {
        return TagResource::collection(Tag::all());
    }

    public function store(StoreTagRequest $request)
    {
        return TagResource::make($this->tagService->createTag($request->getTitle()));
    }
}
