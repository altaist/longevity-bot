<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: () => {
			return {
				srcText: "2+2;4\n2x+2x;4x\n2+2+2x;4+2x\n2x+2+2;2x+4",
				taskList: [],
				config: {
					strictMode: false,
					showRightAnswer: true

				}

			}
		},
		computed: {
			computedStat() {
				return this.getResult();
			}
		},
		methods: {
			getResultCssClass(item) {
				if (!this.config.showRightAnswer) {
					return "";
				}

				const strClass = this.checkAnswer(item) ? "text-success" : "";
				return strClass;

			},
			checkAnswer(item) {
				let result = ("" + item.r).trim();
				result = result.replace(/ /g, "");
				return result == item.a;
			},
			getResult() {

				let countOk = 0,
					countAnswered = 0;

				this.taskList.forEach(question => {
					if (("" + question.r).trim()) {
						countAnswered++;
					}
					if (this.checkAnswer(question)) {
						countOk++;
					}

				});

				let stat = {
					all: this.taskList.length,
					ok: countOk,
					answered: countAnswered
				}

				stat.wrong = stat.all - stat.ok;
				stat.completed = (1 * stat.ok >= 0.7 * stat.all) ? 1 : 0;
				return stat;
			},

			// Creation
			parseTasks(src) {
				const srsText = "" + src.trim();
				const srcArr = srsText.split("\n");
				if (!Array.isArray(srcArr)) {
					console.log("Empty src text");
				}
				this.taskList = [];

				srcArr.forEach(str => {
					const lineArr = str.split(";");
					if (!Array.isArray(lineArr) || lineArr.length < 2) {
						return;
					}
					const q = ("" + lineArr[0]).trim();
					const a = ("" + lineArr[1]).trim();
					const r = "";
					this.taskList.push({
						q,
						a,
						r
					});
				});
			},

			updateQuiz() {
				this.parseTasks(this.srcText);
			},
			onBtnParse() {
				this.parseTasks(this.srcText)
			}
		},
		created() {
			this.setupProject();
			this.parseTasks(this.srcText);
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>