<?php
include __DIR__ . "/_jsmixins.php";
?>
<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, crudMixin, moduleMixin],
		data: () => {
			return {



			}
		},
		computed: {

		},
		methods: {




		},
		created() {
			this.setupProject();
			this.setupProfile();
			if (!this.profile.data.projects) {
				this.profile.data.projects = {};
			}

			this.storage.list2 = [
				
				{
					"title": "Фонд содействия развитию малых форм предприятий в научно-технической сфере",
					"siteUrl": "https: //fasie.ru"
				},
				{
					"title": "Фонд президентских грантов",
					"siteUrl": "https://xn--80afcdbalict6afooklqi5o.xn--p1ai/"
				},{
					title: "Центр развития туризма и предпринимательства РА",
					subTitle: "Оказывает всесторонню помощь в поддержке и развитии малого и среднего бизнеса РА",
					siteUrl: "https://мойбизнес04.рф"
				},
				{
					title: "Горно-Алтайский государственный университет",
					subTitle: "",
					siteUrl: "https://мойбизнес04.рф"
				},
				{
					"title": "Горно-Алтайский государственный политехнический колледж им. М.З Гнездилова",
					"siteUrl": "https://gagpk.online/"
				},
				{
					"title": "",
					"siteUrl": ""
				}, {
					"title": "Республиканский центр дополнительного образования",
					"siteUrl": "http://www.dopcenter-altai.ru/"
				},
				{
					"title": "Министерство экономического развития Республики Алтай",
					"siteUrl": "https://xn--04-vlciihi2j.xn--p1ai/"
				}
			];

			this.setupCrud("project", {
				api: "project",
				keyField: "projectKey",
				detailsLink: "projects/#KEY",
				childDetailsLink: "projects/#KEY",
				autoLoad: true,
				autoLoadAsync: true,

				autoLoadChilds: true,
				childType: "project_item",

				tableConfig: this.table
			});

			this.requestApi("project", "project_get_list", {
				type: 0
			}, (result) => {
				console.log("Product api controller result: ", result);
				this.storage.list = result.map((item) => {
					item.canHelp = false;
					item.helpTypes = this.convertHelpValuesToArr(item);
					return item;
				});
			}, (error) => {
				console.log("Произошла ошибка ", error);
			});
		}
	}

	PageController.setVueConfig(vueAppConfig);
</script>