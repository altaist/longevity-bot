<?php
$theme->setAutoPrint(true);

$theme->sectionTitle("Карточка товара1");
$theme->startGrid("col-12 col-md-6");
$theme->input("title", "Название")->input("subTitle", "Краткое описание")->textarea("description", "Описание");
$theme->endGrid();
$theme->startRow()->startCol("col-12 col-md-6");
$theme->button("onCancel", "Отмена")->endCol()->startCol("col-12 col-md-6 text-right");
$theme->button("onSave","Отправить");
$theme->endRow();

?>