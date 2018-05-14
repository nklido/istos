
window.onload = function(){
	document.getElementById("profile_info").addEventListener("click", button_click);
  document.getElementById("reservations").addEventListener("click", button_click);
  document.getElementById("accommodations").addEventListener("click", button_click);
  document.getElementById("history").addEventListener("click", button_click);
};


function button_click(evt){
	var active = document.getElementById("profile_nav").getElementsByClassName('active')[0];
	//document.getElementById(active.id+"_content").style.visibility = "hidden";
	active.classList.remove('active');

	this.classList.add("active");
	//document.getElementById(this.id+"_content").style.visibility = "visible";
}
