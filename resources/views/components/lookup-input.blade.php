<div>
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
    <div class="form-group">
        <label for="{{ $id }}">{{ $label }}</label>
        <div class="d-flex align-items-center">
            <input type="text" name="{{ $name }}" id="{{ $id }}" hidden
                value="{{ $menu != null ? $menu->id : '' }}">
            <input type="text" disabled class="form-control" id="{{ $id }}_label"
                placeholder="{{ $placeholder }}" value="{{ $menu != null ? $menu->name : '' }}">
            <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                data-target="#{{ $modalId }}"><i class="fas fa-search"></i></button>
        </div>
    </div>
</div>
