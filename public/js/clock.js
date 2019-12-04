function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    var ampm = (h > 12?'PM':'AM');
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('hr').innerHTML = h;
    document.getElementById('min').innerHTML = m;
    document.getElementById('sec').innerHTML = s;
    document.getElementById('suffix').innerHTML = ampm;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

window.onload=startTime;
