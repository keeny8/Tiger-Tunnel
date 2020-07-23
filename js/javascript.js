
window.onload = function() {
	const params = new URLSearchParams(document.location.search);
	const username = params.get('username');
	if(username!=null){
		document.getElementById('dashboard__title').innerHTML = "Welcome to Tiger Tunnel - "+username;
	}
};