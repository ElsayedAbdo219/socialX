<td class="">
  @if(isset($description))
  @foreach ($description as $key => $value)
  - {{ $value ?? "---" }}
  <br>

  @endforeach
  @elseif(isset($countries))
  @foreach ($countries as $country)
  - {{ $country ?? "---" }}
  <br>
  @endforeach
  @endif
</td>