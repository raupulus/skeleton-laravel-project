@if (session()->has('flash_notification'))
    <?php $flash = session('flash_notification'); ?>
    <div class="alert alert-{{ $flash['level'] }} alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! $flash['message'] !!}
    </div>
    <?php session()->forget('flash_notification'); ?>
@endif


@if (isset($message))
    <div class="row mt-2 mb-2">
        <div class="col-12">
            {{-- Si es un array, por cada tipo de mensaje recorro sus elementos--}}
            @if (is_array($message))
                @foreach($message as $idx => $type)
                    @foreach($type as $text)
                        <div class="alert alert-{!! $idx !!} alert-dismissable">
                            <button type="button"
                                    class="close"
                                    aria-hidden="true">
                                &times;
                            </button>

                            <p>{!! $text !!}</p>
                        </div>
                    @endforeach
                @endforeach
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-dismissable alert-{{isset($alert_type) && $alert-type ? $alert : 'warning'}}">
                            <button type="button"
                                    class="close"
                                    aria-hidden="true">
                                &times;
                            </button>

                            <p>{!! $message !!}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
