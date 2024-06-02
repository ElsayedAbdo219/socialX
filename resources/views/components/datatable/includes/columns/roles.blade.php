@isset($roles)

    <td class="text-center">
        @forelse($roles as $role)
            <x-ui.badge :value="$role->name" color="success"/>
        @empty
            <x-ui.badge :value="t_('not have any role')" color="danger"/>
        @endforelse
    </td>

@endisset
