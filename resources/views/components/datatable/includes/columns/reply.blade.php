@isset($reply)
    <td class="text-center">
        @if ($reply != null)
            <span class="badge badge-pill btn-success">{{t_('answered')}}   </span>
        @else
            <span class="badge badge-pill btn-warning">{{t_('not reply')}}  </span>
        @endif
    </td>
@endisset
