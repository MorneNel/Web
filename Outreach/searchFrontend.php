<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/db.php';
// Testing get ajax info from db to fill textbox
?>
<link rel="stylesheet" type="text/css" media="screen" href="css.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){  
  
  //show loading bar  
  
  function showLoader(){  
  
    $('.search-background').fadeIn(200);  
  
  }  
  
  //hide loading bar  
  
  function hideLoader(){  
  
    $('#sub_cont').fadeIn(1500);  
  
    $('.search-background').fadeOut(200);  
  
  };  
  
  $('#search').keyup(function(e) {  
  
    if(e.keyCode == 13) {  
  
      showLoader();  
  
      $('#sub_cont').fadeIn(1500);  
  
      $("#content #sub_cont").load("search.php?search=" + $("#search").val(), hideLoader());  
  
    }  
  
  });  
  
  $(".searchBtn").click(function(){  
  
    //show the loading bar  
  
      showLoader();  
  
      $('#sub_cont').fadeIn(1500);  
      $("#content #sub_cont").load("search.php?search=" + $("#search").val(), hideLoader());  
  });  
  
});  
</script>
</head>
<body>

<div class="textBox">  
  
  <input type="text" value="" maxlength="100" name="searchBox" id="search">  
  
  <div class="searchBtn">  
  &nbsp;  
  </div>  
  
  </div> 

  <br clear="all" />  

  <div id="content">  
      
    <div class="search-background">  
  
      <label><img src="loader.gif" alt="" /></label>  
  
    </div>	
    <div id="sub_cont">
      <table border='0'  id='content' cellspacing='0' cellpadding='0'>
	<tr bgcolor='#FFFFCC'>
		<th>Firstname</th>
		<th>Lastname</th>
        </tr>
      </table>
    
    </div>
  
  </div>    
</body>
