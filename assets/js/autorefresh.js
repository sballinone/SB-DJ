var refreshTimerValue = refreshTimer;

$(document).on('keypress click', function() { refreshTimerValue = refreshTimer+1; });

function timerTick() {
	if(refreshTimerActive) {
		if(refreshTimerValue > 0) {
			refreshTimerValue--;
		} else {
			location.href = "backend.php";
		}
		$('#refreshTime').html(refreshTimerValue);
	}
	setTimeout("javascript:timerTick()", 1000);
}

setTimeout("javascript:timerTick()", 1000);

function refreshTimerToggle() {
	if(refreshTimerActive) {
		refreshTimerActive = false;
		$('#refreshTime').html("Disabled");
		$('#btnRefreshTime').removeClass("btnRefresh");
		$('#btnRefreshTime').addClass("btnDanger");
		setCookie("refresh","false");
	} else {
		refreshTimerActive = true;
		refreshTimerValue = refreshTimer;
		$('#refreshTime').html(refreshTimerValue);
		$('#btnRefreshTime').addClass("btnRefresh");
		$('#btnRefreshTime').removeClass("btnDanger");
		setCookie("refresh","true");
	}
}
