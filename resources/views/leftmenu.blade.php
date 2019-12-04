<div class="col-lg-2 left-menu">
    <div>
        <div class="avatar">
            <img src="imgs/avatar_icon.jpg" alt="avatar" class="rounded-circle" height="45" width="45">
        </div>
        <div class="name-display">
            {{Auth::user()->name}}
        </div>
    </div>
    <div class="menu-display">
        @if(Auth::user()->admin_flag == 1)
            <nav class="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin')}}"><i class="fa fa-tasks"></i>Project Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('DisplayMember')}}">
                            <i class="fa fa-calendar-check-o"></i>Member Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/logout')}}"><i class="fa fa-sign-out"></i>Logout</a>
                    </li>
                </ul>
            </nav>
        @else
        <nav class="navbar">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>Task Management</a>
                    <div class="dropdown-menu">
                        <a class="nav-link" href="{{route('taskmanagement')}}">Kanban</a>
                        <a class="nav-link" href="#">Report</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('holidaymanagement')}}">
                        <i class="fa fa-calendar-check-o"></i>Holiday Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('changepassword')}}"><i class="fa fa-unlock"></i>Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/logout')}}"><i class="fa fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
    <div class="calendar-display">
        <div class="time-text">
            <span id="hr">00</span>
            <span>:</span>
            <span id="min">00</span>
            <span>:</span>
            <span id="sec">00</span>
            <span id="suffix">--</span>
        </div>
        <?php
        if (!empty($calendar)) {
            echo $calendar->show();
        }
        ?>
    </div>
</div>
