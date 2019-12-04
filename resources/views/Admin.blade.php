@include('header')
@if(isset(Auth::user()->email))
    <div id="dashboard" class="container-fluid">
        <div class="row">
            @include('leftmenu')
            <div class="col-lg-10">
                <div id="content-header"> Working Time Management System</div>
                <div id="content" class="content-home">
                    <!-- Project Admin start -->
                    <div id="admin-management">
                        <h6 class="h6-top"><i class="fa fa-folder" style="font-size: 18px;padding-right: 5px"></i>
                            Project Management</h6>
                    </div>
                    <h6 class="h6-sub"><i class="fa fa-folder" style="font-size: 18px;padding-right: 5px"></i>Project List</h6>
                    <div id="project-list" class="col-lg-12">
                        <form action="{{route('DeleteProject')}}" method="post">
                            {{csrf_field()}}
                            <table id="projects-table" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Select</th>
                                    <th style="text-align: center">Project ID</th>
                                    <th style="text-align: center">Project Name</th>
                                    <th style="text-align: center">Start Day</th>
                                    <th style="text-align: center">End Day</th>
                                    <th style="text-align: center">Leader</th>
                                    <th style="text-align: center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($prjList->isEmpty())
                                    <tr>No Projects</tr>
                                @else
                                    @foreach($prjList as $prj)
                                        <tr>
                                            <td style="text-align: center;padding-top: 9px">
                                                <input name="project-list[]" type="checkbox" value="{{$prj->prj_id}}">
                                            </td>
                                            <td>
                                                {{$prj->prj_id}}
                                            </td>
                                            <td>
                                                {{$prj->prj_name}}
                                            </td>
                                            <td>
                                                {{$prj->prj_start_time}}
                                            </td>
                                            <td>
                                                {{$prj->prj_end_time}}
                                            </td>
                                            <td>{{$prj->getLeaderName()}}</td>
                                            <td>{{$prj->getStatus()}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="row my-holiday-action">
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal"
                                            data-target="#AddProjectModal">Add</button>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-secondary btn-block"
                                                name="action" value="delete"
                                                onclick="return getChecked('project-list[]')">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Add project modal -->
                        <div id="AddProjectModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Register Project</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('AddProject')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="project-id" class="label project-id">Project ID:</label>
                                                    <input id="project-id" name="project-id" type="text" placeholder="project id" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="project-name" class="label">Project Name:</label>
                                                    <input id="project-name" name="project-name" type="text" placeholder="project name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="start_date" class="label start-date">Project Time:</label>
                                                    <input id = "start_date" name="start_date" type="text" class="form-control
                                    datepicker" placeholder="From" autocomplete="off">
                                                    <span class="span">~</span>
                                                    <input id="end_date" name="end_date" type="text" class="form-control
                                    datepicker" placeholder="To" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="leader-id" class="label leader-id">Leader:</label>
                                                    <select class="form-control" id="leader-id" name="leader-id">
                                                        <option value="0">Choose Leader</option>
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
                    <!-- Project Admin End -->
                    <h6 class="h6-sub"><i class="fa fa-folder" style="font-size: 18px;padding-right: 5px"></i>Project Assign</h6>
                    <form action="{{route('ListMember')}}" method="post">
                        {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-4">
                            <h6 class="h6-sub">Project</h6>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select name="project" id="project" class="form-control">
                                            @foreach($prjList as $prj)
                                                @if(session('selected_prjid') == $prj->prj_id)
                                                    <option value="{{$prj->prj_id}}" selected>{{$prj->prj_name}}</option>
                                                @else
                                                    <option value="{{$prj->prj_id}}">{{$prj->prj_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group" style="padding:0 100px">
                                        <input type="submit" class="btn btn-outline-secondary btn-block" value="Member List"
                                        name="action">
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 class="h6-sub">Member List</h6>
                            <table id="member-assign" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Select</th>
                                    <th style="text-align: center">Member ID</th>
                                    <th style="text-align: center">Member Name</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Role</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignList as $member)
                                        <tr>
                                            <td style="text-align: center;padding-top: 9px">
                                                <input name="member-list[]" type="checkbox" value="{{$member->assign_id}}">
                                            </td>
                                            <td>{{$member->id}}</td>
                                            <td>{{$member->name}}</td>
                                            <td>{{$member->email}}</td>
                                            <td>
                                                @if($member->role == '1')
                                                    {{"Leader"}}
                                                @else
                                                    {{"Member"}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row" style="margin-left: 182px">
                                <div class="col-lg-4 form-group">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal"
                                                data-target="#AssignMemberModal">Assign Member</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-outline-secondary btn-block"
                                        onclick="return getChecked('member-list[]')" name="action" value="delete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- Assign member modal Start-->
                    <div id="AssignMemberModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Assign Member</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('MemberAssign')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="project-assign" class="label" style="padding-right: 50px">Project:</label>
                                                <select name="project-assign" id="project-assign" class="form-control">
                                                    @foreach($prjList as $prj)
                                                        <option value="{{$prj->prj_id}}">{{$prj->prj_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>ID</th>
                                                <th>Member</th>
                                                <th>Role</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($memberList as $member)
                                                @if($member->admin_flag != '1')
                                                <tr>
                                                    <td style="text-align: center;padding-top: 9px">
                                                        <input name="assign-list[]" type="checkbox" value="{{$member->id}}">
                                                    </td>
                                                    <td>{{$member->id}}</td>
                                                    <td>{{$member->name}}</td>
                                                    <td>
                                                        <select name="role[]" class="role">
                                                            <option value="0">Member</option>
                                                            <option value="1">Leader</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                            </div>
                                        </div>
                                        <div class="form-group" style="text-align: center">
                                            <button type="submit" class="btn btn-secondary"
                                                    onclick="return getChecked('assign-list[]')">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Assign member modal End -->
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('home')}}'</script>
@endif
@include('footer')

