<?php
$theme = $params[0];
//$theme->moduleComponent("store", "product/form-product-edit", $data);

$theme->setAutoPrint(true);
$theme->startGrid("col-12 col-md-6");
$theme->textarea("storage.item.title", "Название", "size='lg' @input='onTitleChanged(storage.item)'")->textarea("storage.item.subTitle", "Краткое описание");
$theme->endGrid();
$theme->startRow();
$theme->startCol("col-12 col-md-12")->textarea("storage.item.description", "Описание")->endCol();
$theme->startCol("col-12 col-md-6")->input("storage.item.img", "Изображение")->endCol();
$theme->startCol("col-12 col-md-6")->input("storage.item.video", "Видео")->endCol();
$theme->startCol("col-12 col-md-6")->input("storage.item.slug", "Url", "size='lg' @input='onSlugChanged(storage.item)'")->endCol();
$theme->startCol("col-12 col-md-4")->checkbox('storage.item.state', "Опубликовать", "Видимость")->endCol();
$theme->endRow();