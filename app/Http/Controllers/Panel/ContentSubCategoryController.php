<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class ContentSubCategoryController extends Controller
{
    /**
     * LLeva a la vista para mostrar y gestionar categorías.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('panel.content.categories');
    }
}
