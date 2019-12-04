@include('header')
@if(isset(Auth::user()->email))

    <div id="dashboard" class="container-fluid">
        <div class="row">
            @include('leftmenu')
            <div class="col-lg-10">
                <div id="content-header"> Working Time Management System</div>
                <div id="content" class="content-home">
                    <div id="welcome" >
                        {{'Hello '.Auth::user()->name."."}}
                        @if($msg = Session::get('msg'))
                            {{$msg}}
                        @endif
                        <a id="end-day" href="{{url()->current()}}" onclick="endday()">
                            End Day
                        </a>
                    </div>
                    <!-- Holiday Management start -->
                    <div id="vacation-management">
                        <h6 class="h6-top"><i class="fa fa-calendar-check-o" style="font-size: 18px;padding-right: 5px"></i>
                            Holiday Management</h6>
                        <h6 class="text-left h6-sub"><i class="fa fa-calendar-check-o" style="font-size: 18px;padding-right: 5px"></i>
                            My Holidays</h6>
                        <div id="my-vacation" class="col-lg-12">
                            <form action="{{route('addHolidays')}}" method="post">
                                {{csrf_field()}}
                                <table id="holidays-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 15%;text-align: center">Select</th>
                                        <th style="width: 15%;text-align: center">Day Off</th>
                                        <th style="width: 15%;text-align: center">Time</th>
                                        <th style="width: 40%;text-align: center">Reason</th>
                                        <th style="width: 15%;text-align: center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($vacation->isEmpty())
                                        <tr>No Holidays</tr>
                                    @else
                                        @foreach($vacation as $vac)
                                            <tr>
                                                <td style="text-align: center;padding-top: 10px">
                                                    <input name="my-holiday[]" type="checkbox" value="{{$vac->id}}">
                                                </td>
                                                <td>
                                                    @if($vac->vacation_start_day == $vac->vacation_end_day)
                                                        {{$vac->vacation_start_day}}
                                                    @else
                                                        {{$vac->vacation_start_day.'~'.$vac->vacation_end_day}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($vac->vacation_time == '1')
                                                        {{'All Day'}}
                                                    @elseif($vac->vacation_time == '2')
                                                        {{'Morning'}}
                                                    @else
                                                        {{'Afternoon'}}
                                                    @endif
                                                </td>
                                                <td>{{$vac->vacation_reason}}</td>
                                                <td>
                                                    @if($vac->leader_accepted == '1')
                                                        {{'Accepted'}}
                                                    @elseif($vac->leader_accepted == '0')
                                                        {{'Decline'}}
                                                    @else
                                                        {{'Not yet'}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="row my-holiday-action">
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal"
                                                data-target="#AddHolidayModal">Add</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-secondary btn-block" name="action" value="delete"
                                                    onclick="return getChecked('my-holiday[]')">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Add holidays modal -->
                            <div id="AddHolidayModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Register Holidays</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('addHolidays')}}" method="post">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label id="vacation-date" for="start_date" >Vacation Date:</label>
                                                        <input id = "start_date" name="start_date" type="text" class="form-control
                                    datepicker" placeholder="From" autocomplete="off">
                                                        <span class="span">~</span>
                                                        <input id="end_date" name="end_date" type="text" class="form-control
                                    datepicker" placeholder="To" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label id="reason-label" for="reason">Reason:</label>
                                                        <input name="vacation-reason" type="text" placeholder="input reason here" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label id = "time-label" for="vacation-time">Time:</label>
                                                        <select class="form-control" id="vacation-time" name="vacation-time">
                                                            <option value="1">All Day</option>
                                                            <option value="2">Morning</option>
                                                            <option value="3">Afternoon</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="text-align: center">
                                                    <button type="submit" class="btn btn-secondary" name="action" value="register">Register</button>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->position == 'L')
                            <h6 class="text-left h6-sub"><i class="fa fa-calendar-check-o" style="font-size: 18px;padding-right: 5px"></i>
                                Member Holidays List</h6>
                            <div id="confirm-vacation" class="col-lg-12">
                                <form action="{{route('ConfirmHoliday')}}" method="post">
                                    {{csrf_field()}}
                                    <table id="holidays-table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;text-align: center">Select</th>
                                            <th style="width: 15%;text-align: center">Day Off</th>
                                            <th style="width: 15%;text-align: center">Time</th>
                                            <th style="width: 20%;text-align: center">Member</th>
                                            <th style="width: 25%;text-align: center">Reason</th>
                                            <th style="width: 15%;text-align: center">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($holidayConfirmLst->isEmpty())
                                            <tr>No Confirm Holidays</tr>
                                        @else
                                            @foreach($holidayConfirmLst as $holiday)
                                                <tr>
                                                    <td style="text-align: center;padding-top: 10px">
                                                        <input name="holiday-confirm[]" type="checkbox" value="{{$holiday->id}}">
                                                    </td>
                                                    <td>
                                                        @if($holiday->vacation_start_day == $holiday->vacation_end_day)
                                                            {{$holiday->vacation_start_day}}
                                                        @else
                                                            {{$holiday->vacation_start_day.'~'.$holiday->vacation_end_day}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($holiday->vacation_time == '1')
                                                            {{'All Day'}}
                                                        @elseif($holiday->vacation_time == '2')
                                                            {{'Morning'}}
                                                        @else
                                                            {{'Afternoon'}}
                                                        @endif
                                                    </td>
                                                    <td>{{Auth::user()->getNameByID($holiday->member_id)}}</td>
                                                    <td>{{$holiday->vacation_reason}}</td>
                                                    <td>
                                                        @if($holiday->leader_accepted == '1')
                                                            {{'Accepted'}}
                                                        @elseif($holiday->leader_accepted == '0')
                                                            {{'Decline'}}
                                                        @else
                                                            {{'Not yet'}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="row my-holiday-action">
                                        <div class="col-lg-3">
                                            <button type="submit" name="action" value="accept" class="btn btn-outline-secondary
                                    btn-block" onclick="return getChecked('holiday-confirm[]')">Accept</button>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" name="action" value="decline" class="btn btn-outline-secondary
                                    btn-block" onclick="return getChecked('holiday-confirm[]')">Decline</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    <!-- Holiday Management End -->
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('home')}}'</script>
@endif
@include('footer')

