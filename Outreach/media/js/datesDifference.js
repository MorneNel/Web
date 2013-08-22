function getDaysDifference(date1, date2) {
	var minutes = 1000*60;
	var hours = minutes*60;
	var days = hours*24;	
	var foo_date1 = getDateFromFormat(date1, "y-M-d");
	var foo_date2 = getDateFromFormat(date2, "y-M-d");    
	var diff_date = Math.round((foo_date2 - foo_date1)/days);
	
	//var ISODate = foo_date1.format("ISODateTime");
	//alert("ISODate is " + ISODate);

	return diff_date + "D, ";
	}
	
	function getHoursMinsDifference(time1, time2) {
	    var timeOfCall = time1;
	    var timeOfResponse = time2;
	    
	    if ((timeOfCall !== '--:--') && (timeOfResponse !== '--:--')) {		    
		hours = timeOfResponse.split(':')[0] - timeOfCall.split(':')[0],
		minutes = timeOfResponse.split(':')[1] - timeOfCall.split(':')[1];
		
		minutes = minutes.toString().length<2?'0'+minutes:minutes;
		if(minutes<0){ 
		    hours--;
		    minutes = 60 + minutes;
		}
		hours = hours.toString().length<2?'0'+hours:hours;
		
		var output = hours + "H, " + minutes + "M";
		
		return output;  
	    } else return false;
	}