@extends('panel.layouts.app')

@section('title', 'Panel Admin - Dashboard')

@section('content')
    @include('panel.layouts.breadcrumbs')
    <div class="row">
        <div class="col-12">

            <br />

            <div class="text-center">
                <h3>Viendo Archivos en la galería: {{$type}}</h3>
            </div>

            <br />
            <br />

            <iframe src="{{url('filemanager?type='. $type)}}"
                    style="width: 100%; height: 800px; overflow: hidden;
                    border: none;"></iframe>

            {{--
            <div class="input-group">
               <span class="input-group-btn">
                 <a id="lfm" data-input="thumbnail" data-preview="holder"
                    class="btn btn-primary">
                   <i class="fa fa-picture-o"></i> Choose
                 </a>
               </span>

               <input id="thumbnail" class="form-control" type="text"
                       name="filepath">
            </div>

            <img id="holder" style="margin-top:15px;max-height:100px;" />
            --}}
        </div>
    </div>
@endsection

@section('js')
    {{--

<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}'"></script>

<script>
$('#lfm').filemanager('files');
//$('#lfm').filemanager('images');
//$('#lfm').filemanager('posts');
</script>
--}}
@endsection
