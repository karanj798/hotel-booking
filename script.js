function showCity(str) {
	if(document.getElementById("select_province").selectedIndex <= 3){
		document.getElementById("resultProvinceValue").innerHTML = str;
		if (str=="") {
			document.getElementById("resultProvinceValue").innerHTML="";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else{ // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("resultProvinceValue").innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","getcity.php?q="+str,true);
		xmlhttp.send();
	}

	if(document.getElementById("select_province").selectedIndex > 3){
		document.getElementById("resultProvinceValue").innerHTML = "";
	}
}

function valid(){
	var flag = new Array ();
	if(document.getElementById("select_province").selectedIndex < 1){
		document.getElementById("province").className = 'error';
		flag[0] = false;
	}
	else{
		document.getElementById("province").className = 'noerror';
		flag[0] = true;
	}

	if(!document.getElementById("check-in").value){
		document.getElementById("check-in-s").className = 'error';
		flag[1] = false;
	}
	else{
		document.getElementById("check-in-s").className = 'noerror';
		flag[1] = true;
	}
	if(!document.getElementById("check-out").value){
		document.getElementById("check-out-s").className = 'error';
		flag[2] = false;
	}
	else{
		document.getElementById("check-out-s").className = 'noerror';
		flag[2] = true;
	}
	if(document.getElementById("check-in").value > document.getElementById("check-out").value){
		document.getElementById("check-out-s").innerHTML = 'Incorrect Date selection.';
		document.getElementById("check-out-s").className = 'error';
		flag[2] = false;
	}
	return flag;
}

function validation (){
	var check=true;
	for(var o in valid()){
		if(!valid()[o]){
			check = false;
		}
	}
	return check;
}

function getUsrSelectedCity (){
	
	if(validation()){
		var cityDropdown = document.getElementById("select_city");
		if(cityDropdown == null){
			location.href = 'booking.php?nocities=true&u=' + usrName.textContent;
		}else{
			var cityId = cityDropdown.options[cityDropdown.selectedIndex].value;
			var dateIn = document.getElementById("check-in").value;
			var dateOut = document.getElementById("check-out").value;
			var numberOfNights = parseInt(dateOut.substring(8, dateOut.length)) - parseInt(dateIn.substring(8, dateIn.length)) + 1;
			// Check with the prof..... if u book on the same day and exit on the same is that one night?
			if(numberOfNights == 0){
				numberOfNights = 1;
			}
			var today = new Date ();
			var date = today.getDate().toString();
			var month = (today.getMonth()+1).toString();
			var year = today.getFullYear().toString();
			var newDateIn = new Date ();
			var newDateOut = new Date ();

			// Problem -> if user stays for one whole week weekend price is not charged. Fix it soon .
			newDateIn.setFullYear (dateOut.substring(0, 4));
			newDateIn.setMonth(dateIn.substring(5, 7)-1);
			newDateIn.setDate(dateIn.substring(8, dateIn.length));

			newDateOut.setFullYear (dateOut.substring(0, 4));
			newDateOut.setMonth(dateOut.substring(5, 7)-1);
			newDateOut.setDate(dateOut.substring(8, dateOut.length));

			var dateIndexIn = newDateIn.getDay();
			var dateIndexOut = newDateOut.getDay();

			var weekendPrice = false;
			if(dateIndexIn == 6 || dateIndexIn == 0){
				weekendPrice = true;
			}
			if (dateIndexOut == 6 || dateIndexOut == 0){
				weekendPrice = true;
			}

			if (date.length < 2){
				date = "0" + date;
			}
			if(month.length < 2){
				month = "0" + month;
			}
			today = year + "-" + month + "-" + date;
			location.href = 'gethotels.php?city_id=' + cityId + "&din=" + dateIn + "&dout=" + dateOut 
			+ "&today=" + today;
		}
	}
}

function viewDeal(hotelId, cityId, dateIn, dateOut, today){
	console.log(hotelId);
	location.href = 'getrooms.php?hotel_id=' + hotelId + "&city_id=" + cityId + "&din=" + dateIn + "&dout=" + dateOut 
	+ "&today=" + today;
}

function showUsrMsg(roomId, cityId, dateIn, dateOut, numberOfNights, today, hotelId){
// Get date in, date out, user name, #####user id, number of nights (out - in), today's date, room id.
	console.log(roomId);
	location.href = 'roombook.php?&din=' + dateIn + '&dout=' + dateOut + '&numnight=' + numberOfNights 
	+ '&today=' + today + '&room_id=' + roomId + '&city_id=' + cityId + '&hotel_id=' + hotelId; 
}




function signIn (){
	document.getElementById("login").style.display='block';
	window.onclick = function(event) {
	    if (event.target == document.getElementById("login")) {
	        document.getElementById("login").style.display = "none";
	    }
	}
	
}

function signOut (){
	location.href = "endsession.php";
}

function registerUsr(){
	document.getElementById("register").style.display='block';
	window.onclick = function(event) {
	    if (event.target == document.getElementById("register")) {
	        document.getElementById("register").style.display = "none";
	    }
	}
}