<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class reportTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'order_id'     => $this->order_id,
            'affiliate_id' => $this->affiliate_id,
            'pages'        => $this->pages,
            'page_files'   => $this->get_formatted_files($this->page_files),
            'created_at'   => $this->created_at->format('M, d Y')
        ];
    }

    public function get_formatted_files($files) 
    {
        return array_map(function($file) {
            return [
                'file'         => $file['file'],
                'page'         => $file['page'],
                'storage_path' => public_path('\/storage/' . $file['file']),
                'public_path'  => config('app.url') . Storage::url($file['file'])
            ];
        }, $files);
    }
}
