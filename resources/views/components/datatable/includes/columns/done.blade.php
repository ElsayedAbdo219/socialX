
    @if($done)
        <x-ui.badge value="<i class='las la-check-circle fs-2x text-success'></i>" color="success"/>
    @else
        <x-ui.badge value="<i class='las la-times-circle fs-2x  text-danger'></i>" color="danger"/>

    @endif

