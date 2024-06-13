<td class="">
    @foreach ($description as $key => $value)
        

   - {!! json_encode($value) ?? "---"!!}
    <br>

    @endforeach
</td>