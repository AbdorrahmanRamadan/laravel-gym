<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
</head>
<body class="hold-transition sidebar-mini">
     <div class="alert alert-danger">
          "Your account has been Banned. Please contact administrator"
     </div>

     <a class="dropdown-item" href="{{ route('logout') }}"
     onclick="event.preventDefault();
     document.getElementById('logout-form').submit();">
     {{ __('Logout') }}
     </a>

     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
     @csrf
     </form>
</body>
</html>