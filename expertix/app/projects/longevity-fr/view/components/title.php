<?php
$h = $params->get("h", 2);
$title = $params->get("title");


if($h==2){
	echo "<div class=\"my-3\"><div class=\"title2 color1 my-1\">$title</div><hr></div>";
}elseif($h == 1){
	echo "<div class=\"my-3\"><div class=\"title1 color1 my-1\">$title</div><hr></div>";
}elseif($h == 3){
	echo "<div class=\"my-3\"><div class=\"title2 color1 my-1\">$title</div><hr></div>";
}
?>
