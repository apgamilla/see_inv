<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anazel Website</title>
    <link rel="shortcut icon" href="https://anazel.herokuapp.com/public/assetsassets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://anazel.herokuapp.com/public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://anazel.herokuapp.com/public/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://anazel.herokuapp.com/public/assets/css/app.css">
    <link rel="stylesheet" href="https://anazel.herokuapp.com/public/assets/css/pages/auth.css">
    {{-- message toastr --}}
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    
    
</head>
<style>
    .form-group[class*=has-icon-].has-icon-left .form-select {
    padding-left: 2.5rem;
}
</style>

<body>
   @yield('content')
</body>
</html>
