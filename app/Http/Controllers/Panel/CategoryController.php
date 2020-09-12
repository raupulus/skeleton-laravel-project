<?php

namespace App\Http\Controllers\Panel;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CategoryRequest;
use FlashHelper;
use Illuminate\Http\Request;
use function redirect;

class CategoryController extends Controller
{
    ## Mensajes de respuesta.
    private $msg_store_success = 'Se ha añadido correctamente la categoría';
    private $msg_store_error = 'Ha ocurrido un error al guardar la categoría';


    /**
     * Crea una nueva categoría con los datos recibidos ya validados.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::store($request);

        if ($category) {
            FlashHelper::success($this->msg_store_success);
        } else {
            FlashHelper::error($this->msg_store_error);
        }

        return redirect()->back();
    }

    /**
     * Actualiza los datos de una categoría ya existente.
     *
     * @param \App\Http\Requests\Panel\CategoryRequest $request
     * @param int                                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, int $id)
    {
        $category = Category::store($request, $id);

        if ($category) {
            FlashHelper::success($this->msg_store_success);
        } else {
            FlashHelper::error($this->msg_store_error);
        }

        return redirect()->back();
    }
}
