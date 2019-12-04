function endday() {
    confirm = confirm("今日の作業を終了しますか。");
    var now = new Date();
    var h = now.getHours();
    var m = now.getMinutes();
    if (m < 10) {
        m = '0' + m;
    }
    var s = now.getSeconds();
    if (s < 10) {
        s = '0' + s;
    }
    var time = h +':' + m + ":" + s;
    var url = document.getElementById('end-day').getAttribute('href');
    if (confirm) {
        url = url + '?end-day=' + time + '&confirm=1';
        document.getElementById('end-day').setAttribute('href',url);
        return true;
    } else {
        return false;
    }
}
function getChecked(checkboxName) {
    var checkboxes = document.getElementsByName(checkboxName);
    var checkboxesChecked = [];
    isSubmit = false;
    // loop over them all
    for (var i = 0; i < checkboxes.length; i++) {
        // And stick the checked ones onto an array...
        if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i]);
        }
    }
    // if array is empty then alert
    if (checkboxesChecked.length <= 0) {
        alert("Please select at least one item!");
        return false;
    }
}
function setDataModal(taskID){
    var inputTag = 'task_'+taskID;
    var taskDetail = JSON.parse(document.getElementById(inputTag).value);
    //set data to modal
    document.getElementById('task-id').value = taskDetail.id;
    document.getElementById('project-id').value = taskDetail.prj_id;
    document.getElementById('project-id').setAttribute('disabled',true);
    document.getElementById('task-start-day').value = taskDetail.task_start_day;
    document.getElementById('task-end-day').value = taskDetail.task_end_day;
    document.getElementById('task-name').value = taskDetail.task_name;
    document.getElementById('task-name').setAttribute('readonly',true);
    document.getElementById('estimate-time').value = taskDetail.task_estimate_time;
    document.getElementById('actual-time').value = taskDetail.task_actual_time;
    document.getElementById('task-level').value = taskDetail.task_level;
    document.getElementById('task-type').value = taskDetail.task_type;
    document.getElementById('task-type').setAttribute('disabled',true);
    document.getElementById('task-status').value = taskDetail.task_status;
    document.getElementById('add-update-btn').innerHTML = 'Update';
    document.getElementById('add-update-btn').value = 'update';
}

function resetDataModal(){
    //set data to modal
    document.getElementById('task-id').value = "";
    document.getElementById('project-id').value = "";
    document.getElementById('project-id').removeAttribute('disabled');
    document.getElementById('task-start-day').value = "";
    document.getElementById('task-end-day').value = "";
    document.getElementById('task-name').value = "";
    document.getElementById('task-name').removeAttribute('readonly');
    document.getElementById('estimate-time').value = "";
    document.getElementById('actual-time').value = "";
    document.getElementById('task-level').value = "";
    document.getElementById('task-type').value = "";
    document.getElementById('task-type').removeAttribute('disabled');
    document.getElementById('task-status').value = "";
    document.getElementById('add-update-btn').innerHTML = 'Add';
    document.getElementById('add-update-btn').value = 'add';
}

function getSelectBoxMember() {
    var memberSelect = document.getElementById('assign-member');
    var selectedPrj = parseInt(document.getElementById('assign-project-id').value);
    //reset member select box
    memberSelect.options.length = 0;
    //add new option
    if (selectedPrj !== 0) {
        for(i = 0; i < memberAssignPrjList.length; i++) {
            var member_lst = memberAssignPrjList[i].member_lst;
            if (memberAssignPrjList[i].prj_id === selectedPrj) {
                for (j = 0; j < member_lst.length; j++) {
                    memberSelect.options[j] = new Option(member_lst[j].member_name, member_lst[j].member_id);
                }
            }
        }
    } else {
        memberSelect.options[0] = new Option('Choose Member', 0);
        for(i = 0; i < allMember.length; i++) {
            memberSelect.options[i+1] = new Option(allMember[i].member_name, allMember[i].member_id);
        }
    }
}

function closeTask() {
    confirm = confirm("Do you want to close this task?");
    if (confirm) {
        return true;
    } else {
        return false;
    }
}

function showFileName() {
    var input = document.getElementById('plan-assign-file');
    var label = document.getElementsByClassName('custom-file-label');
    label[0].innerHTML = input.files[0].name;
}

function positionChange() {
    var position = document.getElementById('position');
    var leader = document.getElementById('leader-id');
    if (position.value === '2') {
        leader.setAttribute('disabled', true);
    } else {
        leader.removeAttribute('disabled');
    }
}
