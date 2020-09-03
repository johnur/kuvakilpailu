<?php get_header(); ?>
<?php

  // Create database connection
  $db = mysqli_connect("localhost", "root", "root", "image_upload");

  // Initialize message variable
  $msg = "";
 //If like button klicked
 if(isset($_POST['iiid']))
{
  //echo "<pre>";
  $iiid = $_POST['iiid'];
  $how_many_likes_sql = "SELECT * FROM competition";
  $result = mysqli_query($db, $how_many_likes_sql);
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "onko " . $row['id'] . " == $iiid?<br>";
      if($row['id'] == $iiid)
      {
        $num_of_likes = $row['piclike'];
        // echo "<pre>";
        // echo "num of likes $num_of_likes<br>";
        // die();
      }
    }
  }
  if(!is_numeric($num_of_likes))
  {
    $num_of_likes = 1;
  }
  else
  {
    $num_of_likes++;
  }

  // die();
  // print_r($_POST);
  // $iiid = $_POST['iiid'];
  $sql2 = "UPDATE competition SET piclike = $num_of_likes WHERE id = $iiid ";
  //$image_like = mysqli_real_escape_string($db, $_POST['image_like']);

  mysqli_query($db, $sql2);
}
  if (isset($_POST['likebutton'])) {
  $sql2 = "UPDATE competition SET piclike = piclike + 1 WHERE id = :id ";
  $image_like = mysqli_real_escape_string($db, $_POST['image_like']);

  mysqli_query($db, $sql2);
  }

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	
  	$image = $_FILES['image']['name'];

  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
  	$image_author = mysqli_real_escape_string($db, $_POST['image_author']);
  	$author_email = mysqli_real_escape_string($db, $_POST['author_email']);
	

  	// image file directory
  	$target = "/Users/joushy/Local Sites/harkka/app/public/wp-content/themes/g-works/uploads/".basename($image);


  	$sql = "INSERT INTO competition (title, name, email, image) VALUES ('$image_text', '$image_author', '$author_email', '$image')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT id, title, name, image, piclike FROM competition");
?>
 
    


<div id="section1"> 
		<div class="wrapper">
			<div class="left">
				 <h1>Osallistumisen pääotsikko</h1>
				<p>Lyhyt kuvaus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu.</p>
				<button id="button1"><p>OSALLISTU CTA</p></button>
   			</div>
   		 	<div class="right">
     		 <img id="pic" src="<?php echo get_stylesheet_directory_uri(); ?>/images/kuva.jpg"/>
  			</div>
	</div>
</div>

<div  id="section2">
	<h2>Kilpailun kuvat ostikko</h2>
	<p>Aikaa osallistua ja äänestää 1.2.2020 asti</p>
	<div class="grid">
		
	<!-- 	näyttää kuvat tietokannasta  -->
		<?php
    while ($row = mysqli_fetch_array($result)) {

      echo "<div id='img_div'>";
      	echo "<img src='http://harkka.local/wp-content/themes/g-works/uploads/".$row['image']."' >";

      	echo "<form method='post' action='index.php' enctype='multipart/form-data'>
        <input type=\"hidden\" value=\"" . $row['id'] . "\" name=\"iiid\"></input>
        <input type='submit' id='voteBtn' value='ÄÄNESTÄ' name='likebutton' >
        </form>";
   //    	echo "<label id='voteBtn'>
			//   <input type='checkbox' name='likebutton' value='JAA'>
			//   <span class='slider'></span>
			// </label>";


		echo "<p>".$row['piclike']."</p>";
		echo "<p>".$row['id']."</p>";

      	echo "<p id='picTitle'>".$row['title']."</p>";
      	echo "<p id='picAuthor'>".$row['name']."</p>";
      echo "</div>";
    }
  ?>
	</div>
</div>


<div id="section3">
	<div class="wrapper">
			<div class="left3">
				<h2 id="section3Header">Osallistu kilpailuun!</h2>
				<p id="section3text">
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. <br> <br>
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. <br> <br>
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien.
				</p>
   			</div>
   		 	<div class="right3">
   		 		


     		<form method="post" action="index.php" enctype="multipart/form-data">
     			<input type="hidden" name="size" value="1000000">
				<div tabindex="1">
	     			<p>Kuvan otsikko</p>
	     			<input id="formi" type="text" name="image_text">
     			</div>
     			<div tabindex="2">
	     			<p>Nimi *</p>
	     			<input id="formi" type="text" name="image_author">
	     		</div>
	     		<div tabindex="3">
	     			<p>Sähköposti *</p>
	     			<input id="formi" type="e-mail" name="author_email" > <br> <br>
     		    </div>

     			<div id="hide">
			  <button id="addPicture">
			  <input  type="file" nv-file-select name="image" value="VALITSE KUVA" id="fileToUpload"> VALITSE KUVA </button><br>
			  </div>




				<label class="boxcontainer">Hyväksyn kilpailun <a href="default.asp" target="_blank">säännöt ja ehdot</a>
				  <input type="checkbox" >
				  <span class="checkmark"></span>
				</label>


			  <input style="width: 155px; height: 48px; border-radius: 24px; background-color: #E5007C; color: white; font-size: 16px; font-family: Vinkel-Bold; letter-spacing: 2px;" type="submit" value="OSALLISTU" name="upload">
			</form>
  			</div>
	</div>
</div>

<div id="section4">
<div id="left4">
	<h2 id="rules">Säännöt ja ehdot</h2>

	<p>
		Kilpailuaika 1.1.2020-1.2.2020 <br>
		Kilpailun järjestää Kansallisteatteri Lorem ipsum dolor sit amet Yms.
	</p>
</div>
<div id="right4">
	<p id="rulestext">
     			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti. Lorem ipsum ligula ut hendrerit mollis, ipsum erat vehicula risus, eu suscipit sem libero nec erat. Aliquam erat volutpat. Sed congue augue vitae neque. Nulla consectetuer porttitor pede. Fusce purus morbi tortor magna condimentum vel, placerat id blandit sit amet tortor. <br>
     			<br>
     			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti. Lorem ipsum ligula ut hendrerit mollis, ipsum erat vehicula risus, eu suscipit sem libero nec erat. Aliquam erat volutpat. Sed congue augue vitae neque. Nulla consectetuer porttitor pede. Fusce purus morbi tortor magna condimentum vel, placerat id blandit sit amet tortor. <br> <br>
     				Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed posuere interdum sem. Quisque ligula eros ullamcorper quis, lacinia quis facilisis sed sapien. Mauris varius diam vitae arcu. Sed arcu lectus auctor vitae, consectetuer et venenatis eget velit. Sed augue orci, lacinia eu tincidunt et eleifend nec lacus. Donec ultricies nisl ut felis, suspendisse potenti. Lorem ipsum ligula ut hendrerit mollis, ipsum erat vehicula risus, eu suscipit sem libero nec erat. Aliquam erat volutpat. Sed congue augue vitae neque. Nulla consectetuer porttitor pede. Fusce purus morbi tortor magna condimentum vel, placerat id blandit sit amet tortor. <br>
     </p>
 </div>
</div>
 
</div>



<?php get_footer();

?>

