@isset($scan_qr_type)
    <td class="text-center">
        @if ($scan_qr_type)
            <span class="badge badge-success text-white">{{scan_qr_type}}</span>
        @endif
    </td>
@endisset