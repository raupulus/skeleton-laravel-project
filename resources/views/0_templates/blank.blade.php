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
@section('active-index', 'active')

@section('content')
    @include('panel.layouts.breadcrumbs', [
        'breadcrumbs' => [
            [
                'title' => 'Test 1',
                'url' => route('panel-index'),
                'icon' => 'fa fa-star'
            ],
            [
                'title' => 'Test 2',
                'url' => route('panel-index'),
            ],
        ]
    ])
    <div class="row">
        <div class="col-12 mb-5">
            Página de pruebas en blanco
        </div>
    </div>
@endsection
