<?php

namespace Expertix\Core\View\Theme;

class ThemeQuasar extends ThemeHtml
{

	function createLinkHtml($link, $linkText)
	{
		$link_html = $link ? "<a href='$link' class='card-link'>$linkText</a>" : "";
		return $link_html;
	}

	function sectionTitle($title, $subTitle = null, $delimeterClass = "divider")
	{
		$title = "<h2 class='title2 block-title mt-3'>$title</h2>";
		$subTitleHtml = $subTitle ? "<div class='subTitle my-1'>$subTitle</div>" : "";
		$delimeter = $delimeterClass ? "<hr class='divider my-1'/>" : "";

		return $this->process(<<<EOT
$title
$delimeter
$subTitleHtml
EOT);
	}
	function showCard($title, $text, $body_class = "", $link = null, $link_text = "", $footer = null)
	{
		return $this->card($title, $text, $body_class, $link, $link_text, $footer);
	}

	function card($title, $text = "", $body_class = "", $link = null, $link_text = "", $footer = null)
	{
		$link_html = $link ? "<a href='$link' class='card-link'>$link_text</a>" : "";
		$footer_html = 	($footer || $link_text) ? "<div class='card-footer'>
			" . ($footer ? $footer : $link_html) . "
		</div>" : "";
		$text_html = $text . ($link ? "<br>" . $link_html : "");

		return $this->process(<<<EOT
<q-card bordered dark class="$body_class ">
	<q-card-section>
		<div class="text-h6">$title</div>
		
	</q-card-section>

	<q-separator dark inset ></q-separator dark inset >


	<q-card-section>
		$text_html
	</q-card-section>
</q-card>

EOT);
	}
	function cardImg($title, $description, $img, $link)
	{
		return $this->process(<<<EOT
				<div class="card bg-dark text-white my-3">
					<img src="$img" class="card-img cover" height="200" alt="$title">
					<div class="overlay"></div>
					<div class="card-img-overlay ">
						<h4 class="card-title">$title</h4>
						<p class="card-text">$description</p>
						<a class="stretched-link" href="$link"></a>
					</div>
				</div>
EOT);
	}
	function blockFeature($title, $text, $img, $imgFirst = true, $body_class = "",  $link = null, $link_text = "", $footer = null)
	{
		$link_html = $this->createLinkHtml($link, $link_text);
		$text_html = $text . ($link ? "<br>" . $link_html : "");
		$orderLeft = $imgFirst ? 1 : 2;
		$orderRight = $imgFirst ? 2 : 1;

		return $this->process(<<<EOT
			<div class="row feature-block my-5">
				<div class="col-md-5 order-md-$orderLeft">
					<img src="$img" height="250" class="cover rounded">
				</div>
				<div class="col-md-7 order-md-$orderRight">
					<h2 class="title2"><span class="text-muted">$title</span>
					</h2>
					<p class="lead mt-3">$text_html</p>
				</div>
			</div>
EOT);
	}

	function formInput($id, $label, $value = "", $cls = "", $options = "")
	{
		return $this->process(<<<EOT
<label for="$id">$label</label>
<input id="$id" type="text" class="form-control form-control-lg $cls" size="sm" value="$value" $options/>

EOT);
	}

	function formSelect($id, $label, $options_arr, $value = "", $cls = "", $tag_options = "")
	{
		$options_str = "";
		$options = null;
		if (is_array($options_arr)) {
			$options = $options_arr;
			for ($i = 0; $i < count($options); $i++) {
				$option = $options[$i];
				if (is_object($option) && isset($option->val) && isset($option->val)) {
					$val = $option->val;
					$text = $option->text;
				} else if (is_array($option) && count($option) > 1) {
					$val = $option[0];
					$text = $option[1];
				} else {
					$val = $option;
					$text = $option;
				}
				$options_str .= "<option val='$val'>$text</option>";
			}
		}
		$label_str = empty($label) ? "" : "<label for='$id'>$label</label>";
		$result = $this->process(<<<EOT
$label_str
<select id="$id" type="select" class="form-control form-control-lg $cls"  $tag_options>
$options_str
</select>
EOT);
		return $result;
	}

	function showRowList($str)
	{
		$arr = explode(";", $str);
		$result1 = "";
		$result2 = "";
		foreach ($arr as $item) {
			$result1 .= <<<EOT
<div class="col-6 col-md-3">$item</div>
EOT;
			$result2 .= <<<EOT
$item&nbsp;
EOT;
		}
		return $result1;
	}

	function priceList($dataArray)
	{
		$resultHtml = "";
		foreach ($dataArray as $key => $item) {
			$title = $this->getArrValue($item, "title");
			$subTitle = $this->getArrValue($item, "subTitle");
			$img = $this->getArrValue($item, "img");
			$price = $this->getArrValue($item, "price", "По запросу");
			$resultHtml .= $this->createPriceItem($title, $subTitle, $img, $price);
		}
		return $this->process($resultHtml);
	}
	function createPriceItem($title, $subTitle, $img = null, $price = null)
	{
		$result = <<<EOT
<div class="row my-3">
	<div class="col-8 col-md-8">
		<div class="priceTitle">$title</div><div class="subTitle">$subTitle</div>
	</div>
	<div class="col-4 col-md-4 text-right my-3"><span class="p-2 bg-secondary rounded text-white">$price</span></div>
</div>
<hr>
EOT;

		return $result;
	}
}
