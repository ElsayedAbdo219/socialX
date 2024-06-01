@if(isset($user) && $user instanceof \Illuminate\Database\Eloquent\Model)

    <div class="d-flex align-items-center">
        <div class="symbol symbol-50px me-3">
            <img src="{{$user->avatar}}" alt="{{$user->name}}">
        </div>
        <div class="d-flex justify-content-start flex-column">
            <span class="text-gray-400 fw-semibold d-block fs-7">{{$user->name}}</span>
            <span class="text-gray-400 fw-semibold d-block fs-7">
                @if ($user->active)
                    <x-ui.badge :value="t_('active')" color="success"/>
                @else
                    <x-ui.badge :value="t_('not active')" color="danger"/>
                @endif
            </span>
            <a href="mailto:{{$user->email}}" class="text-gray-800 fw-bold text-hover-primary fw-semibold mb-1 fs-6">{{$user->email}}</a>
        </div>
    </div>

@endisset
