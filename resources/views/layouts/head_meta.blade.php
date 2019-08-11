{{-- Bootstrap --}}
<link href="{{ mix('assets/css/bootstrap.css') }}" rel="stylesheet" />

{{-- Font Awesome --}}
<link href="{{ mix('assets/css/fontawesome.css') }}" rel="stylesheet" />

{{-- Fuentes de meteorología https://erikflowers.github.io/weather-icons/ --}}
<link href="{{ mix('assets/css/weather-icons.css') }}" rel="stylesheet" />

{{-- Estilos Propios --}}

{{-- Estilos que serán reemplazados por algunas páginas --}}
@section('head-css-custom')
    <link href="{{ mix('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ mix('css/widgets.css') }}" rel="stylesheet" />
    <link href="{{ mix('assets/css/datatables.css') }}" rel="stylesheet" />
@show
