@isset($model)
    <div class="form-check form-switch form-check-custom form-check-solid">
        <input class="form-check-input btn-trigger" type="checkbox" value="" data-id="{{data_get($model,'id')}}" data-route="{{$route ?? null}}"
               data-type="{{$column ?? 'active'}}"
               id="toggle_{{data_get($model,'id')}}" {{data_get($model,$column ?? "active") ? "checked":""}}/>
        <label class="form-check-label" for="toggle_{{data_get($model,'id')}}"> </label>
    </div>
@endisset
