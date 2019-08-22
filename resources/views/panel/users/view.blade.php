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
                                <a href="{{route('panel.users.add')}}"
                                   class="btn btn-dark btn-block">
                                    <i class="fas fa-user-edit"></i>
                                    Editar Perfil
                                </a>
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
                                           href="#buzz"
                                           role="tab"
                                           data-toggle="tab">
                                            <i class="fas fa-info-circle"></i>
                                            Detalles
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel"
                                         class="tab-pane fade show active"
                                         id="profile">

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>ID</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>509230671</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Nombre</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Juan Perez</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>juanp@gmail.com</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Teléfono</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>12345678</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Profesion</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Developer</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel"
                                         class="tab-pane fade"
                                         id="buzz">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Experience</label>
                                            </div>

                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hourly Rate</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>10$/hr</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Projects</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>230</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>English Level</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Availability</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>6 months</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Your Bio</label>
                                                <br/>
                                                <p>Your detail description</p>
                                            </div>
                                        </div>
                                    </div>
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
