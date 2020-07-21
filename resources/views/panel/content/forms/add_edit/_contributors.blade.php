<div class="row">
    <div class="col-md-12 text-center">
        <h2>
            Contribuidores
        </h2>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th>Autor</th>
                <td>
                    {{ $content->user_id ? $content->user->name : auth()->user()->name }}
                </td>
            </tr>

            <tr>
                <th>Contribuidores</th>
                <td>
                    @forelse ($content->collaborators as $collaborator)
                        <p>
                            {{ $collaborator->name }} ({{ $collaborator->nick }})
                        </p>
                    @empty
                        No hay contribuidores.
                    @endforelse
                </td>
            </tr>
            </tbody>
        </table>

        <div class="text-center">
            <a href="#" class="btn btn-warning btn-block">
                <i class="fa fa-plus"></i>
                Añadir contribuidor
            </a>
            [ Restringir solo al propietario ]
        </div>
    </div>
</div>
