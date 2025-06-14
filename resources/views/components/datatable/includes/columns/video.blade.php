@if ($video)
  <video style="width: 150px;height: 150px" controls>
    <source src="{{ $video }}" type="{{ $type }}">
    المتصفح لا يدعم الفيديو.
  </video>
@else
  <span>لا يوجد فيديو</span>
@endif