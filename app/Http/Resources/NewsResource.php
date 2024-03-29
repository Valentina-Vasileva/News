<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'body' => $this->when($request->routeIs('news.show'), $this->body),
            'updated_at' => $this->updated_at,
            'status' => $this->when(Auth::user()->admin, $this->status),
        ];
    }
}
