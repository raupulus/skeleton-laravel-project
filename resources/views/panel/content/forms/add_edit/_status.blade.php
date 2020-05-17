<div class="row">
    <div class="col-md-12 text-center">
        <h2>
            Estado
        </h2>
    </div>

    <div class="col-md-12">
        <select name="status_id" class="form-control selectpicker">
        @foreach($status as $state)
            <option value="{{ $state->id }}">
                {{ $state->name }}
            </option>
        @endforeach
        </select>
    </div>
</div>
