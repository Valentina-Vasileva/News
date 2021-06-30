<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\NewsResource;
use App\Http\Requests\StoreNewsRequest;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('admin')->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = QueryBuilder::for(News::class)
            ->allowedFilters(['title'])
            ->get()
            ->all();

        return NewsResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();
        $news = News::create($data);
        return response()->json($news, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewsRequest  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNewsRequest $request, News $news)
    {
        $data = $request->validated();
        $news->status = $data['status'];
        $news->save();
        return response()->json($news, 200);
    }
}
