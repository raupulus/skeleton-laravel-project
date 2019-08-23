@extends('panel.layouts.app')

{{-- Descripción sobre esta página --}}
@section('title', 'Viendo usuario ' . $nick)
@section('description', 'Vista individual del usuario ' . $nick)

{{-- Marca el elemento del menú que se encuentra activo --}}
@section('active-users', 'active')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Usuarios',
                'url' => route('panel.users.index'),
                'icon' => 'fa fa-people'
            ],
            [
                'title' => $nick,
                'url' => route('panel.index'),
            ],
        ]
    ])

    <div class="row">
        <div class="col-12 image-section">
            <img src="https://png.pngtree.com/thumb_back/fw800/back_pic/00/08/57/41562ad4a92b16a.jpg">
        </div>

        <div class="row user-left-part">
            @include('panel.users.layouts._sidebar_left')

            {{-- Contenido --}}
            <div class="col-12 col-md-9 pull-right profile-right-section">
                <div class="row profile-right-section-row">
                    <div class="col-md-12 profile-header">
                        <div class="row">
                            <div class="col-6 col-md-8 profile-header-section1 pull-left">
                                <h1>Juan Perez</h1>
                                <h5>Developer</h5>
                            </div>

                            <div class="col-6 col-md-4 profile-header-section1 text-right pull-rigth">
                                Text Right
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           href="#profile"
                                           role="tab"
                                           data-toggle="tab">
                                            <i class="fas fa-user-circle"></i>
                                            Perfil
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="#details"
                                           role="tab"
                                           data-toggle="tab">
                                            <i class="fas fa-info-circle"></i>
                                            Detalles
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="#social"
                                           role="tab"
                                           data-toggle="tab">
                                            <i class="fas fa-info-circle"></i>
                                            Redes Sociales
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    @include('panel.users.layouts._content_profile')
                                    @include('panel.users.layouts._content_details')
                                    @include('panel.users.layouts._content_social')
                                </div>
                            </div>

                            @include('panel.users.layouts._sidebar_right')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
