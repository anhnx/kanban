@include('header')
@if(isset(Auth::user()->email))
    <div id="dashboard" class="container-fluid">
        <div class="row">
            @include('leftmenu')
            <div class="col-lg-10">
                <div id="content-header"> Working Time Management System</div>
                <div id="content" class="content-home">
                    <!-- Member Admin start -->
                    <div id="admin-management">
                        <h6 class="h6-top"><i class="fa fa-users" style="font-size: 18px;padding-right: 5px"></i>
                            Member Management</h6>
                    </div>
                    <div id="member-list" class="col-lg-12">
                        <form action="{{route('DeleteMember')}}" method="post">
                            {{csrf_field()}}
                            <table id="members-table" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Select</th>
                                    <th style="text-align: center">Member ID</th>
                                    <th style="text-align: center">Member Name</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Birthday</th>
                                    <th style="text-align: center">Leader</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($memberList as $member)
                                    @if($member->admin_flag != '1')
                                        <tr>
                                            <td style="text-align: center;padding-top: 9px">
                                                <input name="member-list[]" type="checkbox" value="{{$member->id}}">
                                            </td>
                                            <td>
                                                {{$member->id}}
                                            </td>
                                            <td>
                                                {{$member->name}}
                                            </td>
                                            <td>
                                                {{$member->email}}
                                            </td>
                                            <td>
                                                {{$member->birthday}}
                                            </td>
                                            <td>
                                                @if($member->leader != 0)
                                                    {{$member->getNameByID($member->leader)}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row my-holiday-action">
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal"
                                            data-target="#AddMemberModal">Add</button>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-secondary btn-block"
                                                name="action" value="delete"
                                                onclick="return getChecked('member-list[]')">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Add project modal -->
                        <div id="AddMemberModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Register Member</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('AddMember')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="member-name" class="label name">Name:</label>
                                                    <input id="member-name" name="member-name" type="text" placeholder="Name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="member-email" class="label email">Email:</label>
                                                    <input id="member-email" name="member-email" type="text" placeholder="Email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="member-address" class="label address">Address:</label>
                                                    <input id="member-address" name="member-address" type="text" placeholder="Address" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label class="label birthday" for="birthday" >Birthday:</label>
                                                    <input id = "birthday" name="birthday" type="text" class="form-control
                                    datepicker" placeholder="Birthday" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="position" class="label position">Position:</label>
                                                    <select class="form-control" id="position" name="position" onchange="positionChange()">
                                                        <option value="1">Member</option>
                                                        <option value="2">Leader</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="leader-id" class="label leader-id">Leader:</label>
                                                    <select class="form-control" id="leader-id" name="leader-id">
                                                        @foreach($memberList as $member)
                                                            @if($member->admin_flag != '1')
                                                                <option value="{{$member->id}}">{{$member->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center">
                                                <button type="submit" class="btn btn-secondary" >Register</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add project modal end-->
                    </div>
                    <!-- Member Admin End -->
                    <h6 class="h6-top"><i class="fa fa-file-excel-o" style="font-size: 18px;padding-right: 5px"></i>
                        Time Sheet Export</h6>
                    <div id="export" class="col-lg-12" style="margin-top: 20px">
                        <form action="{{route('Export')}}" method="post">
                            {{csrf_field()}}
                            <div class="row">
                            <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="member-select" class="label">Member:</label>
                                    <select name="member-select" id="member-select" class="form-control">
                                        <option value="0">All Member</option>
                                        @foreach($memberList as $member)
                                            @if($member->admin_flag != '1' && (session('member-select') == $member->id))
                                                <option value="{{$member->id}}" selected>{{$member->name}}</option>
                                            @elseif($member->admin_flag != '1')
                                                <option value="{{$member->id}}">{{$member->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="start-day" class="label" style="padding-left: 30px">Time :</label>
                                    <input id="start-day" name="start-day" type="text" class="form-control datepicker
                                    task-start-day" placeholder="From" value="{{session('start-day')}}" autocomplete="off" required>
                                    <span class="span">~</span>
                                    <input id = "end-day" name="end-day" type="text" class="form-control datepicker"
                                           placeholder="To" value="{{session('end-day')}}" autocomplete="off" required>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-lg-6 export-type">
                                <div class="form-check-inline">
                                    <label for="worktime" class="form-check-label" style="padding-right: 50px">
                                        <input type="radio" class="form-check-input" id="worktime" name="export-type"
                                               value="1" checked>Working Time
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label for="holiday" class="form-check-label">
                                        <input type="radio" class="form-check-input" id="holiday" name="export-type"
                                               value="2">Holidays
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 offset-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="submit" class="btn btn-outline-secondary btn-block btn-export"
                                               value="Export">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('admin')}}'</script>
@endif
@include('footer')

