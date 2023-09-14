document.getElementById("inscription").addEventListener("submit", function(e) {
	e.preventDefault();
 
	var form = this;
	var data = new FormData(form);

	var xhr = new XMLHttpRequest();
    xhr.responseType = "json";

    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200)
        {
            console.log(this.response)
            var res = this.response;
            alert(res.msg);
            if(res.success)
            {
                window.location.replace(res.adresse);
            }
        }
        else if (this.readyState == 4)
        {
            alert("Une erreur critique est survenue ! JS");
        }
    };

    xhr.open("POST", "GestureAuthBDD.php", true);
	xhr.send(data);
 
	return false;

});

