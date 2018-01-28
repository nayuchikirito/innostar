<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Innovation Star | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('admin/plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js')}} IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js')}}"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href=""><b>Innovation</b>Star</a>
  </div>
  <!-- /.register-logo -->
  <div class="register-box-body">
    <p class="register-box-msg">Register</p>

  <form action="{{ url('/admin/clients') }}" method="POST" id="add-clients-form">
    {{ csrf_field() }}
      <input type="hidden" name="user_type" value="Client">
      <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Firstname" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="midname">Middle Name</label>
          <input type="text" class="form-control" id="midname" name="midname" placeholder="Enter Middlename" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Lastname" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="exampleInputPassword1">Confirm Password</label>
          <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password" autocomplete="false">
      </div>  
      <div class="form-group">
          <label for="location">Location</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="contact">Contact</label>
          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
    <div class="form-group pull-right">
      <button type="button" class="btn btn-danger" href="#">Back</button>
      <button type="submit" class="btn btn-success btn-gradient">Submit</button>
    </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
</body>
</html>
