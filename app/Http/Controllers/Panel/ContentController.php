<?php

namespace App\Http\Controllers\Panel;

use App\Content;
use App\ContentSeo;
use App\ContentStatus;
use App\ContentType;
use App\File;
use App\FileType;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use function auth;
use function config;
use function count;
use function explode;
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
     */
    public function store(Request $request)
    {
        $content_id = $request->get('content_id');

        $content_data = [
            'status_id' => $request->get('status_id'),
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'excerpt' => $request->get('excerpt'),
            'body' => $request->get('body'),
        ];

        ## Cuando no existe el contenido se asigna al usuario actual.
        if (!$content_id) {
            $content_data['user_id'] = auth()->id();
            $content_data['type_id'] = $request->get('type_id');
        }

        ## Creo o edito el contenido con los datos anteriores.
        $content = Content::firstOrCreate([
            'id' => $request->get('content_id')
        ], $content_data);

        $author = User::find($content->user_id);
        $authorName = $author->name . ($author->surname ? ' ' . $author->surname : '');

        ## Seo
        $contentSeo_data = [
            'content_id' => $content->id,
            'language_id' => 1,
            'author' => $authorName,
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'robots' => $request->get('robots'),
            'copyright' => $authorName,
            'og_title' => $request->get('og_title'),
            'og_site_name' => config('app.name'),
            'og_description' => $request->get('og_description'),
            'og_image_alt' => $request->get('og_image_alt'),
            'twitter_card' => $request->get('twitter_card') ?? 'summary',
            'twitter_site' => $request->get('twitter_site') ?? '@fryntiz',
            'twitter_creator' => $authorName,
        ];

        ## Si hay imagen para el seo, se actualiza.
        if ($request->hasFile('og_image')) {
            $imageSeo = $request->file('og_image');
            $imageSeoPath = 'public/seo';
            $contentSeo_data['og_image'] = $imageSeo->store($imageSeoPath);
        }

        $contentSeo = ContentSeo::firstOrCreate([
            'content_id' => $content->id,
        ], $contentSeo_data);

        ## Si hay imagen para el contenido, se actualiza.
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'public/content';
            $imageFullPath = $image->store($imagePath);
            $imageNameArray = explode('/', $imageFullPath);
            $imageName = $imageNameArray[count($imageNameArray) - 1];

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
                'path' => $imagePath,
                'alt' => $image->getClientOriginalName(),
                'title' => $image->getClientOriginalName(),
                'is_private' => false,
            ]);

            $content->file_id = $file->id;
            $content->save();
        }

        return redirect()->back()->with([
            'message' => 'Se ha guardado correctamente',
            'alert_type' => 'danger',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
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
