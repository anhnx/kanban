@include('header')
@if(isset(Auth::user()->email))

    <div id="dashboard" class="container-fluid">
        <div class="row">
            @include('leftmenu')
            <div class="col-lg-10 right-menu">
                <div id="content-header"> Working Time Management System</div>
                <div id="content" class="content-home">
                    <!-- change password Start-->
                    <div id="task-management">
                        <div class="changepassword-form">
                            <form method="post" action="{{ route('ActionChange') }}">
                                {{ csrf_field() }}
                                <h2 class="text-center">Change Password</h2>
                                @if ($status = Session::get('status'))
                                    @if($status == 'OK')
                                        <div class="form-group text-success" align="center">
                                            {{ "Password has been changed successful!" }}
                                        </div>
                                    @else
                                        <div class="form-group text-danger" align="center">
                                            {{ "Password and Password confirm is not equal." }}
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input name="password" type="password" class="form-control" placeholder="New Password" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input name="password-confirm" type="password" class="form-control" placeholder="New Password Confirm" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Change password End -->
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('home')}}'</script>
@endif
@include('footer')
