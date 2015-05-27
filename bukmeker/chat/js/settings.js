var settings_chat = function(){
	var disp = document.getElementById('settings_chat').style.display;
		
if	(disp == 'none' || disp.length == 0) {
	document.getElementById('settings_chat').style.display = 'block';
	document.getElementById('close_sett').style.display = 'block';
	document.getElementById('open_sett').style.display = 'none';
							} else {
	document.getElementById('close_sett').style.display = 'none';
	document.getElementById('open_sett').style.display = 'block';
	document.getElementById('settings_chat').style.display = 'none';
	}
};