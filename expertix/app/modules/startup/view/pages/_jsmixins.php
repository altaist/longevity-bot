<script>
	var moduleMixin = {
		data: () => {
			return {
				screen: 2,

				projectId: "",
				serviceId: "",

				table: {
					fields: [{
						key: "title",
						label: "Название"
					}, {
						key: "subTitle",
						label: "Описание"
					}, {
						key: "slug",
						label: "Ссылка"
					}, {
						key: "created",
						label: "Дата"
					}],
					filter: {
						projectType: 0,
						filterProjectTypes: [{
								text: 'Все',
								value: 0
							}, {
								text: 'Идея',
								value: 1
							},
							{
								text: 'Проект',
								value: 2
							},
							{
								text: 'Бизнес',
								value: 3
							}
						],

					}
				},

				projectTypes: [{
						text: 'Идея',
						value: 1
					},
					{
						text: 'Проект',
						value: 2
					},
					{
						text: 'Бизнес',
						value: 3
					}
				],

				supportTypes: [{
						text: 'Деньги',
						value: 1
					},
					{
						text: 'Контакты',
						value: 2
					}, {
						text: 'Знания',
						value: 3
					},
				]
			}
		},
		computed: {
			//
			filteredList() {
				let list = this.storage.list;
				const type = this.table.filter.projectType;
				if (type <= 0) return list;
				//return list;
				console.log("filteredList for " + type);
				return list.filter(item => item.type == (+type));
			},
			filteredListTop10() {
				return this.storage.list.slice(0,10);
			},

		},

		methods: {
			getLocalProfileForProject(item) {
				return this.profile.data.projects[item.key];
			},
			checkDid(item, action) {
				const didField = "did_" + action;
				let result = item[didField] || (this.getLocalProfileForProject(item) || {})[didField] || 0;
				item[didField] = result;
				return item[didField];
			},
			onActionClick(item, action, _val, uncheckedVal = -1, checkLimits = true) {
				if (!item.key) {
					console.log("Empty item for like");
					return;
				}

				let value = _val;
				const didField = "did_" + action;
				if (item[didField] == undefined) {
					const localInfo = this.getLocalProfileForProject(item) || {};
					item[didField] = localInfo[didField];
				}

				if (checkLimits) {
					value = item[didField] ? uncheckedVal : _val;
				}

				let data = {
					key: item.key,
					action,
					value
				};
				this.requestApi("project", "project_update_" + action, data, (result) => {
					this.alert("Данные обновлены");
					this.debug(result);
					item[action] = result;
					item[didField] = item[didField] ? 0 : 1;

					// Save local history

					const project = this.profile.data.projects[item.key];
					if (!project) {
						this.profile.data.projects[item.key] = {};
					}
					this.profile.data.projects[item.key][didField] = item[didField];
					this.saveLocalProfile();

				});
			},
			convertHelpValuesToArr(item) {
				let arr = [];
				if (+item.helpMoney) arr.push(1);
				if (+item.helpInfo) arr.push(2);
				if (+item.helpEdu) arr.push(3);
				//this.debug("Prepared help types arr for item:");
				//this.debug(item);
				//this.debug(arr);
				return arr;
			},
			canHelp(item) {
				return item.canHelp;
			},
			onCanHelpClick(item) {
				item.canHelp = item.canHelp ? false : true;
				console.log(item);
			},

			canEdit(item) {
				if (this.profile.user.userId == item.authorId) {
					return true;
				}
				return false;
			},


		}
	}
</script>