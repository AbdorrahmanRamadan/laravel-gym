<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
<style>
    body{
font-family: 'Ropa Sans', sans-serif;
margin-top: 30px;
background-color: #deb887 ;
text-align: center;
color: #fff;
}
.error-heading{
margin: 50px auto;
width: 250px;
border: 5px solid #fff;
font-size: 126px;
line-height: 126px;
border-radius: 30px;
text-shadow: 6px 6px 5px #000;
}
.error-heading img{
width: 100%;
}
.error-main h1{
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
<p>You do not have permission to access the document or program that you requested.</p>
<h4><a href="{{route('home')}}">Go Back</a></h4>
</div>
</body>
</html>
