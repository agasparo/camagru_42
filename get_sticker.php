<header>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</header>
<?php
$dir = "sticker";
$i = 0;
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
    	if ($file[0] != '.') {
    		  ?>
          <img src="<?php echo $dir.'/'.$file; ?>" id="<?php echo $i; ?>" class="drag">
          </div> 
      		<?php
      		$i++;
    	}
    }
    closedir($dh);
  }
}
?>