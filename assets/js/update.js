// Update check
var txtStatus = '<i class="icofont-database"></i> <small>';
var btnColor = "btnDefault";
if(major < relmajor || (major == relmajor && minor < relminor) || (major == relmajor && minor == relminor && built < relbuilt)) {
	txtStatus += "Dev release " + relmajor + "." + relminor + "." + relbuilt;
} else if(major > relmajor) {
	txtStatus += "SB DJ " + major + " available";
	btnColor = "btnDanger";
} else if(minor > relminor) {
	txtStatus += "SB DJ " + major + "." + minor + " available";
	btnColor = "btnDanger";
} else if(built > relbuilt) {
	txtStatus += "Update " + built + " available";
	btnColor = "btnDanger";
} else {
	txtStatus = relmajor + "." + relminor + "." + relbuilt;
	btnColor = "btnRefresh";
}
txtStatus += '</small>';

document.getElementById("btnUpdate").classList.remove("btnDefault");
document.getElementById("btnUpdate").classList.add(btnColor);
document.getElementById("btnUpdate").innerHTML = txtStatus;

if(btnColor == "btnDanger") {
	document.getElementById("btnUpdate").setAttribute('href', updateurl);
}