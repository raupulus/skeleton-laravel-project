<form action="{{ $action }}" method="POST"
      id="{{$options['valueId'] . '-' . $id}}">
    @csrf_field()

    <input type="hidden" name="id" value="{{ $id }}">

    <button type="button"
            class="{{ $options['class'] }}"
            onclick="formSendConfirm(event, this, '' . $options['confirm'])">
        <i class="$options['icon']"></i>
        <span class="d-none d-md-inline-block">
            {{$options['text']}}
        </span>
    </button>
</form>
