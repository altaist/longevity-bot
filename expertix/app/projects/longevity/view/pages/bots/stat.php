<?php
use Expertix\Bot\ChatInstance;
use Expertix\Core\Util\ArrayWrapper;
use Project\Bot\BotLongevityBase;
use Project\Bot\BotLongevityChild;
use Project\Bot\Model\ChatModel;

function showStat()
{
	$request = new ArrayWrapper($_GET);
	$userId = $request->get("user");

	if (!$userId) {
		echo ("<p>Неверный URL запроса</p>");
		return;
	}
	$model = new ChatModel();
	$userArr = $model->getChatByAffKey($userId);

	if (!$userArr) {
		echo ("<p>Пользователь не найден</p>");
		return;
	}
	$chatInstance = new ChatInstance($userArr);
	$userName = $chatInstance->get('userName');
	$statResult = $model->getStatForChat($chatInstance->getChatId());

	if (!$statResult) {
		echo ("<p>У пользователя $userName нет статистики</p>");
		return;
	}

	echo ("<h4>Статистика для пользователя {$userName}</h4>");

echo <<<EOT
	<q-tabs
        v-model="tab"
        class="text-orange my-3 text-h6"
		align="left" 
	>
        <q-tab name="common"  label="Общая статистика" ></q-tab>
        <q-tab name="detailed"  label="Детальная по дням" ></q-tab>
    </q-tabs>
EOT;

	// Common
	echo <<<EOT
	<q-tab-panels v-model="tab" animated >
          <q-tab-panel name="common">
EOT;
	print_r(BotLongevityBase::formatStatistic($statResult, "<br>"));
	echo <<<EOT
		</q-tab-panel>
EOT;


	// Detailed
	echo <<<EOT
          <q-tab-panel name="detailed" >
EOT;
	//echo ("<h5>Детальная статистика</h5>");
	$statDetailsResult = $model->getDetailedStatForChat($chatInstance->getChatId());
	?>
	<div class="q-pa-md">
		<q-table title="" :rows='<?= json_encode($statDetailsResult) ?>' :columns="columns" :pagination="initialPagination">
		<template v-slot:body-cell-content="props">
			<q-td :props="props">
				<div v-if="props.row.messageImg">
					<a :href="props.row.messageImg" target="top" >{{ props.value }}</a>
				</div>
				<div v-else>{{props.value}}</div>
			</q-td>
		</template>
		</q-table>
</div>
		
		</q-tab-panel>
	</q-tab-panels>

	<?php

	//	echo ("<h5>Статистика за период</h5>");
	//print_r(BotLongevityBase::formatStatistic($statResult));
	//print_r($statDetailsResult);

?>
<div>


</div>
<?php


}

showStat();