var modal = document.getElementById('Xps145609sDxs');
var btn = document.getElementById("Xps145609sD");

btn.onclick = function() {
	var xmlHttp = null;
	xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange=function()
    {
        if (xmlHttp.readyState==4 && xmlHttp.status==200)
        {
        	modal.innerHTML = xmlHttp.responseText;
  		modal.style.display = "block";
        }
    }
    xmlHttp.open( "GET", "https://www.pivotsecurity.com/client/verify.php", true );
    xmlHttp.send();
   return false;
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
function validateEmail() {
    var emailparam = document.getElementById('email').value;
	var xmlHttp = null;
	xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange=function()
    {
        if (xmlHttp.readyState==4 && xmlHttp.status==200)
        {
		document.getElementById('pivotfrmsessionid').setAttribute('data-email', emailparam);
        	modal.innerHTML = xmlHttp.responseText;
  		modal.style.display = "block";
        }
    }
    var key = document.getElementById('pivotfrmsessionid').getAttribute('data-key');
    xmlHttp.open( "GET","https://www.pivotsecurity.com/client/verify.php?email=" + emailparam + "&key="+key, true);

    xmlHttp.send();
   return false;
}

function validateCode() {
         var emailparam = document.getElementById('pivotfrmsessionid').getAttribute('data-email');
	var xmlHttp = null;
	xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange=function(){
        if (xmlHttp.readyState==4 && xmlHttp.status==200){
        	if (xmlHttp.responseText){
        		document.getElementById('pivotfrmsessionid').value = xmlHttp.responseText;
        		if (document.getElementById('pivotfrmsessionid').getAttribute('data-submit') == 'true'){
					input = document.createElement('input');
					input.setAttribute('name', 'pivotfrmemail');
					input.setAttribute('value', emailparam);
					document.pivotfrm.appendChild(input);
        			document.pivotfrm.submit();
        		}
        		closemodel();
        	}else{
        		alert ('Code verification failed.');
        	}
        }
    }
    var key = document.getElementById('pivotfrmsessionid').getAttribute('data-key');
    var code = document.getElementById('code').value;
    xmlHttp.open( "GET", "https://www.pivotsecurity.com/client/verify.php?email=" + emailparam + "&key="+key + "&code="+ code, true );
    xmlHttp.send();
    return false;
}

function closemodel(){
  modal.style.display = "none";
}