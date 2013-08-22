<script type="text/javascript">
    $(function() {
		var searchDiag = $( "#searchDiagICD10" ),
		  allFields = $( [] ).add( searchDiag ),
		  tips = $( ".validateTips" );
                  
                var searchProc = $( "#searchProc" ),
		  allFields = $( [] ).add( searchProc ),
		  tips = $( ".validateTips" );  
	     
		function updateTips( t ) {
		  tips
		    .text( t )
		    .addClass( "ui-state-highlight" );
		  setTimeout(function() {
		    tips.removeClass( "ui-state-highlight", 1500 );
		  }, 500 );
		}
	     
		function checkLength( o, n, min, max ) {
		  if ( o.val().length > max || o.val().length < min ) {
		    o.addClass( "ui-state-error" );
		    updateTips( "Length of " + n + " must be between " +
		      min + " and " + max + "." );
		    return false;
		  } else {
		    return true;
		  }
		}

		/*
		 * Allow users to press enter to submit form data
		 * without it submitting the entire form - DISABLED, THIS CAUSED ISSUES WITH 4D CONNECTIONS
		 */
		/*
		$('#ICD10-search-form-condition').keypress(function(event){	
		    var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13'){
			$.ajax({
			    type: "POST",
			    url: "ICD10Search.php",
			    data: "lnk=" + <?php echo $patient['LNK_ID']; ?> + "&type=2&search="+ searchDiag.val(),
			    async: true,
			    success: function(msg){					      
			      $('#diagnosisResults').css('display','block');
			      $('#diagnosisResults').html(msg);
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			     } 
			  });
			event.preventDefault();
		    }
		});
		
		$('#ICD10-search-form-procedure').keypress(function(event){	
		    var keycode = (event.keyCode ? event.keyCode : event.which);
		    if(keycode == '13'){
			$.ajax({
			    type: "POST",
			    url: "ICD10Search.php",
			    data: "lnk=" + <?php echo $patient['LNK_ID']; ?> + "&type=1&search="+ searchProc.val(),
			    async: true,
			    success: function(msg){					      
			      $('#diagnosisResults2').css('display','block');
			      $('#diagnosisResults2').html(msg);
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			     } 
			  });
			event.preventDefault();
		    }
		});*/
		
		/*
		 * End enter keypress and begin mouse click
		 */ 
	     
		$( "#ICD10-search-form-condition" ).dialog({
		  autoOpen: false,
		  height: 500,
		  width: 800,
		  modal: true,
		  buttons: {
		    "Search selection": function() {
		      var bValid = true;
		      allFields.removeClass( "ui-state-error" );
		      var submitButton = $(".ui-dialog-buttonpane button:contains('Search selection')");
		      submitButton.button("disable");
	     
		      //bValid = bValid && checkLength( hospNum, "Hospital Number", 1, 16 );
	     
		      if ( bValid ) {
			$.ajax({
			    type: "POST",
			    url: "ICD10Search.php",
			    data: "lnk=" + <?php echo $patient['LNK_ID']; ?> + "&type=2&search="+ searchDiag.val(),
			    async: true,
			    success: function(msg){					      
			      $('#diagnosisResults').css('display','block');
			      $('#diagnosisResults').html(msg);
			      submitButton.button("enable");
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown);
				 submitButton.button("enable");
			     } 
			  });
			//$( this ).dialog( "close" );
		      }
		    },
		    Done: function() {
		      $('#diagnosisResults2').css('display','none');
		      $('#diagnosisResults2').html('');
		      $( this ).dialog( "close" );
		    },
		    Cancel: function() {
		      $('#diagnosisResults').css('display','none');
		      $('#diagnosisResults').html('');
		      $( this ).dialog( "close" );
		    }
		  },
		  close: function() {
		    allFields.val( "" ).removeClass( "ui-state-error" );
		  }
		});
                
                $( "#ICD10-search-form-procedure" ).dialog({
		  autoOpen: false,
		  height: 500,
		  width: 800,
		  modal: true,
		  buttons: {
		    "Search selection": function() {
		      var bValid = true;
		      allFields.removeClass( "ui-state-error" );
		      var submitButton = $(".ui-dialog-buttonpane button:contains('Search selection')");
		      submitButton.button("disable");
	     
		      //bValid = bValid && checkLength( hospNum, "Hospital Number", 1, 16 );
	     
		      if ( bValid ) {
			$.ajax({
			    type: "POST",
			    url: "ICD10Search.php",
			    data: "lnk=" + <?php echo $patient['LNK_ID']; ?> + "&type=1&search="+ searchProc.val(),
			    async: true,
			    success: function(msg){					      
			      $('#diagnosisResults2').css('display','block');
			      $('#diagnosisResults2').html(msg);
			      submitButton.button("enable");
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown);
				 submitButton.button("enable");
			     } 
			  });
			//$( this ).dialog( "close" );
		      }
		    },
		    Done: function() {
		      $('#diagnosisResults2').css('display','none');
		      $('#diagnosisResults2').html('');
		      $( this ).dialog( "close" );
		    },
		    Cancel: function() {
		      $('#diagnosisResults2').css('display','none');
		      $('#diagnosisResults2').html('');
		      $( this ).dialog( "close" );
		    }
		  },
		  close: function() {
		    allFields.val( "" ).removeClass( "ui-state-error" );
		  }
		});
	     
		$( "#search-diagnosis-condition" )
		  .button()
		  .click(function() {
		    $( "#ICD10-search-form-condition" ).dialog( "open" );
		  });
                  
		$( "#search-diagnosis-procedure" )
		  .button()
		  .click(function() {
		    $( "#ICD10-search-form-procedure" ).dialog( "open" );
		  });
	      });
	    
	    $(".ICD10SearchBtn").click(function(){			      
		$("#ICD10Results").load("ICD10Search.php?search=" + $("#search").val());  
	    });
	    
	    /*$('#searchDiag').click(function(){	
		alert("Hello");
	    });
	    
	    $('#searchDiag').keypress(function(event){	
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			alert('You pressed a "enter" key in somewhere');	
		}
		return false;
	    });
	    
	    $('#searchDiag').bind("keypress", function(e) {
		alert("Keypress 1");
		var code = e.keyCode || e.which; 
		if (code  == 13) {               
		  $("#ICD10Results").load("ICD10Search.php?search=" + $("#search").val()); 
		  return false;
		}
	    });*/
	    
	    $('#searchDiagICD10').keyup(function(e) {
		alert("Keypress 2");
		e.preventDefault();	      
		if(e.keyCode == 13) {
		    alert("Hello");
		    $("#ICD10Results").load("ICD10Search.php?search=" + $("#searchDiag").val()); 
		    return false;
		}
		return false;
	    }); 
            
            $(document).on('click', '.deleteICD10Row', function() {
		var data = $(this).data();
                var icdid = data['icdid'];
                var lnk = data['lnk'];
		
		$.ajax({
		   type: "POST",
		   url: "DeleteICD10Row.php",
		   data: "lnk_ID=" + lnk + "&ICD_ID=" + icdid,
		   success: function(msg){
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		    } 
		 });
	    
		var whichtr = $(this).closest("tr");       
		whichtr.remove();
	    });

</script>




    <button type='button' style='font-size:small;' id='search-diagnosis-condition'>Condition</button>
    <button type='button' style='font-size:small;' id='search-diagnosis-procedure'>Procedure</button>


<div id='ICD10-search-form-condition' title='Add Condition'>                       
    <form>
        <!-- <fieldset> -->
            <div class='textBox'>
            	Search  
                    <input type='search' value='' maxlength='500' name='searchDiagICD10' id='searchDiagICD10'>
                        
                    <!--<div class="diagnosisSearchBtn">  
                        &nbsp;  
                    </div>-->
                    <div id='diagnosisResults'>
        
                    </div>
            </div>
        <!-- </fieldset> -->
    </form>                            
</div>

<div id='ICD10-search-form-procedure' title='Add Procedure'>                       
    <form>
        <!-- <fieldset> -->
            <div class="textBox">  
            	Search
                    <input type="search" value="" maxlength="500" name='searchProc' id='searchProc'>
                    <div id="diagnosisResults2">
                    </div>
            </div>
        <!-- </fieldset> -->
    </form>                            
</div>

<table class="temp ICD10Records">
    <thead>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th>Type</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT pat.ICD10_ID,
            icd.Type, icd.Code, icd.Description
            FROM PatICD10 pat
            LEFT OUTER JOIN ICD10 icd ON pat.ICD10_ID = icd.ID
            WHERE pat.Link_ID=".$patient['LNK_ID']."
            ORDER BY icd.Type, icd.Code ASC";
            try { 
                $result = odbc_exec($connect,$query); 
                if($result){ 
                    while ($existingICDRows = odbc_fetch_array($result)) {
                    $codeWord = ($existingICDRows['TYPE'] == 1) ? "Procedure" : "Condition";
                    print "<tr>
                            <td>".$existingICDRows['CODE']."</td>
                            <td>".$existingICDRows['DESCRIPTION']."</td>
                            <td>$codeWord</td>
                            <td class='ICD10DelBut'>
                                <button id='".$existingICDRows['ICD10_ID']."' type='button' data-icdid='".$existingICDRows['ICD10_ID']."' data-lnk='".$patient['LNK_ID']."' class='deleteICD10Row'><img src='Media/img/bin.gif' alt='Delete'/></button>
                            </td>
                           </tr>";
                    }
                } 
                else{ 
                throw new RuntimeException("Failed to connect."); 
                } 
                    } 
                catch (RuntimeException $e) { 
                        print("Exception caught: $e");
                        //exit;
                }	
	?>


    </tbody>
</table>