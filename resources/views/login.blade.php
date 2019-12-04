<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Timesheet Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container box">
    @if(isset(Auth::user()->email))
        @if(Auth::user()->admin_flag == '1')
            <script> window.location.href='{{route('admin')}}'</script>
        @else
            <script> window.location.href='{{route('taskmanagement')}}'</script>
        @endif
    @endif
    <div class="login-form">
        <form method="post" action="{{ url('/checklogin') }}">
            {{ csrf_field() }}
            <h2 class="text-center">Sign In</h2>
            @if ($message = Session::get('error'))
            <div class="form-group text-danger" align="center">
                {{ $message }}
            </div>
            @endif
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input name = "email" type="text" class="form-control" placeholder="Username" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <input name="password" type="password" class="form-control" placeholder="Password" required="required">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
            <div class="clearfix">
                <a href="#" class="pull-right">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
