<div class="my-3 my-md-0">
	<div class="mb-3 title2">Миссии</div>
	<hr>
</div>
<div>
	<q-list bordered separator>
		<template v-for="item, index in missions">
			<q-item clickable @click="showMissionActivity(item)">
				<q-item-section top avatar>
					<q-avatar :color="item.color || 'deep-orange'" text-color="white" :icon="item.icon || 'person'" />
				</q-item-section>

				<q-item-section>
					<q-item-label>{{item.title}}</q-item-label>
					<q-item-label caption lines="2">{{item.subTitle}}</q-item-label>
					<q-item-label caption lines="2">Баллы: {{item.rating}} / Энергия: -{{item.energy}}</q-item-label>
				</q-item-section>

				<q-item-section side top>
					<q-item-label caption>
						<q-avatar color="red" size="sm" square text-color="white">+{{item.rating}}</q-avatar>
						<!--q-chip>
							-{{item.energy}}
						</q-chip-->
					</q-item-label>
				</q-item-section>
				<!--q-item-section side top>
					<q-item-label caption>Баллы: {{item.rating}}</q-item-label>
					<q-icon name="emoji_events" color12="item.color || 'orange'"></q-icon>
					<q-chip>
						<q-avatar color="red" text-color="white">{{user.rating1}}</q-avatar>
						Баллов
					</q-chip>
				</q-item-section-->
			</q-item>

		</template>

	</q-list>
</div>