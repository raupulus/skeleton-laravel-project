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
                'icon' => 'fas fa-users'
            ],
            [
                'title' => $nick,
                'icon' => 'fas fa-user'
            ],
        ]
    ])

    <div class="row">
        <div class="col-12 image-section">
            <img src="{{ asset('images/users/profile-backgrounds/default.jpg') }}"
                 title="Background Profile"
                 alt="Background Profile" />
        </div>

        <div class="row user-left-part">
            @include('panel.users.layouts._sidebar_left')

            {{-- Contenido --}}
            <div class="col-12 col-md-9 pull-right profile-right-section">
                <div class="row profile-right-section-row">
                    <div class="col-md-12 profile-header">
                        <div class="row">
                            <div class="col-6 col-md-8 profile-header-section1 pull-left">
                                <h1>{{ $user->name }} | {{ $user->nick }}</h1>
                                <h5>{{ $user->role->name }}</h5>
                                <p>
                                    <example-component></example-component>
                                </p>
                            </div>
                            <div class="col-6 col-md-4 profile-header-section1 text-right pull-rigth">
                                @foreach($user->social as $social)
                                    <a href="{{ $social->personal->url }}"
                                       title="{{ $social->name }}"
                                       style="color: {{ $social->color }};" >
                                        <i class="{{ $social->icon }}"></i>
                                    </a>
                                @endforeach
                            </div>

                            <style>
                                .profile-header-section1 a:hover {
                                    background-color: transparent;
                                    text-decoration: none;
                                }

                                .profile-header-section1 a i.fa,
                                .profile-header-section1 a i.fas {
                                    padding: 5px 8px;
                                    font-size: 2.4rem;
                                    border-radius: 3px;
                                }

                                .profile-header-section1 a i.fa:hover,
                                .profile-header-section1 a i.fas:hover {
                                    background-color: #343A40;
                                }
                            </style>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" role="tablist">
                                    @if ($user->data)
                                        <li class="nav-item">
                                            <a class="nav-link active"
                                               href="#profile"
                                               role="tab"
                                               data-toggle="tab">
                                                <i class="fas fa-user-circle"></i>
                                                Perfil
                                            </a>
                                        </li>
                                    @endif

                                    @if ($user->details)
                                        <li class="nav-item">
                                            <a class="nav-link"
                                               href="#details"
                                               role="tab"
                                               data-toggle="tab">
                                                <i class="fas fa-info-circle"></i>
                                                Detalles
                                            </a>
                                        </li>
                                    @endif

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
                                    @includeWhen($user->data, 'panel.users.layouts._content_profile')
                                    @includeWhen($user->details, 'panel.users.layouts._content_details')
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
