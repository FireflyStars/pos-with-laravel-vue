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
    
    public function index(Request $request) 
    {

        $data = Template::where('affiliate_id', $request->user()->id);

        if($request->has('sortby') && count($request->sortby)) 
        {
            $sortby = $request->sortby[0];
            $data = $data->orderBy($sortby['id'], $sortby['orderby']);
        }
        
        $data = $data
                ->skip($request->skip ?? 0)
                ->take($request->take ?? 15)
                ->get();

        return TemplateResource::collection(
            $data
        );
        
    }
    
    public function store(Request $request) 
    {
        $page_files = $this->get_page_files($request);
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;

        Template::create([
            'name'         => $request->name, 
            'affiliate_id' => Auth::user()->id,
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

        return response()->json('Template saved', 200); 

    }


}
