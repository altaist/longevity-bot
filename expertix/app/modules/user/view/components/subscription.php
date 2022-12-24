<div class="p-2 py-3 border rounded title4">
	<div class="" v-if="product.subscription">Вы подписаны на этот курс<br>Перейдите в <a href="lk/" class="title4">личный кабинет</a>, чтобы управлять подпиской.</div>
	<div v-else>
		<div class="my-3">Вы можете записаться на этот курс</div>
		<div>
			<q-btn label="Записаться" @click="subscribe" icon="add"></q-btn>
		</div>
	</div>

</div>