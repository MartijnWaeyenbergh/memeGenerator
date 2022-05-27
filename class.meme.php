<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class meme{

	public $texttop;
	public $textbottom;
	public $font;
	public $width;
	public $newHeight;
	public $imageOutput;
	public $colorWhite;
	public $colorBlack;


	public function __construct(){

	}

	public function defineFont(){
		$this->font = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR . $this->font;
	}

	public function addTopText(){
		$this->imagettfstroketext($this->imageOutput, 30, 0, 10, 45, $this->colorWhite, $this->colorBlack, $this->font, strtoupper($this->texttop), 2);
	}

	public function addBottomText(){
		$this->imagettfstroketext($this->imageOutput, 30, 0, 10, ($this->newheight - 25), $this->colorWhite, $this->colorBlack, $this->font, strtoupper($this->textbottom), 2);
	}
	

	public function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
		for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
	        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
	            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
	   	return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
	}

	public function createImage(){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES["file"]["error"] > 0) {
		    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		  } else {
		    if (file_exists("memes/" . $_FILES["file"]["name"])) {
		      echo $_FILES["file"]["name"] . " already exists. ";
		    } else {

		    	$uploadedfile = $_FILES['file']['tmp_name'];
				if($extension=="jpg" || $extension=="jpeg" )
				{
				$uploadedfile = $_FILES['file']['tmp_name'];
				$image = imagecreatefromjpeg($uploadedfile);
				}
				else if($extension=="png")
				{
				$uploadedfile = $_FILES['file']['tmp_name'];
				$image = imagecreatefrompng($uploadedfile);
				}
				else 
				{
				$image = imagecreatefromgif($uploadedfile);
				}

				// resample to desired width/height
		    	list($width,$height)=getimagesize($uploadedfile);
	    		$newwidth=400;
				$this->newheight=($height/$width)*$this->width;
				$this->imageOutput=imagecreatetruecolor($this->width,$this->newheight);
				imagecopyresampled($this->imageOutput,$image,0,0,0,0,$this->width,$this->newheight, $width,$height);

		    	$this->colorWhite = imagecolorallocate($this->imageOutput,255,255,255);
		    	$this->colorBlack = imagecolorallocate($this->imageOutput, 0, 0, 0);

		    	$this->defineFont();

				$this->addTopText();
				$this->addBottomText();

				$nameOut = date("U").".png";
				imagepng($this->imageOutput, "memes/" . $nameOut);
				echo "file created!";

				if(file_exists("memes/" . $nameOut)){
					echo "<hr>";
					echo "<img src='memes/" . $nameOut."'>";
					echo "<hr>";
				}

		    }
		  }
		} else {
		  echo "Invalid file";
		}
	}

}

?>