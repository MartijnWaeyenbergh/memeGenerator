<?php

/*

	MEME IMAGE GENERATOR
	--------------------------------
	make a meme image based on an input image, witdth and a top and botton text (optional)
	The class will generate the meme and store the generated image in an folder called 'memes'.
	The generated image is scaled to the desired width.
	The text is embedded in the image.

	Example images are given in the folders:
	/memeOrgis/ => soms example 'empty' memes
	/memes/ => output directory

	the classic meme font is 'impact.ttf', but any ttf font can be used

	

*/


if(isset($_POST['submit'])){

	require("class.meme.php");

	$meme = new meme();

	$meme->texttop = $_POST['texttop'];			// text to put in top part of image
	$meme->textbottom = $_POST['textbottom'];	// text to put in bottom part of image
	$meme->font = "Impact.ttf";					// ttf file must be in the same directory
	$meme->width = "500";						// the width of the generated image
	$meme->createImage();

}

?>

	<form action="" method='post' enctype='multipart/form-data'>
		<fieldset>
	  		<legend>Create your own meme:</legend>
	  		<table>
	  				<tr><td>Top text:</td>
	  				<td><input type='text' name='texttop' placeholder='top text'></td>
	  			</tr>
	  			<tr>
	  				<td>Bottom text:</td>
	  				<td><input type='text' name='textbottom' placeholder='bottom text'></td>
	  			</tr>
	  			<tr>
	  				<td>Upload photo:</td>
	  				<td><input type="file" name="file" id="file"></td>
	  			</tr>
	  			<tr>
	  				<td colspan=2><input type="submit" name="submit" value="create!"></td>
	  			</tr>
	  		</table>
		</fieldset>
	</form>