<div class="image">
  <img src='{{ url('dist/img/avatar5.png')}}' class="img-circle elevation-2" alt="User Image">
</div>
<div class="info">

  <a  href="{{ route('logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
      Logout {{ auth()->user()->name }}
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
  </form>
</div>
