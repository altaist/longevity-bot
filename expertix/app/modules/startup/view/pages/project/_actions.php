						<div class="item-actions border rounded p-2 py-2" style="background-color: #eeeeff">
							<div v-if="canHelp(item)">
								<div class="row">
									<div class="col-12 col-md-12">
										<div class="card my-2">
											<div class="card-body">
												<div class="row">
													<div class="col-12 col-md-12 my-1">
														<b-form-group label="Какую помощь могу оказать:">
															<b-form-checkbox-group id="item-project-types" v-model="item.helpTypes" :options="supportTypes" button-variant="outline-primary" size="sm" name="helpTypes" buttons></b-form-checkbox-group>
														</b-form-group>
													</div>
													<div class="col-12 col-md-12">
														<b-form-group label="Комментарии:" label-for="element_item.actionComments" invalid-feedback="">
															<b-textarea id="element_form.item.actionComments" v-model="item.actionComments" size="lg" rows="2"></b-textarea>
														</b-form-group>
													</div>
													<div class="col-12 col-md-12 my-1">
														<b-button size="md" @click="onActionClick(item, 'canhelp', {'types': item.helpTypes, 'comments':item.actionComments}, [], false)" variant="success">Готов помочь
														</b-button>
													</div>
												</div>

											</div>

										</div>
									</div>

								</div>



							</div>
							<div>
								<div class="row m-0">
									<div class="col-2 col-md-2 text-left">
										<b-button size="sm" :variant="((checkDid(item, 'fav'))?'':'outline-')+'primary'" class="m-0" @click="onActionClick(item, 'fav', 1)" v-b-tooltip.hover title="В избранное">
											<b-icon icon="star" aria-label="Favorites"></b-icon>
										</b-button>
									</div>
									<div class="col-4 col-md-4 text-right">
										<b-button size="sm" :variant="((checkDid(item, 'dislikes'))?'':'outline-')+'danger'" class="m-0" @click="onActionClick(item, 'dislikes', 1)">
											<b-icon icon="hand-thumbs-down" aria-label="Dislike"></b-icon>
											<b-badge variant="light" v-if="item.dislikes>0">{{item.dislikes}}<span class="sr-only">disliked</span></b-badge>

										</b-button>

									</div>
									<div class="col-4 col-md-4">
										<b-button size="sm" :variant="((checkDid(item, 'likes'))?'':'outline-')+'success'" class="m-0" @click="onActionClick(item, 'likes', 1)">
											<b-icon icon="hand-thumbs-up" aria-label="Like"></b-icon>
											<b-badge variant="light" v-if="item.likes>0">{{item.likes}}<span class="sr-only">liked</span></b-badge>
										</b-button>

									</div>
									<div class="col-2 col-md-2 text-right">
										<b-button size="sm" :variant="((item.canHelp)?'':'outline-')+'primary'" class="m-0" @click="onCanHelpClick(item)" v-b-tooltip.hover title="Готов помочь">
											<b-icon icon="trophy" aria-label="Готов помочь"></b-icon>
										</b-button>
									</div>
								</div>
							</div>


						</div>