<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, authMixin],
		data: () => {
			return {
				hubMenuEng: [],
				eventsEng: [],
				hubSections: [],
				profileForm: [{
						"title": "Contacts",
						"cssClass": "text-deep-orange",
						"color": "deep-orange",

						"fields": [{
								"label": "Your name",
								"value": ""
							},
							{
								"label": "Age",
								"value": 0
							},
							{
								"label": "Country",
								"value": ""
							}
						]
					},
					{
						"title": "Health",
						"cssClass": "text-accent",
						"color": "accent",

						"fields": [{
								"label": "My weight",
								"value": ""
							},
							{
								"label": "My height",
								"value": ""
							},
							{
								"label": "Blood pressure",
								"value": "120x80"
							}
						]
					},
					{
						"title": "Next section",
						"cssClass": "text-secondary",
						"color": "secondary",


						"fields": [{
								"label": "Field1",
								"value": ""
							},
							{
								"label": "Field2",
								"value": ""
							},
							{
								"label": "Field3",
								"value": ""
							},
							{
								"label": "Field4",
								"value": ""
							},
							{
								"label": "Options",
								"type": "options",
								"color": "deep-orange",
								"value": [],
								"options": [{
										"label": 'Option 1',
										"value": 'op1'
									},
									{
										"label": 'Option 2',
										"value": 'op2'
									},
									{
										"label": 'Option 3',
										"value": 'op3'
									}
								]

							}
						]
					},
					{
						"title": "Next section2",
						"cssClass": "text-primary",
						"color": "primary",

						"fields": [{
								"label": "Field1",
								"value": ""
							},
							{
								"label": "Field2",
								"value": ""
							},
							{
								"label": "Field3",
								"value": ""
							},
							{
								"label": "Field4",
								"value": ""
							},
							{
								"label": "Field5",
								"value": ""
							}
						]
					}
				]

			}
		},
		computed: {
			formProgress() {
				//console.log("Recalculated");
				const stat = this.getSurveyStat(this.profileForm);
				return stat.all ? stat.answered / stat.all : 0;
			},
			formProgressLabel() {
				const val = this.formProgress;
				return Math.ceil(val * 100) + "%";
			},
			formStat() {
				const stat = this.getSurveyStat(this.profileForm);
				return stat;
			}
		},
		methods: {
			getSurveyStat(survey) {
				const surveyStat = {
					answered: 0,
					skipped: 0,
					all: 0
				};
				survey.forEach(section => {
					const stat = this.getSectionStat(section);
					surveyStat.answered += stat.answered;
					surveyStat.skipped += stat.skipped;
					surveyStat.all += (stat.answered + stat.skipped);
				});

				return surveyStat;
			},

			getSectionStat(section) {
				return this.getQuestionsStat(section.fields);
			},

			getAnsweredQuestionsStat(fields, statType = 0) {
				return this.getEmptyQuestionsNum(fields, 1).answered;
			},

			getSkippedQuestionsNum() {
				return this.getEmptyQuestionsNum(fields).skipped;
			},

			getQuestionsStat(fields) {
				let skipped = 0;
				let answered = 0;
				fields.forEach(item => {
					if (item.value || (item.defaultValue && (item.value != item.defaultValue))) {
						answered++;
					} else {
						skipped++;
					}
				});

				return {
					answered,
					skipped
				};
			},

		},
		created() {
			this.setupProject();
			this.hubMenuEng.push({
				title: "Education Hub",
				subTitle: "Small, but very important description",
				cssClass: "bg-deep-orange-4 text-white",
				icon: "school"
			});
			this.hubMenuEng.push({
				title: "Health Hub",
				subTitle: "Small, but very important description",
				cssClass: "bg-orange-4 text-white",
				icon: "self_improvement"
			});
			this.hubMenuEng.push({
				title: "Social Hub",
				subTitle: "Small, but very important description",
				cssClass: "bg-positive text-white",
				icon: "people_alt"
			});
			this.hubMenuEng.push({
				title: "Job Hub",
				subTitle: "Small, but very important description",
				cssClass: "bg-secondary text-white",
				icon: "local_library"
			});

			this.eventsEng.push({
				title: "Longevity workshop in Berlin",
				subTitle: "Small, but very important description",
				date: "2022/10/13",
				cssClass: "bg-secondary text-white",
				icon: "local_library",
				img: "intellect/inn1.jpg"
			});
			this.eventsEng.push({
				title: "Winter workshop in Paris",
				subTitle: "Small, but very important description",
				date: "2022/12/02",
				cssClass: "bg-secondary text-white",
				icon: "local_library",
				img: "intellect/table1.jpg"
			});

			this.hubSections.push({
				title: "Services",
				key: "Service",
				subTitle: "Small, but very important description",
				date: "2022/12/02",

				items: [{
					title: "Service1",
					subTitle: "Small, but very important description",
					date: "2022/12/02",
					cssClass: "bg-secondary text-white",
					cssClassTitle: "bg-secondary text-white",
					icon: "local_library",
					img: "intellect/table1.jpg"
				}]
			});
			this.hubSections.push({
				title: "Resources",
				"key": "Resource"
			});


			if (this.user && this.user.personId) {
				//this.loadEnergy();
			}
			this.startupFromConfig(this.getObjectId());



		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>