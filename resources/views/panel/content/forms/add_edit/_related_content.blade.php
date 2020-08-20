<div class="row mt-4">
    <div class="col-md-12 text-center">
        <h2>
            Contenido Relacionado
        </h2>
    </div>

    <div class="col-md-12">
        @forelse($content->subcategories as $subcategory)
            <span class="badge badge-pill badge-info">
                {{ $subcategory->name }}
                <i class="fa fa-close"></i>
            </span>
        @empty
            No hay contenido asociado.
        @endforelse
    </div>

    <div class="col-md-12">
        <a href="#" class="btn btn-secondary btn-block">
            <i class="fa fa-plus"></i>
            Asociar Contenido
        </a>
    </div>
</div>
