var extention = ".php/";
var host = "https://www.funderslife.com/api/";
var base = "https://www.funderslife.com/#!/Get-Started";

var isLocal = false;

if(isLocal){
    base = "http://localhost:55116/index.html#!/Get-Started";
    host = "http://localhost:8080/worldwidecash/fundersLife/api/";
//base = "http://localhost/worldwidecash/fundersLife/Get-Started";//freedom
//host = "http://localhost/worldwidecash/fundersLife/api/"; //Freedom
} 

var mail = "https://www.funderslife.com/api/emailClient2.php";
var penultAmount = '400';

function GetApiUrl(serviceName) {

    var url = host + serviceName + extention;
    return url;
}

function GetApiUrlForID(serviceName) {

    var url = host + serviceName;
    return url;
}
function GetHost(data) {
    return host + "" + data;
}
function getDate() {
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;
    return dateTime;
}
// email tempates 


function SendMail(emailFrom,to,name,subject,msg){
	$.post(mail,
    {
        emailFrom: emailFrom,
        to: to,
        name: name,
        subject: subject,
        msg: msg,
    },
    function(data, status){
		console.log(data);
    });
}

function SumArray(array){
    let sum =0;
    $.each(function(item, index){
        sum = sum + parseFloat(item);
    });
    return sum;
}

function CountDownTimer(stringStartDateTime,stringDisplayID){
// Set the date we're counting down to
var countDownDate = new Date(stringStartDateTime).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  if (stringDisplayID){
      // Display the result in the element with id="demo"
      document.getElementById(stringDisplayID).innerHTML = "Time remaining : " + days + "d " + hours + "h "
          + minutes + "m " + seconds + "s ";

      // If the count down is finished, write some text 
      if (distance < 0) {
          clearInterval(x);
          document.getElementById(stringDisplayID).innerHTML = "EXPIRED";
      }
  }
}, 1000);
}

function Load(){
    $(".loading").fadeIn("slow");
}
function Stop(){
    $(".loading").hide();
}