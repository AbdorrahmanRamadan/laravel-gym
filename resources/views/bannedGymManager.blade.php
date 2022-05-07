<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
    <style>
        body {
            font-family: 'Ropa Sans', sans-serif;
            margin-top: 30px;
            background-color: #deb887;
            text-align: center;
            color: #fff;
        }


        .error-heading {
            margin: 50px auto;
            width: 250px;
            border: 5px solid #fff;
            font-size: 126px;
            line-height: 126px;
            border-radius: 30px;
            text-shadow: 6px 6px 5px #000;
        }

        .error-heading img {
            width: 100%;
        }

        .error-main h1 {
            font-size: 72px;
            margin: 0px;
            color: #f0f0f0;
            text-shadow: 0px 0px 5px #fff;
        }
    </style>
</head>

<body>
    <div class="error-main">
        <h1>Oops!</h1>
        <div class="error-heading">403</div>
        <p>You do not have permission to access the document or program that you requested since you are Banned by City manager or Admin .</p>
            <a class="btn btn-dark" href="{{ route('logout') }}" onclick="event.preventDefault();
     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>

</html>
