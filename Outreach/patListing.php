<!DOCTYPE html>
    <html lang="eng">
<?php
error_reporting(E_ALL ^ E_NOTICE);

include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

?>
<head>
<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>  
<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>		
<link type="text/css" rel="stylesheet" href="media/css/jquery css.css"/>		
<link type="text/css" rel="stylesheet" href="media/css/styleTabs.css">
<link type="text/css" rel="stylesheet" href="media/css/PatListing.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jPages.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jquery-impromptu.css"/>
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/jPages.min.js"></script>
<script src="media/js/jquery-ui-1.10.3.min.js"></script>
<script src="media/js/jquery-impromptu.js"></script>



<script type="text/javascript">
    $(document).ready(function(){
	jQuery.expr[':'].contains = function(a,i,m){
	       return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	   };
     

	   

	// $('tbody tr[data-href]').addClass('clickable').click( function() { //td:not(:last-child)
	$('.normal tr[data-href]').addClass('clickable').click( function() { //td:not(:last-child)
	    var data = $(this).data();
	    var href = data['href'];
	    var lnkid = data['lnkid'];
	    var user = $('#userID').val();
	    $.ajax({
		type: "POST",
		url: "SQLPatLockCheck.php",
		data: "lnkID=" + lnkid + "&user=" + user,
		async: false,
		success: function(msg){
		    if (msg.length > 0) {
		     $.prompt(msg);
		    } else {
		    window.location = href;
		    }
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		    rowID = 'Invalid';
		    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		} 
	    });
	    
	});




	$('.desktop tr[data-href]').addClass('clickable').click( function() { //td:not(:last-child)
	    var data = $(this).data();
	    var href = data['href'];
	    var lnkid = data['lnkid'];
	    var user = $('#userID').val();

	    

	});

    $('.desktop tr').click(function() {
	$('.desktop tr.active_row').removeClass('active_row');
	$(this).closest('.desktop tr').addClass('active_row');
    });
 




     

	$('input[name="search"]').focus(function(){
		    $("div.holder").jPages("destroy");
		    $("div.holder").jPages({
			    containerID : "patlisting",
			    previous : "previous",
			    next : "next",
			    perPage : 10,
			    delay : 20
		    });
	});
	 
	$('input[name="search"]').focus(function(){
		    $("div.holder_desktop").jPages("destroy");
		    $("div.holder_desktop").jPages({
			    containerID : "patlisting",
			    previous : "previous",
			    next : "next",
			    perPage : 19,
			    delay : 20
		    });
	});






	$('input[name="search"]').keyup(function(){ 
		    
	    var searchterm = $(this).val();
	    
	    if(searchterm.length > 2) {
		    var match = $('tr.data-row:contains("' + searchterm + '")');
		    var nomatch = $('tr.data-row:not(:contains("' + searchterm + '"))');
		    //match.children().addClass('selected-cell');
		    match.addClass('selected');
		    nomatch.css("display", "none");
	    } else {
		    $('tr.data-row').css("display", "");
		    $('tr.data-row').removeClass('selected');
		    //$('tr.data-row td').removeClass('selected-cell');
	    }
	    
	    if (searchterm.length === 0) {
			$("div.holder").jPages("destroy");
			$("div.holder").jPages({
				    containerID : "patlisting",
				    previous : "previous",
				    next : "next",
				    perPage : 10,
				    delay : 20
			    });

			$("div.holder_desktop").jPages("destroy");
			$("div.holder_desktop").jPages({
				    containerID : "patlisting",
				    previous : "previous",
				    next : "next",
				    perPage : 19,
				    delay : 20
			    });

	    }
			    
	});
     
	$(function() {
	   var hospNum = $( "#hospNum" ),
	     allFields = $( [] ).add( hospNum ),
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
	
	   $( "#dialog-form" ).dialog({
	     autoOpen: false,
	     height: 120,
	     width: 280,
	     modal: true,
	     buttons: {
	       "Add new patient": function() {
		 var bValid = true;
		 //allFields.removeClass( "ui-state-error" );
	
		 bValid = bValid && checkLength( hospNum, "Hospital Number", 1, 16 );
	
		 if ( bValid ) {
		   $.ajax({
		       type: "POST",
		       url: "addPatient.php",
		       data: "hospNum="+ hospNum.val(),
		       async: false,
		       success: function(msg){
			   var bits = msg.split('	');
			   if (bits[1].length > 0) {
			    $.prompt(bits[1]);
			   } else {
			    //$.prompt("Everything's fine");
			    var user = $('#userID').val();
			    $.ajax({
				type: "POST",
				url: "SQLPatLockCheck.php",
				data: "lnkID=" + bits[0] + "&user=" + user,
				async: false,
				success: function(msg){
				    window.location.assign("patDmg.php?lnkID="+bits[0]);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				    rowID = 'Invalid';
				    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
				} 
			    });
			   
			   }
		       },
		       error: function(XMLHttpRequest, textStatus, errorThrown) {
			    rowID = 'Invalid';
			    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			} 
		     });
		   $( this ).dialog( "close" );
		 }
	       },
	       Cancel: function() {
		 $( this ).dialog( "close" );
	       }
	     },
	     close: function() {
	       //allFields.val( "" ).removeClass( "ui-state-error" );
	     }
	   });
	
	   $( "#create-user" )
	     .button()
	     .click(function() {
	       $( "#dialog-form" ).dialog( "open" );
	     });


	   $( "#sign-out" )
	     .button()
	     .click(function() {
	       window.location = "MelaClass/logoutAction.php"
	     });





	});
     
    });
</script>
<script type="text/javascript">
    $(function(){
		$("div.holder").jPages({
		    containerID : "patlisting",
		    previous : "previous",
		    next : "next",
		    perPage : 10,
		    delay : 20
		});

		$("div.holder_desktop").jPages({
		    containerID : "patlisting",
		    previous : "previous",
		    next : "next",
		    perPage : 19,
		    delay : 20
		});

     });
</script>
<title>
    <?php echo $preferences['prf_HospitalName']; ?>
</title>
</head>
<?php
// This supposedly speeds up rendering time - see http://developer.yahoo.com/performance/rules.html#etags
flush();
?>
<body>


<?php
 // include './patListing_Normal.php';
include './patListing_Desktop.php';
?>

</body>
</html>