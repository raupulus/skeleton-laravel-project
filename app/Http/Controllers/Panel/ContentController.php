<?php

namespace App\Http\Controllers\Panel;

use App\Content;
use App\ContentSeo;
use App\ContentStatus;
use App\ContentType;
use App\File;
use App\FileType;
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
     */
    public function index()
    {
        return view('panel.content.index')->with([

        ]);
    }

    /**
     * Show the form for creating a new resource.
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
            'status' => ContentStatus::all(),
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
        $content_id = $request->get('content_id');

        $content_data = [
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'excerpt' => $request->get('excerpt'),
            'body' => $request->get('body'),
        ];

        ## Cuando no existe el contenido se asigna al usuario actual.
        if (!$content_id) {
            $content_data['user_id'] = auth()->id();
        }

        ## Creo o edito el contenido con los datos anteriores.
        $content = Content::firstOrCreate([
            'id' => $request->get('content_id')
        ], $content_data);

        ## Si hay imagen, se actualiza.
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->store('public/posts');

            ## Obtengo el tipo de archivo o lo creo si no existe.
            $fileType = FileType::firstOrCreate([
                'mime' => $image->getClientMimeType(),
                'extension' => $image->getClientOriginalExtension(),
            ], [
                'type' => 'image',
                'mime' => $image->getClientMimeType(),
                'extension' => $image->getClientOriginalExtension(),
            ]);

            ## Registro el archivo de imagen.
            $file = File::firstOrCreate([
                'id' => $content->file_id
            ], [
                'file_type_id' => $fileType->id,
                'size' => $image->getSize(),
                'name' => $imageName,
                'originalname' => $image->getClientOriginalName(),
                'path' => $image->getPath(),
                'alt' => $image->getClientOriginalName(),
                'title' => $image->getClientOriginalName(),
                'is_private' => false,
            ]);

            $content->file_id = $file->id;
            $content->save();

            dd([
                $fileType,
                $file,
                $content,
            ]);

            // Añadir en file_types el mime de esta imagen
            // Añadir en files la imagen
        }

        dd($content, $request->all());
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
