@foreach (['danger','warning','success','info'] as $item)
 @if (session()->has($item))
 <div class="flash-message">
  <p class="alert alert-{{ $item }}">
  {{ session()->get($item) }}
  </p>
  </div>
 @endif
@endforeach
