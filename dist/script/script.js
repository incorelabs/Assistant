//var root = "http://incorelabs.com/Assistant/";
var root = "http://localhost/Assist/";


function showNotificationSuccess(msg) 
{
  $("#notification_success").html(msg);
  document.getElementById('notification_success').style.display = "block";  
  $("#notification_success").delay(2000).fadeOut("slow");
}

function showNotificationFailure(msg) 
{
  $("#notification_failure").html(msg);
  document.getElementById('notification_failure').style.display = "block";  
  $("#notification_failure").delay(2000).fadeOut("slow");
}