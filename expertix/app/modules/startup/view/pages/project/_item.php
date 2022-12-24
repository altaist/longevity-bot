<div class="card">
	<div class="card-body">
		<h5 class="card-title">{{item.title}}</h5>
		<p>
			<b-badge variant="primary" v-if="item.type">{{(projectTypes[(+item.type -1) || 0] || {}).text}}</b-badge>
		</p>
		<p class="card-text">{{item.subTitle}}</p>
		<div><a :href="getItemDetailsLink(item.key)">Подробнее</a></div>
	</div>
	<div class="card-body">
		<div>
			<?php include __DIR__ . "/_actions.php" ?>
		</div>
	</div>
</div><!-- //card-->