<div class="col-xl-3 col-sm-6 mb-3">
    <div {{ $id ? 'id='.$id : '' }}
         class="{{ $class }} card text-white {{ $color }} o-hidden h-100">
        <div class="card-body">
            <div class="card-body-icon">
                <i class="{{ $icon }}"></i>
            </div>

            <div class="mr-5">
                {{ $title }}
            </div>
        </div>
        <a class="card-footer text-white clearfix small z-1"
           href="{{ $url }}"
           title="{{ $titleUrl }}">
            <span class="float-left">
                {{ $titleUrl }}
            </span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
        </a>
    </div>
</div>
