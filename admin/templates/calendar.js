// ----------------------------------------------------------------------------
// class for creating "inline" javascript calenders
// (c) Dominic Szablewski - www.phoboslab.org
function Calendar( input ) {

	// ----------------------------------------------------------------------------
	// get current position of a html-node relative to the body-element
	this.findPos = function( obj ) {
		var curleft = curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft;
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			}
		}
		return {
			'left':curleft, 
			'top':curtop
		};
	}

	// ------------------------------------------------------------------------
	// is the given year a leap year?
	this.isLeapYear = function( year ) {
		return (
			( 
				year % 4 == 0 
				&& year % 100 != 0
			)  
			|| year % 400 == 0
		);
	}
	
	// ------------------------------------------------------------------------
	// how many days has the given month in the given year?
	this.daysPerMonth = function( year, month ) {
		if( /11|9|6|4/.test( month ) ) {
			return 30;
		}
		else if( month == 2 ) {
			return this.isLeapYear( year ) ? 29 : 28;
		}
		else {
			return 31;
		}
	}
	
	// ------------------------------------------------------------------------
	// convert a string to date object
	this.stringToDate = function( s ) {
		var parts = /^\s*(\d+)\-(\d+)\-(\d+)(.*)\s*$/.exec(s);
		
		// wrong format? return the current date
		if( !parts || parts.length < 4 || parts[1] == 0) {
			d = new Date();
			return { 
				'day': d.getDate(),
				'month': d.getMonth()+1,
				'year': d.getYear()+1900
			}
		}
		else { 
			return { 
				'day': parts[3],
				'month': parts[2],
				'year': parts[1]
			}
		}
	}

	// ------------------------------------------------------------------------
	// set the input box value to the chosen date
	this.setDate = function( link ) {
		//alert( 'setdate' );
		var month = parseInt(this.viewDate.month);
		month = month < 10 ? "0" + month : month;
		
		var day = parseInt(link.firstChild.data);
		day = day < 10 ? "0" + day : day;

		this.input.value = this.viewDate.year + "-" + month + "-" + day + this.timePart;
		this.hide(0, true);
		return false;
	}
	
	// ------------------------------------------------------------------------
	// toggle visibilty of the calender
	this.show = function() {
		if( this.visible ) return;
		
		if( this.firstToggle ) {
			document.body.appendChild( this.calenderDiv );
			this.firstToggle = false;
		}
	
		this.selectedDate = this.stringToDate( this.input.value );
		this.viewDate = this.stringToDate( this.input.value );
		
		var parts = /^\s*(\d+)\-(\d+)\-(\d+)(.*)\s*$/.exec( this.input.value );
		if( parts ) {
			this.timePart = parts[4];
		}
		
		var pos = this.findPos( this.input );
		this.calenderDiv.style.top = (pos.top + this.input.offsetHeight) + "px";
		this.calenderDiv.style.left = pos.left + "px";
		
		this.calenderDiv.style.display = "block";
		this.visible = true;
		this.createDays();
		
		var that = this;
		document.onmousedown = function( ev ){ return that.hide(ev, false); }
		return false;
	}
	
	this.hide = function( ev, force ) {
		if( force || !this.elementInCalendar(this.getEventSource(ev)) ) {
			this.calenderDiv.style.display = "none";
			this.visible = false;
			document.onmousedown = '';
			this.input.blur();
		}
		return false;
	}
	
	this.getEventSource = function( ev ) {
		if( ev && ev.target){
			return ev.target;
		}
		if( ev && ev.srcElement ){
			return ev.srcElement;
		}if( window.event ){
			return window.event.srcElement;
		}
		return null;
	}
	
	this.elementInCalendar = function( source ) {
		while( source ) {
			if( source == this.input || source == this.calenderDiv ) {
				return true;
			}
			source = source.parentNode;
		}
		return false;
	}
	
	// ------------------------------------------------------------------------
	// create the view for the current viewDate
	this.createDays = function() {
		while( this.daysDiv.firstChild ) {
			this.daysDiv.removeChild( this.daysDiv.firstChild );
		}
		
		// create a list of days we need to display
		var days = new Array;
		
		// days before the first day of the month
		var d = new Date( this.viewDate.year, this.viewDate.month-1, 1 );		
		var dayOfWeek = d.getDay();
		dayOfWeek = dayOfWeek ? dayOfWeek : 7;
		for( var i = 1; i < dayOfWeek; i++ ) {	days.push( 0 ); }
		
		// days of the month
		var dayCount = this.daysPerMonth( this.viewDate.year, this.viewDate.month );
		for( var i = 1; i <= dayCount; i++ ) {	days.push( i ); }
		
		// days after the last day of the month
		var remaining = 7 - (days.length % 7);
		remaining = remaining == 7 ? 0 : remaining;
		for( var i = 0; i < remaining; i++ ) {	days.push( 0 ); }
		
		

		// create the day of the week headlines
		for( var i = 0; i < this.dayName.length; i++ ) {
			var head = document.createElement( 'a' );
			head.appendChild( document.createTextNode( this.dayName[i] ) );
			head.className = "calDayTitle";
			this.daysDiv.appendChild( head );
		}

		// create the days
		for( var i = 0; i < days.length; i++ ) {
		
			// insert a line break every 7 days
			if( i % 7 == 0 ) {
				var br = document.createElement( 'div' );
				br.className = "calWeekBreak";
				this.daysDiv.appendChild( br );
			}
	
	
			var a = document.createElement( 'a' );
			
			// empty dummy day?
			if( !days[i] ) {
				a.className = "calDummyDay";
			}
			else {
				a.href = "#";
				var that = this;
				a.onclick = function() { return that.setDate( this ); }
				
				// selected day?
				if( 
					days[i] == this.selectedDate.day
					&& this.viewDate.month == this.selectedDate.month
					&& this.viewDate.year == this.selectedDate.year
				) {
					a.className = "calSelectedDay";
				}
				
				// current day?
				else if( 
					days[i] == this.currentDate.day
					&& this.viewDate.month == this.currentDate.month
					&& this.viewDate.year == this.currentDate.year
				) {
					a.className = "calCurrentDay";
				}
				
				// normal work day
				else if( i % 7 < 5 ) {
					a.className = "calWorkDay";
				}
				
				// holiday
				else {
					a.className = "calHoliday";
				}
			}
			
			a.appendChild( document.createTextNode( days[i] ? days[i] : "" ) );
			this.daysDiv.appendChild( a );
		} // end for 
		
		
		// insert a last line break, so the calender box scales accordingly
		var br = document.createElement( 'div' );
		br.className = "calWeekBreak";
		this.daysDiv.appendChild( br );
		
		// set the title
		this.titleDiv.firstChild.data = this.monthName[this.viewDate.month-1] + " " + this.viewDate.year;
	}
	
	// ------------------------------------------------------------------------
	// one month back
	this.prevMonth = function() {
		if( this.viewDate.month > 1 ) {
			this.viewDate.month--;
		}
		else {
			this.viewDate.month = 12;
			this.viewDate.year--;
		}
		this.createDays( this.viewYear, this.viewMonth );
		this.input.focus();
		return false;
	}
	
	// ------------------------------------------------------------------------
	// one month forward
	this.nextMonth = function() {
		if( this.viewDate.month < 12 ) {
			this.viewDate.month++;
		}
		else {
			this.viewDate.month = 1;
			this.viewDate.year++;
		}
		this.createDays();
		this.input.focus();
		return false;
	}
	
	this.monthName = new Array(
		"Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	);
	
	this.dayName = new Array(
		"M", "T", "W", "T", "F", "S", "S"
	);
	
	
	
	
	var that = this;
	this.input = document.getElementById( input );
	
	// load some dates
	this.selectedDate = this.stringToDate( this.input.value );
	this.viewDate = this.stringToDate( this.input.value );
	this.currentDate = this.stringToDate( "" );
	this.timePart = '';


	
	// days container
	this.visible = false;
	this.daysDiv = document.createElement( 'div' );
	this.daysDiv.className = "calDays";
	
	
	// title
	this.titleDiv = document.createElement( 'span' );
	this.titleDiv.className = "calTitle";
	this.titleDiv.appendChild( document.createTextNode( "" ) );	
	
	// previoues month link
	var prevLinkDiv = document.createElement( 'a' );
	prevLinkDiv.className = "calPrevLink";
	prevLinkDiv.appendChild( document.createTextNode( "<<" ) );
	prevLinkDiv.href="#";
	prevLinkDiv.onclick = function() { return that.prevMonth(); }
	
	// next month link
	var nextLinkDiv = document.createElement( 'a' );
	nextLinkDiv.className = "calNextLink";
	nextLinkDiv.appendChild( document.createTextNode( ">>" ) );
	nextLinkDiv.href="#";
	nextLinkDiv.onclick = function() { return that.nextMonth(); }
	
	var titleContainer = document.createElement( 'div' );
	titleContainer.className = "calTitleContainer";
	titleContainer.appendChild( prevLinkDiv );
	titleContainer.appendChild( this.titleDiv );
	titleContainer.appendChild( nextLinkDiv );	

	
	// calender
	this.calenderDiv = document.createElement( 'div' );
	this.calenderDiv.className = "calContainer";
	this.calenderDiv.style.display = "none";
	this.calenderDiv.appendChild( titleContainer );
	this.calenderDiv.appendChild( this.daysDiv );
	this.firstToggle = true;
	
	// load the current month
	this.createDays();
	
	var that = this;
	this.input.onfocus = function() { return that.show(); }
}