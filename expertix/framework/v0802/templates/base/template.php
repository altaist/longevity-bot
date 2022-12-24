<?php
require __DIR__ . "/header/header.php";
?>

<body>
<div id="jsApp" class="invisible">

<?php
	require $viewConfig->getTemplatePageLayoutPath("view_page_layout", "default");

// Framework's inner jsApp components and tags
require $viewConfig->getTemplateFrameworkPath("view_framework", "none", "inner");

?>

</div><!-- /jsApp-->


<?php
require __DIR__ . "/footer/footer.php";
?>

</body>
</html>