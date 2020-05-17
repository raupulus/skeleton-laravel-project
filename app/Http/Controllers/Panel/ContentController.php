<?php

namespace App\Http\Controllers\Panel;

use App\Content;
use App\ContentSeo;
use App\ContentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function auth;
use function redirect;
use function response;
use function view;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.content.index')->with([

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type_slug)
    {
        $type = ContentType::where('slug', $type_slug)
            ->whereNull('deleted_at')
            ->first();

        ## En caso de intentar crear un tipo de contenido inexistente.
        if (!$type) {
            return redirect()->back()->with([

            ]);
        }

        return view('panel.content.add_edit')->with([
            'type' => $type,
            'seo' => new ContentSeo([

            ]),
            'content' => new Content([
                //'user_id' => auth()->id(),
                //'status_id' => ??
                //'type_id' => $type->id
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        return view('panel.content.add_edit')->with([
            'content' => $content,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
