<?php

//$theme->cardImg($product["title"], $product["subTitle"], "img/intellect/nauka1.jpg", "product/".$product["slug"], "bg-danger text-white", "Перейти");

$product = $params[0];
$link1 = $params[1];
$link2 = $params[2];


$title = $product->get("title");
$subTitle = $product->get("subTitle");
$img = $product->get("img", "img/intellect/nauka1.jpg");

$link1_html = $link1 ? "<a href='$link1' class='card-link '>Перейти</a>" : "";
$link2_html = $link2 ? "<a href=\"#\" @click.prevent=\"onDeleteCrud('$link2')\">Удалить</a>" : "";
$text_html = $subTitle;// . ($link ? "<br>" . $link_html : "");

$this->process(<<<EOT
<div class="card">
	<img class="card-img-top" src="$img">
	<div class="card-body">
		<h5 class="card-title">$title</h5>
		<p class="card-text">$text_html</p>
		$link1_html
		<div class="my-3">$link2_html</div>
	</div>
</div><!-- //card-->
EOT);