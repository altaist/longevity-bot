<?php
//include_once $pathAppApiDir . 'apiapp.php';
//include_once $pathAppApiDir . 'apifunc.php';

MyLog::setSilent(true);
//PageData::set("ordersList", exp_order_load_admin([]));

PageData::set("title", "Заказы");
PageData::set("description", "Личный кабинет");

PageData::set("module", "orders");
?>

<?php
include $pathViewDir . 'inc/header/header.php';
?>


<div id="vueApp" v-cloak>
	<?php
	include $viewConfig->getPath("inc/menu/menu.php");
	?>

	<div class="container-flex my-5 mx-3">

		<?php //echo (count(PageData::get("ordersList")["orders"])) 
		?>
		<div v-if="isView('list', 'main', 'orders')">

			<div class="row">
				<div class="col-6 col-md-2">
					<h4>Заказы </h4>
				</div>
				<div class="col-md-8 d-none d-md-block">
					<!--div class="row p-1 ">
						<div class="col-12  p-1">
							<span class="title4">Заказов:</span><span class=" text-danger"> {{orderStatistic.count}}</span>&nbsp;<br class="d-md-none" />
							<span class="title4">Сумма:</span><span class=" text-danger"> ${{orderStatistic.sum}}</span>&nbsp;<br class="d-md-none" />
							<span class="title4">Комиссия:</span><span class=" text-danger"> ${{orderStatistic.comission}}</span>&nbsp;<br class="d-md-none" />
						</div>
					</div-->
    				<div id="orderStatistic" class="row px-0 my-2" v-show="filteredStat.count>0">
    					<div class="col-12 text-center">
    						<span >Найдено экскурсий: <span class=" text-danger"> {{filteredStat.count}}</span> / Сумма: <span class="text-danger"> ${{filteredStat.sum}} </span> / Комиссия: <span class=" text-danger">${{filteredStat.comission}}</span> / Предоплата агенту: <span class=" text-danger">${{filteredStat.prePaid}}</span> / Допоплата: <span class=" text-danger">${{filteredStat.extraPay}}</span> / Итого комиссия: <span class=" text-danger"> ${{filteredStat.commissionTotal}} </span></span>
    					</div>
    				</div>

				</div>
				<div class="col-6 col-md-2 text-right">
					<b-button title="Filter" v-b-toggle.filters variant="primary">
						<b-icon icon="filter" aria-hidden="true"></b-icon>
					</b-button>
					<b-button title="Reload" href="#" @click.prevent="loadOrders(true)" variant="danger" class="mr-auto">
						<b-icon icon="arrow-repeat" aria-hidden="true"></b-icon>
					</b-button>
				</div>
			</div>
			<hr>
			<b-collapse id="filters">

				<div class='row'>
					<!--div class='col-6 col-md-3 col-lg-3'>
					<b-form-datepicker id="dateFrom" size="sm" placeholder="Дата c" v-model="orderFilters.dateFrom" local="ru-Ru" :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" today-button reset-button class="mb-2"></b-form-datepicker>
				</div>
				<div class='col-6 col-md-3 col-lg-3'>
					<b-form-datepicker id="dateTo" size="sm" placeholder="Дата по" v-model="orderFilters.dateTo" local="ru-Ru"  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" today-button reset-button class="mb-2"></b-form-datepicker>
				</div-->
					<div class='col-6 col-md-3 col-lg-3  py-1'>
						<b-input-group class="mb-3">
							<b-form-input id="dateFrom" v-model="orderFilters.dateFrom" size="sm" type="text" placeholder="Дата c" autocomplete="off" locale="ru-RU" lang="ru" :date-format-options="{ day: 'numeric',  month: 'numeric', year: 'numeric'}"></b-form-input>
							<b-input-group-append>
								<b-form-datepicker v-model="orderFilters.dateFrom" size="sm" button-only right locale="ru-RU" aria-controls="dateFrom" lang="ru" :date-format-options="{ day: 'numeric',  month: 'numeric', year: 'numeric'}" today-button reset-button></b-form-datepicker>
							</b-input-group-append>
						</b-input-group>
					</div>
					<div class='col-6 col-md-3 col-lg-3  py-1'>
						<b-input-group class="mb-3">
							<b-form-input id="dateTo" v-model="orderFilters.dateTo" size="sm" type="text" placeholder="Дата по" autocomplete="off"></b-form-input>
							<b-input-group-append>
								<b-form-datepicker v-model="orderFilters.dateTo" size="sm" button-only right locale="ru-Ru" lang="ru" aria-controls="dateTo" :date-format-options="{ day: 'numeric',  month: 'numeric', year: 'numeric'}" today-button reset-button></b-form-datepicker>
							</b-input-group-append>
						</b-input-group>
					</div>
					<div class='col-6 col-md-3 col-lg-3  py-1'>
						<div>
							<b-form-select v-model="orderFilters.datePeriod.value" :options="orderFilters.datePeriod.options" size="sm" @change="updateDatesFromPeriod()"></b-form-select>
						</div>
					</div>
					<div class='col-6 col-md-3 col-lg-3 px-3  py-1'>
						<div>
							<b-form-select v-model="orderFilters.dateSearchType.value" :options="orderFilters.dateSearchType.options" size="sm"></b-form-select>
						</div>
					</div>


					<div class='col-6 col-md-4 col-lg-2 px-3  py-1'>
						<div>
							<b-form-select v-model="orderFilters.filterState.value" :options="orderFilters.filterState.options" size="sm"></b-form-select>

						</div>
					</div>

					<div class='col-6 col-md-4 col-lg-2 px-3 py-1'>
						<b-input v-model="orderFilters.key" placeholder="Номер" size="sm"></b-input>
					</div>
					<?php if (isAdmin()) { ?>
						<div class='col-6 col-md-4 col-lg-2 px-3 py-1'>
							<div>
								<!--b-input v-model="orderFilters.companyKey" placeholder="Агент" size="sm"></b-input-->
								<b-select v-model="orderFilters.companyKey" :options="agencies" text-field="name" value-field="key" size="sm"></b-select>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="row my-3">
					<div class="col-sm-6 col-md-8 col-lg-9"></div>
					<div class='col-sm-6 col-md-4 col-lg-3 text-right my-2'>
						<b-button title="Найти записи по фильтру" size="lg" @click="loadOrders(true, {}, '<?=isAdmin()?'_admin':'' ?>')" variant="primary" class="w-100">
							<b-icon icon="search" aria-hidden="true"></b-icon> Найти
						</b-button>
					</div>

				</div>


			</b-collapse>



			<div v-if="!filteredOrders || filteredOrders.length==0">
				<div>
					<h5 class="mt-3">Заказов по выбранным условиям не найдено</h5>
				</div>
			</div>
			<div else>
				<div id="orderStatistic" class="row px-0 my-2  d-block d-md-none" v-show="filteredStat.count>0">
					<div class="col-12 text-center">
						<span >Найдено экскурсий: <span class=" text-danger"> {{filteredStat.count}}</span> / Сумма: <span class="text-danger"> ${{filteredStat.sum}} </span> / Комиссия: <span class=" text-danger">${{filteredStat.comission}}</span> / Допоплата: <span class=" text-danger">${{filteredStat.extraPay}}</span> / Итого комиссия: <span class=" text-danger"> ${{filteredStat.commissionTotal}} </span></span>
					</div>
				</div>


				<div id="tableControls" class="px-0" v-if="filteredOrders.length>0">
					<div class="row">

						<b-col cols="12" md="4" class="my-1">
							<b-form-group class="mb-0">
								<b-input-group size="sm">
									<b-form-input id="filter-input" debounce="500" v-model="tables.filter" type="search" placeholder="Поиск в загруженных данных"></b-form-input>

									<b-input-group-append>
										<b-button class="px-3" :disabled="!tables.filter" @click="tables.filter = ''"> X </b-button>
									</b-input-group-append>
								</b-input-group>
							</b-form-group>

						</b-col>
						<b-col cols="4" md="2" class="my-1">
							<b-form-select v-model="tables.paging.perPage" id="perPageSelect" size="sm" :options="tables.pageOptions"></b-form-select>
						</b-col>

						<b-col cols="8" md="6" class="my-1">
							<b-pagination v-model="tables.paging.currentPage" :total-rows="filteredOrders.length" :per-page="tables.paging.perPage" align="fill" size="sm" class="my-0"></b-pagination>
						</b-col>
					</div>
				</div>


				<b-row>
					<!--b-col lg="6" class="my-1">
					<b-form-group label="Filter" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
						<b-input-group size="sm">
							<b-form-input v-model="tables.filter" type="search" id="filterInput" placeholder="Type to Search"></b-form-input>
							<b-input-group-append>
								<b-button :disabled="!tables.filter" @click="tables.filter = ''">Clear</b-button>
							</b-input-group-append>
						</b-input-group>
					</b-form-group>
				</b-col-->

				</b-row>
				<b-table ref="mainTable" class="my-5" striped selectable stacked="sm" hover :items="filteredOrders" :fields="<?= isAdmin()?'tables.orders.listAdmin.fields':'tables.orders.list.fields'?>" :current-page="tables.paging.currentPage" :per-page="tables.paging.perPage" :filter="tables.filter" @filtered="onFilteringCompleted" :sort-by.sync="tables.sortBy" :sort-desc.sync="tables.sortDesc" :tbody-transition-props="{name: 'flip-list'}" show-empty @row-selected="onTableSelected">
					<template #cell(title)="data"><a href="#" @click.prevent="orderToggleItem(data)" class="table-toggle">{{data.value}}</a></template>
					<template #head(selected)="data">
						<a href="#" @click.prevent="$refs.mainTable.isRowSelected(0)?$refs.mainTable.clearSelected():$refs.mainTable.selectAllRows()">&nbsp;</a>
					</template>
					<template #cell(selected)="{ rowSelected }">
						<template v-if="rowSelected">
							<span aria-hidden="true">&check;</span>
						</template>
						<template v-else>
							<span aria-hidden="true">&nbsp;</span>
						</template>
					</template>

					<template #cell(key)="data"><span class="my-3 p-1 px-2 rounded" :style="'color: white; background-color:' + getOrderStateOption(data.item).color">{{data.value}}</span></template>
					<template #cell(dateCreated)="data"><a href="#" @click.prevent="loadOrder(data.item.key)">{{data.value}}</a></template>
					<template #cell(state)="data"><span class="my-3 p-1 px-2 rounded" :style="'color: white; background-color:' + getOrderStateOption(data.item).color">{{getOrderStateOption(data.item).text.substring(0,4)}}</span></template>
					<template #cell(client)="data">{{formatClientName(data.value)}}<br>{{formatClientContacts(data.value)}}</template>
					<template #cell(products)="data"><span v-html="data.value"></span></template>
					<template #cell(sum)="data">{{data.value}}</template>
					<template #cell(comission)="data">{{data.value}}</template>

					<template #cell(controls)="data" class="text-right">
						<div class="text-right">
							<b-button @click.prevent="data.toggleDetails" class="btn-grey text-right">
								<b-icon icon="arrows-expand" aria-hidden="true"></b-icon>
							</b-button>
						</div>
					</template>
					<template #cell(bus)="row" class="text-right">
						<div class="text-right">
							<b-button @click.prevent="" class="btn-grey text-right"></b-button>
						</div>
					</template>

					<template #row-details="row">
						<b-card>
							<?php include $viewConfig->getPath("components/cart/form-cart-item2.php") ?>
							<b-row class="my-2">

								<b-col sm="12" md="3" class="my-2">
									<!--b-button :href="'order/'+row.item.key" class="btn-grey text-right">
										<b-icon icon="pencil" aria-hidden="true"></b-icon>
									</b-button-->
									<b-button @click.prevent="orderDeleteItem(row.item)" class="btn-grey text-right" variant="danger" v-if="row.item.state<2">
										<b-icon icon="trash" aria-hidden="true"></b-icon>
									</b-button>
								</b-col>
								<b-col sm="12" md="3">
									<div class="text-right" v-if="row.item.state>1">
										<b-button size="дп" @click="orderConfirmAgency(row.item)" variant="warning">{{row.item.state<3 ? 'Подтверждение агентом' :'Снять бронь'}}</b-button>
									</div>

								</b-col>
								<b-col sm="12" md="6" class="text-sm-right">
									<div class="text-right">
										<b-button size="lg" @click="orderChangeItem(row.item)" variant="success">Сохранить</b-button>

									</div>
								</b-col>
							</b-row>
							<?php if (isAdmin()) { ?>
								<h3 class="my-2">Администратор</h3>
								<b-row class="my-3">
									<b-col sm="12" md="3">
										<div>
											<b-button @click="switchOrderState(row.item, 1, 2)" variant="warning">{{row.item.state<2 ? 'Подтвердить бронь' :'Отменить бронь'}}</b-button>
										</div>
									</b-col>
									<b-col sm="6" md="3">
										<div>

											<b-form-select v-model="row.item.state" :options="orderFilters.filterState.options"></b-form-select>
											<!--b-input v-model="row.item.state" size="sm" change="recalculateOrderState(row.item)"></b-input-->

										</div>

									</b-col>
									<b-col sm="6" md="3">
										<b-button @click="updateOrderItemState(row.item, row.item.state)">Изменить статус</b-button>
									</b-col>
									<b-col sm="12" md="12" class="text-sm-right">
										<div class="text-right">
										</div>
									</b-col>

								</b-row>
							<?php }	?>


						</b-card>
					</template>

				</b-table>
				<div v-if="orders">
					<h4 class="my-2">Групповые операции</h4>
					<b-tabs>
						<b-tab title="Выгрузка">
							<div class="my-3 p-2">
								<b-row>
									<b-col sm="6" md="3">
										<b-form-select v-model="tables.orders.exportTo.fieldsGroupIndex" :options="{default:'Стандартный', finance:'Сверка', manual:'Произвольный'}"></b-form-select>
									</b-col>
									<b-col sm="6" md="3">
										<b-button @click="onBtnExportOrdersToExcel">Выгрузить</b-button>
									</b-col>
									<b-col sm="12" md="12" v-if="tables.orders.exportTo.fieldsGroupIndex == 'manual'">
										<b-form-input v-model="tables.orders.exportTo.exportFreeFieldsList" class="my-3"></b-form-input>
									</b-col>
								</b-row>
							</div>
						</b-tab>
						<!--b-tab title="Удаление(пример)">
							<div class="my-3 p-2">
								<div v-if="tables.selectedItems.length>0">
									<b-row>
										<b-col sm="6" md="3">
											<b-button @click="onBtnDeleteSelectedOrders">Удалить</b-button>
										</b-col>
									</b-row>
								</div>
								<div v-else>
									<div>Выделите записи, которые хотите удалить</div>
								</div>
							</div>
						</b-tab>
						<b-tab title="Изменение (пример)">
							<div class="my-3 p-2">
								<div v-if="tables.selectedItems.length>0">
									<b-row>
										<b-col sm="6" md="3">
											<b-form-select v-model="tables.orders.selectedUpdateField" :options="{0:'Поля', state:'state', date:'date', guide:'guide'}"></b-form-select>
										</b-col>
										<b-col sm="6" md="3">
											<b-form-input placeholder="Значение"></b-form-input>
										</b-col>
										<b-col sm="6" md="3">
											<b-button @click="onBtnUpdateSelectedOrders">Обновить</b-button>
										</b-col>
									</b-row>
								</div>

								<div v-else>
									<div>Выделите записи, которые хотите изменить</div>
								</div>

							</div>
						</b-tab-->
					</b-tabs>

				</div>
				<!--{{mapArray(orders, "companyKey")}} -->

				<!---b-table striped hover :fields="['id', 'created', 'clientContent', 'content']" :items="orders"></b-table-->
				<!--div class="row" v-for="order in filteredOrders">
				<div class="col-12 col-md-10 col-lg-10 p-3">
					<h5><a href="#" @click.prevent="loadOrder(order.key)" :style="'color:' + getOrderStateOption(order).color"><span class="title3">Заказ {{order.key}} от {{order.created}} </span></a></h5><span class="my-3 p-1 px-2 rounded" :style="'color: white; background-color:' + getOrderStateOption(order).color">{{getOrderStateOption(order).text}}</span><br>
					<div class="mt-2">{{order.content}}</div>
				</div>

				<div class="col-12 col-md-12 col-lg-2 py-3 ">
					<div class="row">
						<div class="col-6">
							<div v-if="order.state<2">
								<b-button @click.prevent="orderSetState(order, 2)" variant="success">
									<b-icon icon="check2" aria-hidden="true"></b-icon>
								</b-button>
							</div>

						</div>
						<div class="col-6 text-right">
							<b-button @click.prevent="orderDelete(order)" class="btn-grey">
								<b-icon icon="trash-fill" aria-hidden="true"></b-icon>
							</b-button>
						</div>
					</div>
				</div>
				<div class="col-12">
					<hr>
				</div>

			</div-->
			</div>
		</div>
		<div v-if="isView('loading')" class="container my-5">
			<b-spinner variant="primary" label="Loading"></b-spinner>
		</div>

		<div v-if="isView('form', 'order') && order">
			<!--div class="mb-5"><a href="#" @click.prevent="nav('list')">К списку заказов</a></div-->
			<h4 class="my-3 font-weight-light text-danger">

				<h4 class="my-3 font-weight-light text-danger"><a href="#" @click.prevent="nav('orders')"><u class="my-3 font-weight-light text-danger">Заказы</u></a> / Заказ {{order.key}}</h4>
				<hr />
				<b-tabs v-model="tabIndex" content-class="mt-4" class="mt-3">

					<b-tab title="Заказ">
						<b-alert :show="needHelp" dismissible fade>
							<p>Вы можете выбрать нужные позиции в каталоге (список внизу) и отредактировать их в корзине. После этого можно оформить заказ, отправив его на согласование оператору. А можно просто сохранить заказ и отправить клиенту ссылку на личный кабинет - клиент закончит оформление заказа самостоятельно!</p>
						</b-alert>
						<b-row v-if="isCartEmpty()">
							<b-col class="mt-2">Заказ пуст</b-col>
						</b-row>

						<?php
						// Корзина
						include $pathViewDir . "inc/form-cart-admin.php";
						?>




						<!--catalog :items="sortItems(getFilteredItems('', 0), 'pos')" :cart="cart" :view="noImage" @cart-item-toggle='onBtnCartToggle'>
		</catalog-->
						<div class="col-12 mt-3">
							<!--a v-b-toggle href="#catalog-toggle" @click.prevent-->
							<h4 class="font-weight-light text-danger">Каталог</h4>
							<hr>

						</div>
						<?php
						include $pathViewDir . "inc/list-catalog.php";
						?>
					</b-tab>
					<b-tab title="Клиент">
						<b-alert :show="needHelp" dismissible fade>
							<p>Для изменений данных о клиенте просто введите информацию и нажмите на кнопку "Сохранить клиента". Ссылка на личный кабинет пользователя расположена в верхней части формы</p>
						</b-alert>
						<div class=" row mt-3" id="client">
							<div class="col-6 col-md-6">
								<h4 class="my-3 font-weight-light text-danger">Клиент</h4>
							</div>
							<div class="col-6 col-md-6 text-right">
								<!--b-button title="Поиск" href="#" @click.prevent="checkUser" variant="primary" class="mr-auto" v-b-popover.hover.top="'Для поиска клиента введите параметры в форму ниже и нажмите кнопку Поиск'">
							<b-icon icon="search" aria-hidden="true"></b-icon>
						</b-button-->

								<b-button title="Ссылка на личный кабинет" href="#" @click.prevent="showAuthLinkDialog" v-b-tooltip.hover variant="success" class="mr-auto">
									<b-icon icon="share-fill" aria-hidden="true"></b-icon>
								</b-button>
							</div>
						</div>
						<hr />
						<?php
						include $pathViewDir . "inc/form-client-admin.php";
						?>
						<div class="py-5" v-show="clientOrders && clientOrders.length>0">
							<h5>Список заказов клиента</h5>
							<?php
							include $pathViewDir . "inc/list-client-orders.php";
							?>
						</div>
					</b-tab>
				</b-tabs>

		</div>
		<datalist id="hotels">
			<option v-for="(hotel, index) in hotels">{{ hotel.text}}</option>
		</datalist>
	</div>
	<?php
	include_once $pathViewDir . "inc/modals/modals_base.php";
	include_once $pathViewDir . "inc/modals/modals_catalog.php";
	?>

</div><!-- Vue -->


<?php
include $pathViewDir . 'inc/footer/footer.php'
?>