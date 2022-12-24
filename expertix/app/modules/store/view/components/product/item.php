<?php

//$theme->cardImg($product["title"], $product["subTitle"], "img/intellect/nauka1.jpg", "product/".$product["slug"], "bg-danger text-white", "Перейти");

$title = $params[0];
$subTitle = $params[1];
$img = $params[2];
$link = $params[3];

$link_html = $link ? "<a href='$link' class='card-link stretched-link'>Перейти</a>" : "";
$text_html = $subTitle;// . ($link ? "<br>" . $link_html : "");

$this->process(<<<EOT
<div class="card">
	<img class="card-img-top" src="$img">
	<div class="card-body">
		<h5 class="card-title">$title</h5>
		<p class="card-text">$text_html</p>
		$link_html
	</div>
</div><!-- //card-->
EOT);