<div class="row">
    <div class="col-md-12 text-center">
        <h2>
            Etiquetas
        </h2>
    </div>

    <div class="col-md-12">
        @forelse($content->tags as $tag)
            <span class="badge badge-pill badge-info">
                {{ $tag->name }}
                <i class="fa fa-close"></i>
            </span>
        @empty
            No hay subcategorías asociadas.
        @endforelse
    </div>

    <div class="col-md-12">
        <a href="#" class="btn btn-secondary btn-block">
            <i class="fa fa-plus"></i>
            Añadir etiquetas
        </a>
    </div>
</div>
