function checkKeptycode(codeval){
	var chk_track_code		=	codeval.replace(/ /g,'');
	var final_track_code 	=	chk_track_code.replace(/[^a-zA-Z0-9 ]/g, "");
	document.getElementById('txtTrackingCode').value = final_track_code;
}