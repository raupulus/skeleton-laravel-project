@if ($errors->any() || session()->has('flash_notification'))
    <div>
        @include('panel.alerts.errors')
        @include('panel.alerts.forms')
        @include('panel.alerts.notifications')
    </div>
@endif
