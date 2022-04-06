<?php 

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait TemplateFormattedFiles {

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

    public function get_page_files(Request $request) 
    {
        
        $page_files = [];
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;
        
        if(count($pages)) 
        {
            $page_count = 0;
            foreach($pages as $page) 
            {
                foreach($page['elements'] as $element) 
                {
                    if($element['name'] == 'img') 
                    {
                        
                        if($element['prefetched'] == true) 
                        {
                            $src = $element['dataFile'];
                        }
                        else 
                        {
                            $src = $request->file('Img#' . $element['attributes']['id'])->store('report-templates', 'public');
                        }
                        
                        $page_files[$element['attributes']['id']] = [
                            'file'         => $src,
                            'storage_path' => '',
                            'page'         => $page_count
                        ];    
                    }
                }
                $page_count++;
            }
        }

        return $page_files;
    
    }

}