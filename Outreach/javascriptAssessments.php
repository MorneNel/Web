<script type="text/javascript">
	$(document).ready(function() 
	{
	    // Prevent enter from submitting the form
	    $(window).keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13') {
			    event.preventDefault();
		    }
	    });		
	    
	    /*
	     * Initialisation
	     */ 
	    
	    $("button").button(); // What is this for?
	    $("#tabs").tabs();
	    $('#MEWSTrig').hide();
	    $( "form" ).sisyphus({
		locationBased: true
	    });
	    var activeMedicationIndex = 0;
	    $( ".medicationAccordion" ).accordion({
		active: 0,
		autoHeight: true,
		heightStyle: 'content',
		activate: function (event, ui) {
		    var activeIndex = $(".medicationAccordion").accordion("option", "active");
		    window.activeMedicationIndex = activeIndex;
		}
	    });
	    var clicks = 0;	    
	    /*
	     * End initialisation
	     */ 
	    
	    /*
	     * Begin functions and other generic code
	     */
	    
	    function resetForm(id) {
		$('#'+id).each(function(){
			this.reset();
		});
	    }
	    
	    $('tbody tr[data-href] td:not(:last-child)').click( function(e) { 
			window.location = $(this).attr('data-href');
	    });
	    
	    function popitup(url,windowName, data, height, width) {
			// Height and width are optional parameters, if not defined default values are used
			var windowHeight = 450;
			var windowWidth = 575;
			if (arguments.length === 5) {
			    windowHeight = height;
			    windowWidth = width;
			}
			
			// Data can contain additional info to get tacked on to the end of the URL
			if (typeof data === "undefined") {
			    newwindow=window.open(url,windowName,'height='+windowHeight+',width='+windowWidth);
			} else {
			    var fullURL = url + data;
			    newwindow=window.open(fullURL,windowName,'height='+windowHeight+',width='+windowWidth);
			}			
			if (window.focus) {newwindow.focus()}
			return false;
	    }
	    
	    function resetField(field) {
		// This is mainly intended for resetting the dropdown
		// lists in medicalstaff.php
		$(field).val('');
	    }
	    
	    function changeTab(tabIndex) {
		$("#tabs").tabs( "option", "active", tabIndex );
	    }
	    
	    /*
	     * Physiology value checking
	     */
	    function checkPhysiologyValue(dlkID, fieldCode, fieldType, physiologyValue, fieldLabel, identifier) {
		/*
		 * @param {int} dlkID - Daily Link ID
		 * @param {string} fieldCode - Identifies which field is being checked (look at form structure in 4D. Method pat_Validate_Value is called with 3 args, this is 3rd arg)
		 * @param {string} fieldType - 3 possibilites: 'T' for Physiology1A, 'L' or 'H' for physiology 2 referring to highest/lowest
		 * @param {float} physiologyValue - The actual value of the field being checked
		 * @param {string} fieldLabel - The name of the field being checked
		 * @param {string} identifier - the ID of the element called so its value can be deleted if they don't want to keep it
		 * @returns {string} String is checked for a question mark. If so, present yes/no option else just display warning
		 */
		$.ajax({
		    type: "POST",
		    url: "checkPhysiology.php",
		    data: "dlkid=" + dlkID + "&code=" + fieldCode + "&type=" + fieldType + "&value=" + physiologyValue + "&label=" + fieldLabel,
		    async: false,
		    success: function(msg){
		    	if (msg.length > 0) {
			    // Simplest way to check if it's returning a question is to check
			    // if the last character is a question mark, like so: str.slice(-1);
			    if (msg.slice(-1) === '?') {
				// Need to provide yes/no option
				$.prompt(msg, {	
				    buttons: { "OK": true, "Cancel": false },
				    submit: function(e,v,m,f){
						// use e.preventDefault() to prevent closing when needed or return false. 
						e.preventDefault(); 
						if (v === false) {
							// Get old value
							var oldValue = $('#' + identifier + 'Hidden').val();
							$('#' + identifier).val(oldValue);
							$.prompt.close();
						} else {
							$.prompt.close();
						}
					}
				});		
			    } else {
				$.prompt(msg);
			    }
			}			
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) {
			 rowID = 'Invalid';
			 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		});
	    
	    }
	    
	    /*
	     * End physiology value checking
	     */
	    
	    function getDayFromDate(date) {
		var javascriptDate = new Date(date);
		var daysArray = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
		var dateFromDay = daysArray[javascriptDate.getDay()];
		//console.debug(javascriptDate);
		//console.debug(dateFromDay);
		return dateFromDay;
	    }
	    
	    function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	    }
	    
	    /*
	     * End functions and generic code
	     */
	    
	    $('.addRow').click(function() {
		CLRow = 0;
		var data = $(this).closest(':radio').data();
		var abbr = data['abbr'];
		var item_ID = data['item_id'];
		var group = data['group'];
		var dlk_ID = data['dlk_id'];
		var lnk_ID = data['lnk_id'];
		var destination = data['destination'];
		var edit = data['edit'];
		var med = data['med'];
		//console.debug(data);
		
		if (med === 1) {
		    // Determine which accordion panel is open to determine which table to place the new row in
		    if (window.activeMedicationIndex === null) {
			var activeMedicationIndex = 0;
		    }
		    
		    switch (window.activeMedicationIndex) {
			case 0:
			    var destination = "medications";
			    var abbr = "ME";
			break;
		    
			case 1:
			    var destination = "pre-medications";
			    var abbr = "PRMED";
			break;
		    
			case 2:
			    var destination = "rec-medications";
			    var abbr = "REMED";
			break;
		    }
		}
		
		$.ajax({
		   type: "POST",
		   url: "addRow.php",
		   data: "destination="+ destination + "&itemID=" + item_ID + "&group=" + group + "&dlk_ID=" + dlk_ID + "&lnk_ID=" + lnk_ID,
		   async: false,
		   success: function(msg){
			rowID = msg;
			if (isNaN(rowID)) {
			    alert( "Error: " + msg );
			} else {
			    CLRow = 1;
			}
		    },
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
			rowID = 'Invalid';
			alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		});
		
		
		if (CLRow == 1) {
		    /*Extra columns for the medications area*/
		    if (med == 1) {
			// Need to get extra data to fill out the dropdown menus
			var DDHTML = "";
			$.ajax({
			    type: "POST",
			    url: "getMedDDs.php",
			    data: "id=" + rowID,
			    async: false,
			    success: function(msg){
				DDHTML = msg;
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				DDHTML = 'Invalid';
				alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			    } 
			});
			var medDDs = DDHTML.split('|');			
			
			var tr = $(
				'<tr>'
				+ '<td class="cat ' + abbr + '"></td>'
				+ '<td class="sel ' + abbr + '"></td>' 
				+ '<td><input type="text" value="0" name="med-Dose[' + rowID + ']" id="med-Dose[' + rowID + ']"></td>'
				+ '<td>' + medDDs[0] + '</td>'
				+ '<td>' + medDDs[1] + '</td>'
				+ '<td>' + medDDs[2] + '</td>'
				+ '<td>' + medDDs[3] + '</td>'
				+ '<td><input type="date" value="" name="med-Discontinued[' + rowID + ']" id="med-Discontinued[' + rowID + ']"></td>'
				+ '<td id="textArea_cell"><textarea class="FormBlock gi_text" name="mednotes[' + rowID + ']"></textarea><input type="hidden" name="catText[' + rowID + ']" class="hiddenCat"><input type="hidden" name="selText[' + rowID + ']" class="hiddenSel"></td>'
				+ '<td id="Button_cell"><button id="' + rowID + '" type="button" class="editRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/pencil.gif" alt="Edit"/></button></td>'
				+ '<td id="Button_cell"><button id="' + rowID + '" type="button" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/bin.gif" alt="Delete"/></button></td></tr>');
			$( ".medicationAccordion" ).accordion( "refresh" );
		    } else if (med == 2) {
			var tr = $(
				'<tr>'
				+ '<td class="cat ' + abbr + '"></td>'
				+ '<td class="sel ' + abbr + '"></td>'
				+ '<td id="textArea_cell"><textarea class="FormBlock gi_text" name="' + abbr + 'notes[' + rowID + ']"></textarea><input type="hidden" name="catText[' + rowID + ']" class="hiddenCat"><input type="hidden" name="selText[' + rowID + ']" class="hiddenSel"></td>'
				+ '<td id="Button_cell"><button id="' + rowID + '" type="button" class="editRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/pencil.gif" alt="Edit"/></button></td>'
				+ '<td id="Button_cell"><button id="' + rowID + '" type="button" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/bin.gif" alt="Delete"/></button></td></tr>');
		    }
		    else if (abbr == 'DO') {
			// Daily outcome adds a date and time field too
			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth() + 1; //Months are zero based
			var curr_year = d.getFullYear();
			
			if (curr_date < 10) {
			    curr_date = '0'+curr_date;
			}
			
			if (curr_month < 10) {
			    curr_month = '0'+curr_month;
			}
			var today = (curr_year + "-" + curr_month + "-" + curr_date);
			//console.debug("Today is " + today);
			var tr = $(
				'<tr>'
				+ '<td class="cat ' + abbr + '"></td>'
				+ '<td class="sel ' + abbr + '"></td>'
				+ '<td><input type="date" class="FormDate valid FormDODate" name="' + abbr + 'Date[' + rowID + ']" id="' + abbr + 'Date_' + rowID + '" value="' + today + '"></td>'
				+ '<td><input type="time" class="FormTime valid FormDOTime" name="' + abbr + 'Time[' + rowID + ']" id="' + abbr + 'Time_' + rowID + '" value="00:00"></td>'
				+ '<td id="textArea_cell"><textarea class="FormBlock gi_text" name="' + abbr + 'notes[' + rowID + ']"></textarea><input type="hidden" name="catText[' + rowID + ']" class="hiddenCat"><input type="hidden" name="selText[' + rowID + ']" class="hiddenSel"></td>'
				+ '<td id="Button_cell"><button id="' + rowID + '" type="button" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/bin.gif" alt="Delete"/></button></td></tr>');
		    }
		    /*Append item in G&I with with the remove option and Edit option buttons available*/
		    else if (edit == 'y') {
			var tr = $(
			    '<tr>'
			    + '<td class="cat ' + abbr + '"></td>' 
			    + '<td class="sel ' + abbr + '"></td>'
			    + '<td id="textArea_cell"><textarea class="FormBlock gi_text" name="' + abbr + 'notes[' + rowID + ']"></textarea><input type="hidden" name="catText[' + rowID + ']" class="hiddenCat"><input type="hidden" name="selText[' + rowID + ']" class="hiddenSel"></td>'
			    + '<td id="Button_cell"><button id="' + rowID + '" type="button" class="editRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/pencil.gif" alt="Edit"/></button></td>'
			    + '<td id="Button_cell"><button id="' + rowID + '" type="button" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '"><img src="Media/img/bin.gif" alt="Delete"/></button></td>'
			    + '</tr>');	
		    } else {
	     
		    /*Append item in G&I with with just the remove option button*/	
			var tr = $(
			    '<tr>'
			    + '<td class="cat ' + abbr + '"></td>' 
			    + '<td class="sel ' + abbr + '"></td>'
			    + '<td id="textArea_cell"><textarea class="FormBlock gi_text" name="' + abbr + 'notes[' + rowID + ']"></textarea><input type="hidden" name="catText[' + rowID + ']" class="hiddenCat"><input type="hidden" name="selText[' + rowID + ']" class="hiddenSel"></td>'
			    + '<td id="Button_cell"><button id="' + rowID + '" type="button" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-page="' + destination + '" role="button" aria-disabled="false"><span class="ui-button-text"><img src="Media/img/bin.gif" alt="Delete"/></span></button></td>'
			    + '</tr>');	
		    }
		    
			$('.' + abbr + 'Table > tbody:last').one().append(tr);
			tr.find(".cat").text($(this).closest("li.category").attr("title"));
			tr.find(".hiddenCat").val($(this).closest("li."+abbr).attr("title"));
			tr.find(".sel").text($(this).closest("li.select").attr("title"));
			tr.find(".hiddenSel").val($(this).closest("li."+abbr).attr("title"));
	     
		    CLRow = 0;	
		}
	     }); 
	     
	     $(document).on('click', '.editRow', function() { 
		var id = $(this).attr('id');
		var data = $(this).data();
		page = data['page'];
		var url = "edit" + page + ".php?dlk=<?php echo (isset($patient['DLK_ID'])) ? $patient['DLK_ID'] : 0; ?>&lnk=<?php echo (isset($patient['LNK_ID'])) ? $patient['LNK_ID'] : 0; ?>&row="+ id;
		popitup(url,page,'',375,1075);
	     });
	     
	     $(document).on('click', '.deleteRow', function() {
		var id = $(this).attr('id');
		var data = $(this).data();
		page = data['page'];
		$.ajax({
		   type: "POST",
		   url: "DeleteRow.php",
		   data: "page=" + page + "&itemID="+id,
		   success: function(msg){
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		    } 
		});
	     
		var whichtr = $(this).closest("tr");
		whichtr.remove();
	     
	     });
	     
	     /*
	     * End groups/items functions
	     */
	    
	    /*
	     * Physiology value checking
	     */
	    
	    $('.checkPhysiology').change(function() {
		var dlkID = $('#patDLKID').val();
		var data = $(this).data();
		var code = data['code'];
		var type = data['type'];
		var label = data['label'];
		var identifier = data['identifier'];
		var that = $(this).val();
		if (isNumber(that)) {
			checkPhysiologyValue(dlkID, code, type, that, label, identifier);
		} else {
			$.prompt("Value entered must be numeric");
		}
	    });
	    
	    /*
	     * End physiology value checking
	     */ 
	    
	    $('#patientSeen').click(function () {
		if (confirm('Are you sure patient has been seen?')) {
		    var data = $(this).data();
		    var lnkid = data['lnkid'];
		    var user = data['user'];
		    $.ajax({
			type: "POST",
			url: "SQL_TriggSetSeen.php",
			data: "lnkid=" + lnkid + "&user=" + user,
			async: false,
			success: function(msg){
			    $('#patientSeen').hide();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
			     rowID = 'Invalid';
			     alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			} 
		    });	
		}	
	    });
	    
	    
	    /*
	     * Begin page/element specific code
	     */
	    
	    /*
	     * SOFA/NEWS/EWSS button popups
	     */
	    $('#SOFAScore').click(function() {
		var data = $(this).data();
		var dlkpatid = data['dlkpatid'];
		var dlkid = data['dlkid'];
		var query = "?dlkpatid="+dlkpatid+"&dlkid="+dlkid;
		popitup('SOFA.php','SOFA',query,625,725);
	    });
	    
	    $('#EWSScore').click(function() {
		var data = $(this).data();
		var dlkpatid = data['dlkpatid'];
		var lnkid = data['lnkid'];
		var query = "?dlk_patID="+dlkpatid+"&dlk_MEWSID=1&lnkid=" + lnkid;
		popitup('MEWSPopup.php','MEWS',query,550,1025);
	    });
	    
	    $('#NEWSScore, #admNEWSScore').click(function() {
		var data = $(this).data();
		var dlkid = data['dlkid'];
		var dlkpatid = data['dlkpatid'];
		var lnkid = data['lnkid'];
		var query = "?dlkid="+dlkid+"&dlk_patID="+dlkpatid+"&lnkid=" + lnkid;
		popitup('NEWSPopup.php','NEWS',query,550,1025);
	    });
	    
	    $('#firstTrigger').click(function() {
		var data = $(this).data();
		var lnkid = data['lnkid'];
		var query = "?lnkid="+lnkid;
		popitup('firstTrigger.php','First Trigger',query,565,1025);
	    });
	    
	    $('.calculateNEWS').change(function() {
		var ID = $('#patDLKID').val();
		var lnkid = $('#hiddenLNKID').val();
		var username = $('#hiddenUsername').val();
		
		var query = "?dlkid="+ID+"&dlk_patID="+ID+"&lnkid=" + lnkid;
		$.ajax({
		    type: "POST",
		    url: "calculateNEWS.php",
		    data: "page=PHYS&id=" + ID +"&user=" + username,
		    async: false,
		    success: function(msg){
			var ValsArr = msg.split('	');
			console.debug(ValsArr);
			console.debug("Score is " + ValsArr[0]);
			$('#phys-NEWSScore').val(ValsArr[0]);
			if (ValsArr[0] >= '6') { // NEWS Total
			    popitup('NEWSPopup.php','NEWS',query,550,1025);    
			}
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) {
			 rowID = 'Invalid';
			 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		});
	    });
	    
	    $('.calculateMEWS').change(function() {
		var ID = $('#patDLKID').val();
		var user = $('#hiddenUsername').val();
		$.ajax({
		    type: "POST",
		    url: "calculateMEWS.php",
		    data: "page=PHYS&id=" + ID + "&user=" + user,
		    async: false,
		    success: function(msg){
			//$('#testdiv').text(msg);
			var ValsArr = msg.split('	');
			$('#phys-EWSSScore').val(ValsArr[0]);
			if (ValsArr[0] >= '3') { // NEWS Total
			    $.prompt("EWS Score: " + ValsArr[0] + ". Medical intervention required!");    
			}
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) {
			 rowID = 'Invalid';
			 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		});
	    });
	    
	    /*
	     * End SOFA/NEWS/EWSS
	     */
	    
	    /*
	     * CSS menu stuff
	     */
	    $('.cssmenu ul li a').click(function() {
		$('.cssmenu ul li a.active_pat_tab').removeClass('active_pat_tab');
		$(this).closest('.cssmenu ul li a').addClass('active_pat_tab');
	    });
    
	    $('.cssmenu ul li ul li.tabsub a').click(function() {
		$('.cssmenu ul li a.active_pat_tab').removeClass('active_pat_tab');
		$(this).parents('ul').parents('li').find('a').addClass('active_pat_tab');
	    });
	    /*
	     * End CSS menu stuff
	     */	    
	    
	    $("#accordian h3").click(function(){
			//slide up all the link lists
			$("#accordian ul ul").slideUp();
			//slide down the link list below the h3 clicked - only if its closed
			if(!$(this).next().is(":visible"))
			{
			    $(this).next().slideDown();
			}
	    });     
	    
	    $('.resetButton').click(function() {
		var data = $(this).data();
		var target = data['target'];
		resetField(target);
	    });
	    
	    /*
	     * Tabbed nagivation jQuery stuff
	     *  If you add a tab, you need to add some code here to make it switch to the
	     *  correct page. the changeTab ID is zero-indexed, so take the #page-# of the tab and -1 eg #page-13 would be changeTab ID 12
	     */
	    // Assessments
	    
	    $('#tabAssessDetails').click(function() {
		changeTab(0);
	    });
	    
	    $('#tabPainAssessment').click(function() {
		changeTab(1);
	    });
	    
	    $('#tabPhysicalExamination').click(function() {
		changeTab(2);
	    });
	    
	    $('#tabPhysiology1A').click(function() {
		changeTab(3);
	    });
	    
	    $('#tabPhysiology1B').click(function() {
		changeTab(4);
	    });
	    
	    $('#tabPhysiology2').click(function() {
		changeTab(5);
	    });
	    
	    $('#tabSepsis').click(function() {
		changeTab(6);
	    });
	    
	    $('#tabMedications').click(function() {
		changeTab(7);
	    });
	    
	    $('#tabInterventions').click(function() {
		changeTab(8);
	    });
	    
	    $('#tabCriticalIncidents').click(function() {
		changeTab(9);
	    });
	    
	    $('#tabSurgery').click(function() {
		changeTab(10);
	    });
	    
	    $('#tabVisitOutcome').click(function() {
		changeTab(11);
	    });
	    
	    $('#tabTasks').click(function() {
		changeTab(12);
	    });
	    
	    $('#tabCareLevel').click(function() {
		changeTab(16);
	    });
	    
	    /*
	     * End tabbed nagivation
	     */ 
	    
	    /*
	     * Daily Outcome sublist stuff
	     */
	    $('#doActionTakenSublist, #do-actiontaken2').hide();
	    switch ($('#do-actiontaken').val()) {
		case "Refer for specialist assistance":
		    changeDropDown('do-actiontaken2','do-specialist','specialist');
		    console.debug("Here it is");
		    $('#doActionTakenSublist').text('Referred to');
		    $('#doActionTakenSublist, #do-actiontaken2').show();
		break;
		
		case "Transfer":
		    changeDropDown('do-actiontaken2','do-transfer','transfer');
		    $('#doActionTakenSublist').text('Transferred to');
		    $('#doActionTakenSublist, #do-actiontaken2').show();
		break;
	    
		default:
		    $('#doActionTakenSublist, #do-actiontaken2').hide();
		    $('#doActionTakenSublist').text('Action detail');
		break;
	    }
	    
	    $('#do-actiontaken').change(function() {
		var list = $(this).val();
		switch (list) {
		    case "Refer for specialist assistance":
			changeDropDown('do-actiontaken2','do-specialist','specialist');
			$('#doActionTakenSublist').text('Referred to');
			$('#doActionTakenSublist, #do-actiontaken2').show();
		    break;
		    
		    case "Transfer":
			changeDropDown('do-actiontaken2','do-transfer','transfer');
			$('#doActionTakenSublist').text('Transferred to');
			$('#doActionTakenSublist, #do-actiontaken2').show();
		    break;
		
		    default:
			$('#doActionTakenSublist, #do-actiontaken2').hide();
			$('#doActionTakenSublist').text('Action detail');
		    break;
		}
	    });
	    
	    /*
	     * End daily outcome sublist stuff
	     */
	    
	    /*
	     * Begin Physiology 1A
	     */
	    
	    // Limb calculation
	    
	    function getLimbScore(limb) {
		var limbScore = 0;
		switch (limb) {
		    case "None":
			limbScore = 0;
		    break;
		
		    case "Flicker":
			limbScore = 1;
		    break;
		
		    case "Movement":
			limbScore = 2;
		    break;
		
		    case "Movement against gravity":
			limbScore = 3;
		    break;
		
		    case "Movement against resistance":
			limbScore = 4;
		    break;
		
		    case "Full power":
			limbScore = 5;
		    break;
		}
		
		return limbScore;
	    }
	    
	    function calculateLimbScore(that) {
		var thisVal = $(that).val();
		var newLimbScore = getLimbScore(thisVal);
		var scoreSelectorID = $(that).attr('id');
		var scoreSelector = scoreSelectorID + "Score";
		$('#' + scoreSelector).val(newLimbScore);
		updateLimbTotal();
	    };
	    
	    function updateLimbTotal() {
		// Get all 4 number totals
		var leftArm = ($('#phys-LimbLeftArmScore').val().length > 0) ? parseInt($('#phys-LimbLeftArmScore').val(),10) : 0;
		var leftLeg = ($('#phys-LimbLeftLegScore').val().length > 0) ? parseInt($('#phys-LimbLeftLegScore').val(),10) : 0;
		var rightArm = ($('#phys-LimbRightArmScore').val().length > 0) ? parseInt($('#phys-LimbRightArmScore').val(),10) : 0;
		var rightLeg = ($('#phys-LimbRightLegScore').val().length > 0) ? parseInt($('#phys-LimbRightLegScore').val(),10) : 0;
		
		var newLimbTotal = leftArm+leftLeg+rightArm+rightLeg;
		
		// Update
		$('#phys-LimbTotal').val(newLimbTotal);
	    }
	    
	    // Initially calculate the score on page load if they exist
	    if ($('#phys-LimbLeftArm').length > 0) calculateLimbScore($('#phys-LimbLeftArm'));
	    if ($('#phys-LimbLeftLeg').length > 0) calculateLimbScore($('#phys-LimbLeftLeg'));
	    if ($('#phys-LimbRightArm').length > 0) calculateLimbScore($('#phys-LimbRightArm'));
	    if ($('#phys-LimbRightLeg').length > 0) calculateLimbScore($('#phys-LimbRightLeg'));
	    
	    $('#phys-LimbLeftArm, #phys-LimbLeftLeg, #phys-LimbRightArm, #phys-LimbRightLeg').change(function() {
		calculateLimbScore(this);
	    });
	    
	    /*
	     * End physiology 1A
	     */ 
	    
	    /*
	     * Begin auto-fill of dropdowns, mainly for primary/secondary diagnosis
	     * Select = ID of dropdown list to be changed and also the switch case to use in changeDropdown.php
	     * options = Specific option selected from dropdown
	     * specifier = Added later. In very few instances like daily outcome which dropdown list to change can depend on option select, so use this to specify which
	     * defaultVal = set the default selected option of new dropdown list
	     */ 
	    
	    function changeDropDown(select, options, specifier, defaultVal) {
		var dropdown = $("select#" + select + "");
		var val = $('#' + options + '').val();
		var optionID = $('#' + options + ' option').filter(function() {
		    return this.value == val;
		}).data('id');
		//console.debug("Option is: " + options + " and ID is " + optionID + " and val is " + val);
		dropdown.empty();
		dropdown.load("changeDropdown.php?dd=" + select + "&id=" + $('#' + options + '').val() + "&specifier=" + specifier + "&defaultVal=" + defaultVal);
		//dropdown.load("changeDropdown.php?dd=" + select + "&id=" + optionID);
	    }
	    
	    
	    if ($('#ass-assessmentReason').length > 0) {
		getOTRFollowUp();
	    }
	    
	    $('#ass-assessmentReason').change(function() {
		getOTRFollowUp();				
	    });
	    
	    function getOTRFollowUp() {
		var selectedOption = $('#ass-assessmentReason').find(":selected").text().replace(/ /g,"_"); // Replace whitespace with _ for URL transportation
		if (selectedOption.length > 0) {
		    $.ajax({
			type: "GET",
			url: "otrFollowUp.php",
			data: { "followup": selectedOption },
			async: false,
			success: function(msg){
			    var followUpVal = $('#hiddenOTRFollowUp').val().replace(/ /g,'');
			    $('#ass-detail').empty('');
			    changeDropDown('ass-detail','0',msg,followUpVal);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
			    rowID = 'Invalid';
			    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			} 
		    });	
		}		
	    }
	    
	    /*
	     * End primary/secondary diagnosis dropdown auto-fills
	     */ 
	    /*
	    $('#intensePainNowSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#intensePainNowSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#intensePainNowSlider" ).labeledslider( "value" ) );
	    $('input#intensePainNowSliderval').val($( "#intensePainNowSlider" ).labeledslider( "value" ));
	      
	    $('#intensePainLastWeekSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#intensePainLastWeekSliderval').val(ui.value);
		}
	      });
	      $( "#amount" ).val( $( "#intensePainLastWeekSlider" ).labeledslider( "value" ) );
	      $('input#intensePainLastWeekSliderval').val($( "#intensePainLastWeekSlider" ).labeledslider( "value" ));
	      
	      $('#distressingPainNowSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#distressingPainNowSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#distressingPainNowSlider" ).labeledslider( "value" ) );
	    $('input#distressingPainNowSliderval').val($( "#distressingPainNowSlider" ).labeledslider( "value" ));
	      
	    $('#distressingPainAverageSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#distressingPainAverageSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#distressingPainAverageSlider" ).labeledslider( "value" ) );
	    $('input#distressingPainAverageSliderval').val($( "#distressingPainAverageSlider" ).labeledslider( "value" ));
	      
	    $('#painAverageLastWeekSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#painAverageLastWeekSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#painAverageLastWeekSlider" ).labeledslider( "value" ) );
	    $('input#painAverageLastWeekSliderval').val($( "#painAverageLastWeekSlider" ).labeledslider( "value" ));
	      
	    $('#painEverydayActivitiesSlider').labeledslider({
		value:5,
		min: 0,
		max: 10,
		step: 1,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#painEverydayActivitiesSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#painEverydayActivitiesSlider" ).labeledslider( "value" ) );
	    $('input#painEverydayActivitiesSliderval').val($( "#painEverydayActivitiesSlider" ).labeledslider( "value" ));
	      
	    $('#painTreatmentReliefSlider').labeledslider({
		value:50,
		min: 0,
		max: 100,
		step: 10,
		tickInterval: 1,
		slide: function( event, ui ) {
		  $( "#amount" ).val( ui.value );
		},
		change: function(event, ui) {
		  $('input#painTreatmentReliefSliderval').val(ui.value);
		}
	    });
	    $( "#amount" ).val( $( "#painTreatmentReliefSlider" ).labeledslider( "value" ) );
	    $('input#painTreatmentReliefSliderval').val($( "#painTreatmentReliefSlider" ).labeledslider( "value" ));
	    */
	    
	    /*
	     * MEWS/EWS total score stuff
	     */
	    
	    function fetchEWSSScore(input,category) {
		/*$.ajax({
		    type: "POST",
		    url: "EWSSTriggerLevel.php",
		    data: "input=" + input + "&category=" + category,
		    async: true,
		    success: function(msg){					      
			EWSS_Score = parseInt(msg, 10);
	    		if (isNaN(EWSS_Score)) {
			EWSS_Score = 'Invalid';
			alert("An invalid response was given while attempting to fetch EWSS Score.");
			return false;
			} else {
			return EWSS_Score;
			}   
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) {
			 EWSS_Score = 'Invalid';
			 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		     }
		});*/
		return $.ajax({
		    type: "POST",
		    url: "EWSSTriggerLevel.php",
		    data: "input=" + input + "&category=" + category
		    //data: {"input": " " + input + " ", "category": " " + category + " "}
		}).then(function(EWSS_Score) {
		    if (isNaN(EWSS_Score)) {
			alert("An invalid response was given while attempting to fetch EWSS Score.");
			return 'Invalid';
		    }
		    return EWSS_Score;
		});
	    }
	    
	    function calculateEWSSTotal() {
		var HR = Number($('#heartRateWeighted').val());
		var resp = Number($('#respRateWeighted').val());
		var temp = Number($('#temperatureWeighted').val());
		var sysBP = Number($('#sysBPWeighted').val());
		var urine = Number($('#urineWeighted').val());
		var pain = Number($('#painWeighted').val());
		var O2sat = Number($('#O2SatWeighted').val());
		var GCS = Number($('#GCSWeighted').val());
		var baseExcess = Number($('#baseExcessWeighted').val());
		var ph = Number($('#pHWeighted').val());
		var pao2 = Number($('#pAO2Weighted').val());
		
		var total = Number(HR+resp+temp+sysBP+urine+pain+O2sat+GCS+baseExcess+ph+pao2);
		console.debug(HR, resp, temp, sysBP, urine, pain, O2sat, GCS, baseExcess, ph, pao2, total);
		$('#MEWSTotal').val(total);
		//$('#phys-EWSSScore').val(total);
	    }
	    
	    function calculateEWSSWeightedScore(input,category,weighted) {
		var EWSSScore = fetchEWSSScore(input,category).done(function(EWSSScore) {
		    $(weighted).val(EWSSScore);
		    calculateEWSSTotal();
		});
		/*alert("It is:" + EWSSScore);
		var EWSSScoreVal = EWSSScore.html();
		$(weighted).val(EWSSScoreVal);
		//$(weighted).text(EWSSScore);
		calculateEWSSTotal();*/
	    }
	    
	    $('#heartRate').change(function() {
		var category = "HR";
		var input = $(this).val();
		calculateEWSSWeightedScore(input,category,'#heartRateWeighted');
	    });
	    
	    $('#respRate').change(function() {
		var category = "Resp";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#respRateWeighted');
	    });
	    
	    $('#phys-temperature').change(function() {
		var category = "Temp";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#temperatureWeighted');	
	    });
	    
	    $('#sysBP').change(function() {
		var category = "BP";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#sysBPWeighted');
	    });
	    
	    $('#AVPU').change(function() {
		var category = "CNS";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#AVPUWeighted');
	    });
	    
	    $('#Urine').change(function() {
		var category = "Urine";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#urineWeighted');
	    });
	    
	    $('#Pain').change(function() {
		var category = "Pain";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#painWeighted');
	    });
	    
	    $('#O2Sat').change(function() {
		var category = "O2";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#O2SatWeighted');
	    });
	    
	    $('#Resp').change(function() {
		var category = "Resp";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#respSupportWeighted');
	    });
	    
	    $('#GCS').change(function() {
		var category = "GCS";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#GCSWeighted');
	    });
	    
	    $('#BaseExcess').change(function() {
		var category = "BE";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#baseExcessWeighted');
	    });
	    
	    $('#pH').change(function() {
		var category = "PH";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#pHWeighted');
	    });
	    
	    $('#pAO2').change(function() {
		var category = "PAO2";
		var input = $(this).val();		
		calculateEWSSWeightedScore(input,category,'#pAO2Weighted');
	    });
	    
	    /*
	     * End MEWS/EWS stuff
	     */
	    
	    /*
	     * Copying stuff from list to textbox - physical examination etc
	     */
	    
	    $(".tag").click(function(){
		var txt = $.trim($(this).text());
		var data = $(this).data();
		var type = data['type'];
		var box = $("#" + type + "TextArea");
		box.val(box.val() + txt + ':\n\n');
	    });
	    
	    /*
	     * End phys exam copying stuff
	     */
	    
	    /*
	     * Show hide sepsis based on likeliness
	     */
	    $('#sepsis').hide();
	    
	    $('#sps-sepsisOnArrival').change(function() {
		var sepsisArrival = $(this).val();
		
		if ((sepsisArrival === 'Likely') || (sepsisArrival === 'Very likely')) {
		    $('#sepsis').show();    
		}
		
		if ((sepsisArrival === 'Unlikely') || (sepsisArrival === 'Very unlikely')) {
		    $('#sepsis').hide();
		    $('#sps-sepsisSource').val('');
		}
	    });
	    
	    /*
	     * End show/hide sepsis
	     */
	    
	    /*
	     * Add outreach assessment details tags
	     */
	    $.fn.serializeObject = function()
	    {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
		    if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
			    o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		    } else {
			o[this.name] = this.value || '';
		    }
		});
		return o;
	    };
	     
	    $(function() {
		  var searchDiag = $( "#searchDiag" ),
		  allFields = $( [] ).add( searchDiag ),
		  tips = $( ".validateTips" );
		  
		$( "#ass-TagsForm" ).dialog({
		    autoOpen: false,
		    height: 400,
		    width: 800,
		    modal: true,
		    buttons: {
		      "Set Tags": function() {
			var bValid = true;
			var data = $(this).data();
			var page = data['page'];
			var checkboxes = [];
			var result = JSON.stringify($('#ass-TagsForm :input').serializeObject());
	       
			if ( bValid ) {
			  $.ajax({
			      type: "POST",
			      url: "assTags.php",
			      data: "assTags=" + result,
			      async: true,
			      success: function(msg){					      
				$('#assTagsResults').css('display','block');
				$('#assTagsResults').html(msg);
				setTimeout(function() {
				  $('#assTagsResults').css('display','none');
				  $('#assTagsResults').html('');
				}, 5000);
			      },
			      error: function(XMLHttpRequest, textStatus, errorThrown) {
				   rowID = 'Invalid';
				   alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			       } 
			    });
			  //$( this ).dialog( "close" );
			}
		      },
		      Cancel: function() {
			$('#assTagsResults').css('display','none');
			$('#assTagsResults').html('');
			$( this ).dialog( "close" );
		      }
		    },
		    close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		    }
		});
	     
		$( "#ass-TagsButton" )
		  .button()
		  .click(function() {
		    $( "#ass-TagsForm" ).dialog( "open" );
		  });
	      });
	     
	    /*
	     * End outreach assessment details tags
	     */
	
	}); // End jQuery
	/****************************/
	function OnSave(inForm)
	{
	//if (inForm.vsHospNum){} 
	//alert("Your patient will be saved now..."); //###

	return true;
	}
	/****************************/
	
	
	function toDemographics(patientID)
	{
	var strMsg = confirm("Are you sure you want to return to demographics? Any unsaved progress will be lost.");
	if (strMsg) {
	    window.location = "patDmg.php?lnkID=" + patientID +"#page-8";
	}
	}
	
	function logOutConfirm(lnkid) {
	    console.debug("Lnk ID is " + lnkid);
	    var strMsg = confirm("Are you sure you wish to log out? Any unsaved progress will be lost.");
	    if (strMsg) {
		$.ajax({
			type: "POST",
			url: "SQLLock_Unlock.php",
			data: "lnkid=" + lnkid,
			async: false,
			success: function(msg) {
			    //alert ("msg is " + msg);
			    window.location = "MelaClass/logoutAction.php";
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
			    rowID = 'Invalid';
			    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			} 
		    });
	    }	
	}
	
	function cancelConfirm(lnkid) {
	    var strMsg = confirm("Are you sure you want to cancel this patient?");
	    if (strMsg) {
		$.ajax({
		    type: "POST",
		    url: "SQLLock_Unlock.php",
		    data: "lnkid=" + lnkid,
		    async: false,
		    success: function(msg) {
			//alert ("msg is " + msg);
			window.location = "patListing.php";
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) {
			rowID = 'Invalid';
			alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		});
	    }
	}
	
	
 </script>	