<?php
$product_id=$_GET['id'];
// echo $product_id;
?>
<?php
require('../dbconnect.php');

?>

<?php
// echo "1<br>";
// The width and height below are for the images and has to be entered by the admin
// $width="100%";//The value should be taken from the DB



   $product_id = $_GET['id'];
$status_for_audio=isset($_GET['status_for_audio'])?$_GET['status_for_audio']:0;

   $status_of_audio_for_home_image=0;

   // $image = "001.jpg";

	$query1="SELECT * FROM oc_product_interactivity WHERE product_id = '" . $product_id . "' ORDER BY interactivity_order";		
	$result1=mysql_query($query1);
	
	$a = 0;
	while($row = mysql_fetch_array($result1)) 
	{
		$id[$a] = $row['interactivity_id'];
		$name[$a] = $row['interactivity_name'];
		$order[$a] = $row['interactivity_order'];
		$interactivity[$a] = $row['Pinteractivity'];
		$frames[$a] = $row['frames'];
		$frame[$a] = $row['frame'];
		$rows[$a] = $row['rows'];
		$roww[$a] = $row['row'];
		$time[$a] = $row['frame_change'];
		$horizontal[$a] = $row['hor_rotation'];
		$vertical[$a] = $row['ver_rotation'];
		$audioCondition[$a] = $row['audio_condition'];
		$audio[$a] = $row['audio_name'];
		$video[$a] = $row['video_url'];
		//echo $video[$a];
		$a++;
	}


	$query8="SELECT * FROM oc_product_customize WHERE product_id = '" . $product_id . "'";		
	$result8=mysql_query($query8) or die(mysql_error());
	
	while($row = mysql_fetch_array($result8)) 
	{
		$scalerequired = $row['scale'];
		$buttoncolor = $row['button_color'];
		$textcolor = $row['text_color'];
		$bandcolor = $row['band_color'];
		$hotspot = $row['hotspot_function'];//If the hotspot fuctionality is enabled
		$hotspot_folder_name = $row['hotspot_file_name'];//If so the file name of the image should be mapped in here
		$width=$row['width'];//The height is loaded from database
		$height=$row['height'];//The width is loaded from database
	}	
		//Add a field in database to check if its hotspot
		// $hotspot=1; 
	//Setting width and height from database

		$query9="SELECT * FROM oc_product_hotspot WHERE product_id = '" . $product_id . "'";	
		// echo $query9;	
	$result9=mysql_query($query9) or die(mysql_error());
	
	while($row = mysql_fetch_array($result9)) 
	{
		$map_code = $row['map_code'];
		$number_of_hotspot = $row['number_of_hotspot'];
		$width=$row['width'];//The height is loaded from database
		$height=$row['height'];//The width is loaded from database
		$heading=$row['name'];
		$image_url=$row['home_image_link'];
		$audio_for_home_image=$row['audio_for_home_image'];
	}	
		// code for responsive popup should come here  
	//Setting width and height from database
// echo $map_code;	

	$width=isset($_GET['width'])?$_GET['width']:"799px";
$height=isset($_GET['height'])?$_GET['height']:"499px";

$width_for_iframe=IntVal(str_replace("px","",$width));
$height_for_iframe=IntVal(str_replace("px","",$height));
$height_for_iframe=$height_for_iframe-($height_for_iframe*0.105);

if(!is_null($audio_for_home_image))
{
	$status_of_audio_for_home_image=1;
	$audio_file_name_for_home_image=$audio_for_home_image;
}
else
{
	$status_of_audio_for_home_image=0;
}
?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/howler.js"></script>
<script type="text/javascript" src="../js/howler.min.js"></script>


  <style>
	body {
		font-family: Helvetica, Arial, sans-serif;
		width: <?php echo $width?> !important;
		height: <?php echo $height?> !important;

	}
	h1 {
		font-size: 20px;
	}
	div {
		width: 100%;
	}
	img[usemap] {
		border: none;
		height: auto;
		max-width: 100%;
	}
  </style>

  <style>
    .heading-reveal-modal 
	{
	  width: 100%;
	  height: 28px;
	  background: white;
	  border-bottom: 1px solid #e31937;
	  text-align: center;
	  font-weight: semi-bold;
	  font-size: 17px;
	  color: #e31937;
	  padding-top: 8px;
	  font-family: Arial, Helvetica, sans-serif;
	}
	
    input[type="button"] 
	{
	  color: rgb(255, 255, 255);
      background: rgb(11, 174, 249);
	  font-size: 11px;
	  border-radius: 7px;
	  margin-left: 1px;
	  border: 0;
	  height: 24px;
	  padding: 0px 12px 0px 12px;
	  font-family: Arial, Helvetica, sans-serif;
	  cursor: pointer;
	}  
  </style>

</head>

<body>

<!-- If the product home screen has audio [IE-70]   -->

<?php
if(($status_of_audio_for_home_image==1)&&($status_for_audio==0))
{
?>

<script type="text/javascript">

$(window).bind('unload', function () {
    if(event.clientY < 0) {  
        alert('Thank you for using this app.');
        endSession(); // here you can do what you want ...
    }  
    });
window.onbeforeunload = function () {
    $(window).unbind('unload');
    //If a string is returned, you automatically ask the 
    //user if he wants to logout or not...
    //return ''; //'beforeunload event'; 
    if (event.clientY < 0) {
        alert('Thank you for using this service.');
        endSession();
    }  
}  



$(window).unload(function() {
    var answer=confirm("Are you sure you want to leave?");
if(answer){
    //ajax call here
    }
});


var status_of_refresh=0;
  if(document.cookie.indexOf('mycookie')==-1) {
    // cookie doesn't exist, create it now
    document.cookie = 'mycookie=1';
  }
  else {
    // not first visit, so alert
    // alert('You refreshed!');
    status_of_refresh=1;
  }
	var audio_for_home_img="";
	audio_for_home_img=<?php echo json_encode($audio_file_name_for_home_image);?>;
	// var data='<audio id="audio_for_hotspot" controls/>';

	$(".image_map").click(function() {
sound.pause();
	});
if(status_of_refresh!=1)
{
	var sound = new Howl({
  urls: ['audio/'+audio_for_home_img]
}).play();
}



</script>

<!-- <div id="audio_content_for_hotspot"></div> -->

<?php
}
?>
<!-- If the product home screen has audio [IE-70]  -->

  <img src="<?php echo $image_url;?>" width="<?php echo $width;?>px" height="<?php echo $height;?>px">
  <div id="first" style=" border-left: 2px; border-top: 2px;">
<?php
echo $map_code;
?>
  </div>	

 
  

	<script src="jquery.rwdImageMaps.min.js"></script>

	<script type="text/javascript">
  $(".image_map" ).click(function() {
  var href=$( this ).attr('href');
  // alert(href+"Thidsghvjxfgkxfkl");
  href=href+'&width='+<?php echo $width_for_iframe;?>+'px&height='+<?php echo $height_for_iframe;?>+'px';
  // $( this ).attr('href')=href;
  $(this).attr("href",href);
  // alert("done");
  });

  </script>

	<script type="text/javascript">

// obselete  code  // 

	$(document).ready(function(e) {
	//alert("Inn");
		$('img[usemap]').rwdImageMaps();
		
		$(function() 
        {
			 $('#click_8').click(function() 
			 {
			   //alert("Success");
			   $('#first').hide();
			   $('#third').hide();
			   $('#fourth').hide();
			   $('#fifth').hide();
			   $('#second').show();
			 });
			 
			 $('#backtohome').click(function() 
			 {
			   //alert("Success");
			   $('#second').hide();
			   $('#first').show();
			 });
			 

		});
		
		//$('area').on('click', function() {
			//alert($(this).attr('alt') + ' clicked');
		//});
	});
// obselete  code  // 
	
	</script> 
	
	<style>
		.grow img 
		{
		  height: 165px;
		  width: 165px;
		 
		  -webkit-transition: all 1s ease;
			 -moz-transition: all 1s ease;
			   -o-transition: all 1s ease;
			  -ms-transition: all 1s ease;
				  transition: all 1s ease;
		}
		 
		.grow img:hover 
		{
		  width: 220px;
		  height: 220px;
		}


		 
		.pic 
		{
		  border: 5px solid #fff;  
		 
		  -webkit-box-shadow: 5px 5px 5px #111;
				  box-shadow: 5px 5px 5px #111;  
		}
    </style>

</body>
</html>	
