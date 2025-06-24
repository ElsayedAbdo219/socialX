@if ($video)
  <video style="width: 150px;height: 150px; border-radius: 8px;" controls>
    <source src="{{ $video }}" type="{{ $type }}">
    المتصفح لا يدعم الفيديو.
  </video>
@else
  <span>لا يوجد فيديو</span>
@endif