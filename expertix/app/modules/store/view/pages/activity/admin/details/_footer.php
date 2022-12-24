  <b-modal :id="gui.modals.modalNewItem.id" ref="modalNewItem" title="Добавить новый элемент" @hidden="onNewItemModalCancel" @ok="onNewItemModalOk">
  	<form ref="formNewItem" @submit.stop.prevent="handleModalSubmit">
  		<b-form-group label="Название" label-for="newTitle" invalid-feedback="Необходимо ввести название" :state="storage.newItem.state">
  			<b-form-input id="newTitle" v-model="storage.newItem.title" :state="storage.newItem.state" required></b-form-input>
  		</b-form-group>
  	</form>
  </b-modal>