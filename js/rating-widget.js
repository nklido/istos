document.addEventListener('DOMContentLoaded', function() {

	ratingForms = document.querySelectorAll('form.rating-widget')
	for(var i=0;i<ratingForms.length;i++){
		var ratingForm = ratingForms[i],
			input  = ratingForm.querySelector('input[type="range"]'),
			submit = ratingForm.querySelector('button[type="submit"]'),
			size = input.getAttribute('max'),
			registeredValue = input.value;
			currentValue = 1;

		ratingWidget = document.createElement('span');
		ratingWidget.className = 'rating-widget';
		for(var j=size; j>0; j--) {
			var star = document.createElement('a'), // <a href />, to be focusable
			rating = j;
			star.href=''
			star.rating = rating;

			if(j == registeredValue){
				star.classList.add('registered');
			}
			if(j == 1){
				star.classList.add('selected');
				star.current = j
			}
			ratingWidget.appendChild(star);

			star.addEventListener('click', function(evt){
				var sel = document.getElementsByClassName('selected')[0];
				sel.classList.remove('selected');
				this.classList.add('selected');
				evt.preventDefault();
			}, false);
		}

			submit.addEventListener('click',function(evt){
				evt.preventDefault();
				var sel = document.getElementsByClassName('selected')[0];
				rate(this,sel.rating);
			}, false);

			input.parentNode.replaceChild(ratingWidget, input); //replace input with widget
		}//end for loop
});


function rate(submit,rating) {
	var xhr = new XMLHttpRequest();
	var form = submit.parentNode;


	while(form.nodeName.toLowerCase() != 'form') { //go up until form element
		form = form.parentNode;
	}

	var method = form.method;

	console.log(form)


	var data = "data=" + (JSON.stringify({
		'rating':rating,
		'rent_id':form.querySelector('input[name=rent]').value,
		'comment':form.querySelector('textarea[name=comment]').value
	}))

	xhr.open(method, form.action + (method.toUpperCase() == 'GET'? '?' + data : ''), true);
	if(method.toUpperCase() === 'POST') { //post needs this header
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	}
	xhr.onreadystatechange = function (evt) {
		if(xhr.readyState == 4) {
            //form.querySelector('img').remove()
			if(xhr.status == 200 || xhr.status == 304) {
				console.log("response "+xhr.responseText);
				if(xhr.response!=-1){
					alert('Voting registered')
				}else{
					alert('You have already voted!')
				}
			}
			else {
				alert('Error ' + xhr.status + ': ' + xhr.statusText);
			}
		}
	};
	xhr.send(method.toUpperCase() === 'POST'? data : null);
}
