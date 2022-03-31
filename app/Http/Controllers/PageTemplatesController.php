<?php

namespace App\Http\Controllers;

use App\Http\Resources\reportTemplateResource;
use App\Models\report_page;
use Illuminate\Http\Request;

class PageTemplatesController extends Controller
{

    public function index() 
    {
        return response()->json(
            reportTemplateResource::collection(report_page::all())
        );
    }
    
    public function store(Request $request) 
    {
        
        $page_files = $this->get_page_files($request);
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;

        report_page::create([
            'name'         => $request->name, 
            'order_id'     => $request->order_id ?? null,
            'affiliate_id' => $request->user()->id,
            'pages'        => $pages,
            'page_files'   => $page_files,
        ]);  
        
        return response()->json('Template saved', 201);    

    }

    public function show(report_page $report_page) 
    {
        return response()->json(
            new reportTemplateResource($report_page)
        );
    }

    public function update(report_page $report_page, Request $request) 
    {
        
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;
        $page_files = $this->get_page_files($request);

        $report_page->update([
            'pages'      => $pages,
            'page_files' => $page_files 
        ]);

        return response()->json('Template saved', 201); 

    }

    private function get_page_files(Request $request) 
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
