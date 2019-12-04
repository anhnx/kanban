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
                    <!-- Project Management start -->
                    <div id="project-management">
                        <h6 class="h6-top"><i class="fa fa-users" style="font-size: 18px;padding-right: 5px"></i>
                            Project Management</h6>
                    </div>
                    <!-- Project -->
                    <div class="col-lg-12">

                    </div>
                    <!-- -->
                    <!-- Project Management End -->
                </div>
            </div>
        </div>
    </div>
@else
    <script> window.location.href='{{route('home')}}'</script>
@endif
@include('footer')
