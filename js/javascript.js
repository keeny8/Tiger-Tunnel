
window.onload = function() {
	const params = new URLSearchParams(document.location.search);
	const username = params.get('username');
	if(username!=null){
		document.getElementById('dashboard__title').innerHTML = "Welcome to Tiger Tunnel - "+username;
	}
	//console.log("loaded");
};

//var buttonClicks = 0;
//var antCollony = new Array();
//
//function spawnAnt(){
//	var ant = {finalDay: Math.floor(Math.random() * 10)+buttonClicks};
//	antCollony[antCollony.length] = ant;
//	//console.log(ant.finalDay+" "+buttonClicks);
//	antCollony = antCollony.filter(ant => (ant.finalDay >= buttonClicks));
//	console.log(antCollony.length);
//	++buttonClicks;
//}
//
//function submitMessage(){
//	var message = document.getElementById("chat__message");
//	var messages = document.getElementById("chat__messages");
//	console.log(message.innerHTML);
//	if(message.innerHTML!=''){
//		messages.innerHTML += "\n"+message.innerHTML;
//		message.innerHTML = "";
//	}
//}