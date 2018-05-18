document.addEventListener('DOMContentLoaded', function() {
	var ratingForm = document.querySelector('form.rating-widget'),
			input = ratingForm.querySelector('input[type="range"]'),
			size = input.getAttribute('max'),
			currentValue = input.value;

	ratingWidget = document.createElement('span');
	ratingWidget.className = 'rating-widget';
	for(var j=size; j>0; j--) {
		var star = document.createElement('a'), // <a href />, to be focusable
		rating = j;
		star.href=''
		star.rating = rating;

					if(j == currentValue){
							star.classList.add('selected');
							star.current   += j
					}


		ratingWidget.appendChild(star);

		star.addEventListener('click', function(evt){
			var sel = document.getElementsByClassName('selected')[0];
			sel.classList.remove('selected');
			this.classList.add('selected');
			evt.preventDefault();

		}, false);
	}



	var submit_button = ratingForm.querySelector('button[type=submit]')
	submit_button.addEventListener('click',function(evt){
		evt.preventDefault();
		var sel = document.getElementsByClassName('selected')[0];
		rate(this,sel.rating);
	}, false);

	input.parentNode.replaceChild(ratingWidget, input); //replace input with widget

});


function rate(submit,rating) {
	var xhr = new XMLHttpRequest();
	var form = submit.parentNode;


	while(form.nodeName.toLowerCase() != 'form') { //go up until form element
		form = form.parentNode;
	}

	console.log(submit)
	var method = form.method;


	var data = "data=" + (JSON.stringify({
		'rating':rating,
		'accom_id':document.getElementById('accom_id').value,
		'comment':document.getElementById('comment').value
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
			}
			else {
				alert('Error ' + xhr.status + ': ' + xhr.statusText);
			}
		}
	};
	xhr.send(method.toUpperCase() === 'POST'? data : null);
}
