<div class="row">
    <div class="col-md-12 text-center">
        <h2>
            Estado
        </h2>
    </div>

    <div class="col-md-12">
        {!!
            FormHelper::select('status_id', $status, 'name',$content->status_id)
        !!}
    </div>
</div>
