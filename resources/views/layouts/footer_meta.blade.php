{{-- JQuery --}}
<script src="{{ asset('assets/js/jquery.js') }}"></script>

{{-- jquery.easing --}}
{{--
<script src="{{ mix('assets/js/jquery.easing.js') }}"></script>
--}}

{{-- Popper.js --}}
<script src="{{ mix('assets/js/popper.js') }}"></script>

{{-- Boostrap JS --}}
<script src="{{ mix('assets/js/bootstrap.js') }}"></script>

{{-- Fontawesome --}}
<script src="{{ mix('assets/js/fontawesome.js') }}"></script>

{{-- Mis funciones generales --}}
<script src="{{ mix('js/functions.js') }}"></script>

{{-- Widgets Propios --}}
<script src="{{ mix('js/widgets.js') }}"></script>

{{-- Scripts que serán reemplazados por algunas páginas --}}
@section('footer-js-custom')
    {{-- DataTables --}}
    <script src="{{ mix('assets/js/datatables.js') }}"></script>

    {{-- Chart.js --}}
    <script src="{{ mix('assets/js/chart.js') }}"></script>

    <script src="{{ mix('js/scripts.js') }}"></script>
@show
