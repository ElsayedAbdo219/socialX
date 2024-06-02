<td class="">
    <button type="button" id="modalButton" data-type="{{$type}}"
            class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#modal-{{ $type }}"
            onclick="selectCaptain({{$model->id}} , {{ $type }})">
        {{ $title }}
    </button>
</td>

<div class="modal fade" tabindex="-1" id="modal-{{ $type }}">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>

