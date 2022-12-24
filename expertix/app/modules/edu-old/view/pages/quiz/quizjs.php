<?php
$viewConfig->includeJsMixin("quiz_3");
?>
<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin, quizMixin, quizParserMixin, quizManagerMixin],
		data: () => {
			return {
				quiz: {},
				quizes: [],
				quizSrc: "Вопрос1\n+Вариант1\n-Вариант2\n\nВопрос2\n+Вариант1\n-Вариант2",
			}
		},
		methods: {

		},
		created() {
			this.setupProject();
			this.createNewQuiz();
			this.updateQuiz(this.quizSrc);
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>