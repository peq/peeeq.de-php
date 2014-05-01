<?
//create thumbnails
function createthumb($name,$filename,$new_w,$new_h)
{
	$system=explode('.',$name);

	$src_img = 0;

	//echo sizeof($system)."<br />";
	//echo "$name<br />";
	//echo "size: ".filesize($name)."<br />";
	$imagesize = GetImageSize($name);
	$realsize = $imagesize[0]*$imagesize[1]*3;

	//echo "realsize= $realsize<br />"; 
 


	if ($realsize < (33554432 / 8))
	//if (false)
	{
		if (preg_match('/jpg|jpeg|JPG/',$system[sizeof($system)-1]))
		{
			$src_img=@imagecreatefromjpeg($name);
		}

		
		if (preg_match('/bmp|BMP/',$system[sizeof($system)-1]))
		{
			$src_img=@imagecreatefromwbmp($name);
		}
		

		if (preg_match('/png|PNG/',$system[sizeof($system)-1]))
		{
			$src_img=@imagecreatefrompng($name);
		}

		if (preg_match('/gif|GIF/',$system[sizeof($system)-1]))
		{
			$src_img=@imagecreatefromgif($name);
		}

		if ($src_img)
		{
			$old_x=imageSX($src_img);
			$old_y=imageSY($src_img);

			if ($old_x > $old_y) 
			{
				$thumb_w=$new_w;
				$thumb_h=$old_y*($new_h/$old_x);
			}

			if ($old_x < $old_y) 
			{
				$thumb_w=$old_x*($new_w/$old_y);
				$thumb_h=$new_h;
			}

			if ($old_x == $old_y) 
			{
				$thumb_w=$new_w;
				$thumb_h=$new_h;
			}

			$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
			imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

			if (preg_match("/png/",$system[1]))
			{
				imagepng($dst_img,$filename); 
			} 
			if (preg_match("/gif/",$system[1]))
			{
				imagegif($dst_img,$filename);
			}

			else 
			{
				imagejpeg($dst_img,$filename); 
			}

			imagedestroy($dst_img); 
			imagedestroy($src_img); 
			return true;
		}
		else {
			//echo "could not create image<br />";
		}
	}
	else {
		if ($realsize < 5000*5000) {
			//echo "image to big ($realsize)<br />";
			//echo "./exec/convert -thumbnail ".escapeshellcmd($new_w)." ".escapeshellcmd($name)." ".escapeshellcmd($filename)."<br>";
			exec("./exec/convert -thumbnail ".escapeshellcmd($new_w)."x".escapeshellcmd($new_h)." ".escapeshellcmd($name)." ".escapeshellcmd($filename)."");
			return true;
		}
	}
	return false;
}
?>
