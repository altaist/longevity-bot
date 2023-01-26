<div class="my-3 my-md-0">
	<div class="mb-3 title2">Missions</div>
	<hr>
</div>

<div>
	<q-list bordered separator>
		<template v-for="item, index in missionsEng">
			<q-item clickable @click="changeEnergy(item.energy)">
				<q-item-section top avatar>
					<q-avatar :color="item.color || 'deep-orange'" text-color="white" :icon="item.icon || 'person'" />
				</q-item-section>

				<q-item-section>
					<q-item-label>{{item.title}}</q-item-label>
					<q-item-label caption lines="2">{{item.subTitle}}</q-item-label>
				</q-item-section>

				<q-item-section side top>
					<q-item-label caption>{{item.time}} min left</q-item-label>
					<q-icon name="alarm" color12="item.color || 'orange'"></q-icon>
				</q-item-section>
			</q-item>

		</template>

	</q-list>
</div>