<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TemplateFormattedFiles;
use App\Http\Resources\TemplateResource;

class TemplatesController extends Controller
{
    use TemplateFormattedFiles;
    
    public function index() 
    {
        return response()->json(
            TemplateResource::collection(Template::all())
        );
    }
    
    public function store(Request $request) 
    {
        $page_files = $this->get_page_files($request);
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;

        Template::create([
            'name'         => $request->name, 
            'affiliate_id' => optional(Auth::user())->id,
            'pages'        => $pages,
            'page_files'   => $page_files,
        ]);  
        
        return response()->json('Template saved', 201);    

    }

    public function show(Template $template) 
    {
        return response()->json(
            new TemplateResource($template)
        );
    }

    public function update(Template $template, Request $request) 
    {
        
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;
        $page_files = $this->get_page_files($request);

        $template->update([
            'pages'      => $pages,
            'page_files' => $page_files 
        ]);

        return response()->json('Template saved', 201); 

    }


}
