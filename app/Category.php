<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function array_filter;
use function dd;
use function in_array;

class Category extends Model
{
    ## Atributos que se pueden asignar al modelo.
    protected $fillable = [
        'name',
        'file_id',
        'description',
        'icon',
        'color',
        'slug',
    ];

    /**
     * Relación con las subcategorías asociadas a esta categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }

    /**
     * Procesa el guardado de
     *
     * @param \Illuminate\Http\Request $request
     * @param numeric                  $id  Recibe el id de la categoría.
     */
    public static function store(Request $request, int $id = null)
    {
        if ($id) {
            $category = Category::find($id);
        } else {
            $category = new Category();
        }

        $fillable = $category->fillableFromArray($request->all());

        dd($fillable);

        /*
        $data = array_filter($request->all(), function ($ele) use ($fillable){
            return in_array($ele, $fillable);
        });
        */

        if ($request->hasFile('image')) {
            // TODO → Guardar imagen y crear entrada en files


            // $data['file_id'] = $file->id;

        }



        dd($data, $fillable);


        $category = self::updateOrCreate($request->all());
        
        
        dd($data, $category);
    }
}
