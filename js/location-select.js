document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('location_select').addEventListener('change',function(evt){
    form = this.parentNode;
    action = 'home.php?location='+ this.options[this.selectedIndex].text;
    form.action = action;
    form.submit();
    window.location.replace(action)

  });
})
