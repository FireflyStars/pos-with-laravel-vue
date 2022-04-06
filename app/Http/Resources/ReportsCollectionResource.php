<?php

namespace App\Http\Resources;

use App\Traits\TemplateFormattedFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportsCollectionResource extends JsonResource
{
    
    use TemplateFormattedFiles;

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'report_id'    => optional($this->report)->id, 
            'affiliate_id' => $this->affiliate_id,
            'pages'        => optional($this->report)->pages ? $this->report->pages : [],
            'page_files'   => optional($this->report)->page_files 
                              ? $this->get_formatted_files($this->report->page_files)
                              : [],
            'created_at'   => $this->created_at->format('M, d Y'),
        ];
    }

}
