@extends('layouts.app')

{{-- Descripción sobre esta página --}}
@section('title', '')
@section('description', '')
@section('keywords', '')

{{-- Etiquetas para Redes sociales --}}
@section('rs-title', '')
@section('rs-sitename', '')
@section('rs-description', '')
@section('rs-image', '')
@section('rs-url', '')
@section('rs-image-alt', '')

@section('twitter-site', '')
@section('twitter-creator', '')

{{-- Marca el elemento del menú que se encuentra activo --}}
@section('active-service', 'active')

@section('content')
    @include('layouts.breadcrumbs')

    <div class="row mt-5 mb-5">
        <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">
                    Título de sección
                </h1>

                <p class="lead my-3">
                    Multiple lines of text that form the lede, informing new
                    readers quickly and efficiently about what's most
                    interesting in this post's contents.
                </p>

                <p class="lead mb-0">
                    <a href="#" class="text-white font-weight-bold">
                        Continuar leyendo...
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-5">

            @foreach(range(1, 4) as $num)
                <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">
                            Etiqueta 1, Etiqueta 2
                        </strong>

                        <h3 class="mb-0">
                            <a class="text-dark" href="#">
                                Título del POST
                            </a>
                        </h3>

                        <div class="mb-1 text-muted">
                            Agosto 4
                        </div>

                        <p class="card-text mb-auto">
                            This is a wider card with supporting text below as a
                            natural lead-in to additional content.
                        </p>

                        <a href="#">
                            Continuar Leyendo
                        </a>
                    </div>

                    <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16c655311e8%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16c655311e8%22%3E%3Crect%20width%3D%22200%22%20height%3D%22250%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2255%22%20y%3D%22131%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                </div>
            @endforeach

        </div>

        <div class="col-md-4 mb-5">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
