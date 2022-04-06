<?php

namespace App\Http\Resources;

use App\Traits\TemplateFormattedFiles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    
    use TemplateFormattedFiles;

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'affiliate_id' => $this->affiliate_id,
            'pages'        => $this->pages,
            'page_files'   => $this->get_formatted_files($this->page_files),
            'created_at'   => $this->created_at->format('M, d Y')
        ];
    }

}
