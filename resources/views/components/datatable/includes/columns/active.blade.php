@isset($active)
    <td class="text-center">
        @if ($active)
            <span class="badge badge-success text-white">{{__('dashboard.active')}}</span>
        @else
            <span class="badge badge-danger text-white">{{__('dashboard.inactive')}}</span>
        @endif
    </td>
@endisset
