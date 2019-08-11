<!DOCTYPE html>
<!--
@author Raúl Caro Pastorino
@copyright Copyright (c) 2019 Raúl Caro Pastorino
@license https://www.gnu.org/licenses/gpl-3.0-standalone.html

Author Web: https://fryntiz.es
E-mail: dev@fryntiz.es
-->

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        @include('layouts.head_meta')
        @yield('head_css')
        @yield('head_javascript')
    </head>

    <body>
         @include('layouts.navbar')

         @yield('header')

         <div id="app" class="container">
             @yield('content')
         </div>

         @include('layouts.footer')
         @include('layouts.footer_meta')
         @yield('css')
         @yield('javascript')
         @yield('js')
    </body>
</html>
