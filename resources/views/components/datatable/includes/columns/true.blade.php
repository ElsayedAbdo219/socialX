@isset($value)
    <td class="text-center">
        @if ($value)
            <x-ui.badge :value="t_('true')" color="success"/>
        @else
            <x-ui.badge :value="t_('false')" color="danger"/>
        @endif
    </td>
@endisset
