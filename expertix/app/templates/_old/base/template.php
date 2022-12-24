<?php
require __DIR__ . "/inc/header/header.php";
?>

<body>
<div id="jsApp"  class="invisible">

<?php
	require __DIR__ . "/inc/page-layout/" .$viewConfig->getParam("view_page_layout", "page_layout_default") . ".php";
?>

</div><!-- /jsApp-->


<?php
require __DIR__ . "/inc/footer/footer.php";
?>

</body>
</html>