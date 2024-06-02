@isset($stars)
    <td class="">
        @foreach(range(1,5) as $i)
            <span class="fa-stack" style="width:1em">
                    <i class="far fa-star fa-stack-1x btn-outline-warning"></i>

                 @if($stars >0)
                    @if($stars >0.5)
                        <i class="fas fa-star fa-stack-1x btn-outline-warning"></i>
                    @else
                        <i class="fas fa-star-half fa-stack-1x btn-outline-warning"></i>
                    @endif
                @endif
                @php $stars--; @endphp
            </span>
        @endforeach
    </td>
@endisset
