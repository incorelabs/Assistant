//Date view logic
var date = "__/__/____";
var tempDate = "";

var MyDate = function (date){
	var dateArr = date.split("/");
	this.day = parseInt(dateArr[0]);
	this.month = parseInt(dateArr[1]);
	this.year = parseInt(dateArr[2]);
};

MyDate.prototype.isLeapYear = function() {
	year = this.year;
	return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
};

MyDate.prototype.isYearValid = function() {
	return this.year > 1111 && this.year < 9999;
};

MyDate.prototype.isMonthValid = function() {
	return this.month < 13;
};

MyDate.prototype.isDayValid = function() {
	switch(this.month){
		case 1:
			return this.day < 32;
			break;
		
		case 2:
			return (this.isLeapYear()) ? (this.day < 30) : (this.day < 29);
			break;
		
		case 3:
			return this.day < 32;
			break;

		case 4:
			return this.day < 31;
			break;

		case 5:
			return this.day < 32;
			break;

		case 6:
			return this.day < 31;
			break;

		case 7:
			return this.day < 32;
			break;

		case 8:
			return this.day < 32;
			break;

		case 9:
			return this.day < 31;
			break;

		case 10:
			return this.day < 32;
			break;

		case 11:
			return this.day < 31;
			break;

		case 12:
			return this.day < 32;
			break;
	}
};

MyDate.prototype.isValid = function() {
	return this.isDayValid() && this.isMonthValid() && this.isYearValid();
};

function inputDate(element,str){
	switch(tempDate.length){
		case 0:
			tempDate += str;
			date = date.replaceAt(0,str);
			$(element).val(date);
			$(element).selectRange(1);
			break;
		
		case 1:
			tempDate += str;
			date = date.replaceAt(1,str);
			$(element).val(date);
			$(element).selectRange(3);
			break;

		case 2:
			tempDate += str;
			date = date.replaceAt(3,str);
			$(element).val(date);
			$(element).selectRange(4);
			break;

		case 3:
			tempDate += str;
			date = date.replaceAt(4,str);
			$(element).val(date);
			$(element).selectRange(6);
			break;

		case 4:
			tempDate += str;
			date = date.replaceAt(6,str);
			$(element).val(date);
			$(element).selectRange(7);
			break;

		case 5:
			tempDate += str;
			date = date.replaceAt(7,str);
			$(element).val(date);
			$(element).selectRange(8);
			break;

		case 6:
			tempDate += str;
			date = date.replaceAt(8,str);
			$(element).val(date);
			$(element).selectRange(9);
			break;

		case 7:
			tempDate += str;
			date = date.replaceAt(9,str);
			$(element).val(date);
			$(element).selectRange(10);
			break;

		case 8:
			tempDate += str;
			date = date.replaceAt(10,str);
			$(element).val(date);
			$(element).selectRange(11);
			break;
	}
}

function clearDate(element){
	switch (tempDate.length) {
		case 7:
			date = date.replaceAt(9,"_");
			$(element).val(date);
			$(element).selectRange(9);
			break;

		case 6:
			date = date.replaceAt(8,"_");
			$(element).val(date);
			$(element).selectRange(8);
			break;

		case 5:
			date = date.replaceAt(7,"_");
			$(element).val(date);
			$(element).selectRange(7);
			break;

		case 4:
			date = date.replaceAt(6,"_");
			$(element).val(date);
			$(element).selectRange(5);
			break;

		case 3:
			date = date.replaceAt(4,"_");
			$(element).val(date);
			$(element).selectRange(4);
			break;

		case 2:
			date = date.replaceAt(3,"_");
			$(element).val(date);
			$(element).selectRange(2);
			break;

		case 1:
			date = date.replaceAt(1,"_");
			$(element).val(date);
			$(element).selectRange(1);
			break;

		case 0:
			date = date.replaceAt(0,"_");
			$(element).val(date);
			$(element).selectRange(0);
			break;
	}
	//console.log(date);
}

// Date validation
$(document).ready(function(event){
	


	//Custom replaceAt function to replace a character
	String.prototype.replaceAt=function(index, character) {
	    return this.substr(0, index) + character + this.substr(index+character.length);
	}

	//Move cursor in the input box
	$.fn.selectRange = function(start, end) {
	    if(!end) end = start; 
	    return this.each(function() {
	        if (this.setSelectionRange) {
	            this.focus();
	            this.setSelectionRange(start, end);
	        } else if (this.createTextRange) {
	            var range = this.createTextRange();
	            range.collapse(true);
	            range.moveEnd('character', end);
	            range.moveStart('character', start);
	            range.select();
	        }
	    });
	};

	
	$(".date").keypress(function(event){
		//console.log(event);
		if (event.charCode > 47 && event.charCode < 58) {
			var str = String.fromCharCode(event.charCode);
			if (tempDate.length < 8) {
				inputDate(this,str);
			}
		}
		return false;
	});

	$(".date").keydown(function(event){
		//console.log(event);
		if (tempDate.length > 0) {
			if (event.keyCode == 8 || event.keyCode == 46) {
				tempDate = tempDate.substring(0,tempDate.length - 1);
				//console.log(tempDate);
				clearDate(this);
				return false;
			}
		}
	});

});


	