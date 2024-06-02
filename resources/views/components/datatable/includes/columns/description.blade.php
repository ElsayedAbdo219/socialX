@isset($description)
<td class="">
    {!! mb_strimwidth(remove_style($description), 0, 40, "...") !!}
</td>
@endisset
