@isset($active)
    <td class="text-center">
        @if ($active == true  && $active != 'pending' && $active != 'cancelled' && $active != 'approved')
            <span class="badge badge-success text-white">{{__('dashboard.active')}}</span>
            @elseif($active === 'pending')
            <span class="badge badge-warning text-white">{{__('dashboard.pending')}}</span>
            @elseif($active === 'cancelled')
            <span class="badge badge-secondary text-white">{{__('dashboard.cancelled')}}</span>
            @elseif($active === 'approved')
            <span class="badge badge-info text-white">{{__('dashboard.approved')}}</span>
        @else
            <span class="badge badge-danger text-white">{{__('dashboard.inactive')}}</span>
        @endif
    </td>
@endisset
