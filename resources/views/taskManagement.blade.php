@include('header')
@if(isset(Auth::user()->email))

    <div id="dashboard" class="container-fluid">
        <div class="row">
            @include('leftmenu')
            <div class="col-lg-10 right-menu">
                <div id="content-header"> Working Time Management System</div>
                <div id="content" class="content-home">
                    <div id="welcome" >
                        {{'Hello '.Auth::user()->name."."}}
                        @if($msg = Session::get('msg'))
                            {{$msg}}
                        @endif
                        <a id = "end-day" href="{{url()->current()}}" onclick="endday()">
                            End Day
                        </a>
                    </div>
                    <!-- Task Management Start-->
                    <div id="task-management">
                        <div class="row task-management-header">
                            <div class="col-lg-3">
                                <h6 class="h6-top"><i class="fa fa-tasks" style="font-size: 16px;padding-right: 8px"></i>Task Management</h6>
                            </div>
                            <div class="col-lg-9 prj-period">
                                <form action="{{route('search')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <label for="project-period" class="label">Period :</label>
                                        <input id="period-start-day" name="period-start-day" type="text" class="form-control
                                                datepicker " placeholder="From" autocomplete="off" value="{{session('period_start')}}">
                                        <span class="span">~</span>
                                        <input id = "period-end-day" name="period-end-day" type="text" class="form-control
                                                datepicker" placeholder="To" autocomplete="off" value="{{session('period_end')}}">
                                        <button type="submit" class="btn btn-primary search-btn">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row text-success">
                            @if($result = Session::get('result_msg'))
                                {{$result}}
                            @endif
                        </div>
                        @if(!$prjList->isEmpty())
                            @foreach($prjList as $prj)
                                <h6 class="h6-sub"><i class="fa fa-folder" style="font-size: 16px;padding-right: 8px"></i>
                                    {{"Project ".$prj->prj_name}}</h6>
                                <div class="row my-task">
                                    <!-- header -->
                                    <div class="col-lg-4 task-list-header">To do</div>
                                    <div class="col-lg-4 task-list-header">Doing</div>
                                    <div class="col-lg-4 task-list-header">Done</div>
                                    <!-- Content -->
                                    <div class="col-lg-4 task-list-content">
                                        @if(!$myTaskList->isEmpty())
                                            @foreach($myTaskList as $task)
                                                @if($task->task_status == '0' && $task->prj_id == $prj->prj_id)
                                                    <div id="task" class="{{$task->getLevelTask($task->task_level)}}">
                                                        <form action="{{route('closetask')}}" method="post">
                                                            {{csrf_field()}}
                                                        <a href="#AddTaskModal" data-toggle="modal"
                                                           onclick="setDataModal({{$task->id}})">
                                                        <input id="{{"task_".$task->id}}" type="hidden" value="{{json_encode($task)}}">
                                                        <input name="task_detail_id" type="hidden" value="{{$task->id}}">
                                                        <h6 class="task-name-head">{{$task->task_name}}</h6>
                                                        <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Start    :".$task->task_start_day}}</h6>
                                                        <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"End      :".$task->task_end_day}}</h6>
                                                        <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Estimate :".$task->task_estimate_time."  (h)"}}</h6>
                                                        </a>
                                                        @if($prj->role == "1")
                                                            <div class="member-task-name">{{Auth::user()->getNameByID($task->member_id)}}
                                                                <button class="btn-close" type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @else
                                                            <div class="member-task-name">
                                                                <button class="btn-close"type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @endif
                                                        </form>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-lg-4 task-list-content">
                                        @if(!$myTaskList->isEmpty())
                                            @foreach($myTaskList as $task)
                                                @if($task->task_status == '1' && $task->prj_id == $prj->prj_id)
                                                    <div id="task" class="{{$task->getLevelTask($task->task_level)}}">
                                                        <form action="{{route('closetask')}}" method="post">
                                                            {{csrf_field()}}
                                                        <a href="#AddTaskModal" data-toggle="modal"
                                                           onclick="setDataModal({{$task->id}})">
                                                            <input id="{{"task_".$task->id}}" type="hidden" value="{{json_encode($task)}}">
                                                            <input name="task_detail_id" type="hidden" value="{{$task->id}}">
                                                            <h6 class="task-name-head">{{$task->task_name}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Start    :".$task->task_start_day}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"End      :".$task->task_end_day}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Estimate :".$task->task_estimate_time."  (h)"}}</h6>
                                                        </a>
                                                        @if($prj->role == "1")
                                                            <div class="member-task-name">{{Auth::user()->getNameByID($task->member_id)}}
                                                                <button class="btn-close" type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @else
                                                            <div class="member-task-name">
                                                                <button class="btn-close"type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @endif
                                                        </form>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-lg-4 task-list-content">
                                        @if(!$myTaskList->isEmpty())
                                            @foreach($myTaskList as $task)
                                                @if($task->task_status == '2' && $task->prj_id == $prj->prj_id)
                                                    <div id="task" class="{{$task->getLevelTask($task->task_level)}}">
                                                        <form action="{{route('closetask')}}" method="post">
                                                            {{csrf_field()}}
                                                        <a href="#AddTaskModal" data-toggle="modal"
                                                           onclick="setDataModal({{$task->id}})">
                                                            <input id="{{"task_".$task->id}}" type="hidden" value="{{json_encode($task)}}">
                                                            <input name="task_detail_id" type="hidden" value="{{$task->id}}">
                                                            <h6 class="task-name-head">{{$task->task_name}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Start    :".$task->task_start_day}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"End      :".$task->task_end_day}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Estimate :".$task->task_estimate_time."  (h)"}}</h6>
                                                            <h6 class="task-detail"><i class="fa fa-check-square-o"></i>{{"Actual :".$task->task_actual_time."  (h)"}}</h6>
                                                        </a>
                                                        @if($prj->role == "1")
                                                            <div class="member-task-name">{{Auth::user()->getNameByID($task->member_id)}}
                                                                <button class="btn-close" type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @else
                                                            <div class="member-task-name">
                                                                <button class="btn-close"type="submit" onclick="return confirm('Do you want to close this task?')"><i class="fa fa-times"></i></button></div>
                                                        @endif
                                                        </form>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if(Auth::user()->position == 'L')
                            <div class="row add-task-btn-lead">
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#AddTaskModal" onclick="resetDataModal()">Add Task</button>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#AssignTaskModal">Assign Task</button>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#UploadPlanModal">Upload Task Plan</button>
                                </div>
                            </div>
                        @else
                            <div class="row add-task-btn-mem">
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#AddTaskModal" onclick="resetDataModal()">Add Task</button>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#UploadPlanModal">Upload Task Plan</button>
                                </div>
                            </div>
                    @endif
                        <!-- Modal add task -->
                        <div id="AddTaskModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add or Update Task</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('AddTask')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <input id="task-id" name="task-id" type="hidden" value="">
                                                <div class="input-group">
                                                    <label for="project-id" class="label">Project :</label>
                                                    <select class="form-control project" id="project-id" name="project-id">
                                                        <option value="">Choose Project</option>
                                                        @foreach($prjList as $prj)
                                                            <option value="{{$prj->prj_id}}">{{$prj->prj_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="task-start-day" class="label">Task Time :</label>
                                                    <input id="task-start-day" name="task-start-day" type="text" class="form-control
                                                datepicker task-start-day" placeholder="From" autocomplete="off">
                                                    <span class="span">~</span>
                                                    <input id = "task-end-day" name="task-end-day" type="text" class="form-control
                                                datepicker" placeholder="To" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="task-name" class="label">Task Name:</label>
                                                    <input id="task-name" name="task-name" type="text" placeholder="input task name here" class="form-control task-name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="estimate-time" class="label">Estimate Time:</label>
                                                    <input id="estimate-time" name="estimate-time" type="text" placeholder="input estimate time here(hours)" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="actual-time" class="label">Actual Time:</label>
                                                    <input id="actual-time" name="actual-time" type="text" placeholder="input actual time here(hours)" class="form-control actual-time">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="task-level" class="label">Task Level:</label>
                                                    <select name="task-level" id="task-level" class="form-control task-level">
                                                        <option value="">Choose Task Level</option>
                                                        <option value="3">Easy</option>
                                                        <option value="2">Medium</option>
                                                        <option value="1">Difficult</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="task-type" class="label">Task Type:</label>
                                                    <select name="task-type" id="task-type" class="form-control task-type">
                                                        <option value="">Choose Task Type</option>
                                                        <option value="1">Design</option>
                                                        <option value="2">Code</option>
                                                        <option value="3">Test</option>
                                                        <option value="4">Review</option>
                                                        <option value="5">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="task-status" class="label">Task Status:</label>
                                                    <select name="task-status" id="task-status" class="form-control task-status">
                                                        <option value="">Choose Task Status</option>
                                                        <option value="0">To do</option>
                                                        <option value="1">Doing</option>
                                                        <option value="2">Done</option>
                                                        <option value="3">Pending or Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 add-update-task-btn">
                                                        <button id="add-update-btn" type="submit" class="btn btn-primary btn-block"
                                                                name="action" value="add" onclick="">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal assign task-->
                        <div id="AssignTaskModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Assign Task</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('AssignTask')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-project-id" class="label">Project :</label>
                                                    <select class="form-control project" id="assign-project-id" name="assign-project-id" onchange="getSelectBoxMember()">
                                                        <option value="0">Choose Project</option>
                                                        @foreach($prjList as $prj)
                                                            <option value="{{$prj->prj_id}}">{{$prj->prj_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-member" class="label">Member :</label>
                                                    <select class="form-control assign-member" id="assign-member" name="assign-member">
                                                        <option value="0">Choose Member</option>
                                                        @foreach($allMember as $member)
                                                            <option value="{{$member['member_id']}}">{{$member['member_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-task-start-day" class="label">Task Time :</label>
                                                    <input id="assign-task-start-day" name="assign-task-start-day" type="text" class="form-control
                                                datepicker task-start-day" placeholder="From" autocomplete="off">
                                                    <span class="span">~</span>
                                                    <input id = "assign-task-end-day" name="assign-task-end-day" type="text" class="form-control
                                                datepicker" placeholder="To" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-task-name" class="label">Task Name:</label>
                                                    <input id="assign-task-name" name="assign-task-name" type="text" placeholder="input task name here" class="form-control task-name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-estimate-time" class="label">Estimate Time:</label>
                                                    <input id="assign-estimate-time" name="assign-estimate-time" type="text" placeholder="input estimate time here(hours)" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-actual-time" class="label">Actual Time:</label>
                                                    <input id="assign-actual-time" name="assign-actual-time" type="text" placeholder="input actual time here(hours)" class="form-control actual-time">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-task-level" class="label">Task Level:</label>
                                                    <select name="assign-task-level" id="assign-task-level" class="form-control task-level">
                                                        <option value="">Choose Task Level</option>
                                                        <option value="3">Easy</option>
                                                        <option value="2">Medium</option>
                                                        <option value="1">Difficult</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-task-type" class="label">Task Type:</label>
                                                    <select name="assign-task-type" id="assign-task-type" class="form-control task-type">
                                                        <option value="">Choose Task Type</option>
                                                        <option value="1">Design</option>
                                                        <option value="2">Code</option>
                                                        <option value="3">Test</option>
                                                        <option value="4">Review</option>
                                                        <option value="5">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <label for="assign-task-status" class="label">Task Status:</label>
                                                    <select name="assign-task-status" id="assign-task-status" class="form-control task-status">
                                                        <option value="">Choose Task Status</option>
                                                        <option value="0">To do</option>
                                                        <option value="1">Doing</option>
                                                        <option value="2">Done</option>
                                                        <option value="3">Pending or Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 add-update-task-btn">
                                                        <button type="submit" class="btn btn-primary btn-block" name="action" value="assign">Assign</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal upload assign task -->
                        <div id="UploadPlanModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Upload Task Plan</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="plan-assign-file"
                                                           name="plan-assign-file" onchange="showFileName()" required>
                                                    <label class="custom-file-label" for="plan-assign-file">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 add-update-task-btn">
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Task Management End -->
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('home')}}'</script>
@endif
@include('footer')
