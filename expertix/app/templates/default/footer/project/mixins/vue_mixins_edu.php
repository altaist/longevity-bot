<script>
	let appEduMixin = {
		data() {
			return {
				objectId: -1,
				parentId: -1,

				user: {},
				form: {
					item: {}
				},


				//
				productItems: [],
				lessonItems: [],
				courseItems: [],
				classItems: [],
				journalItems: [],
				groupItems: [],
				studentItems: [],

				themeColors: [
					["#282C62", "#ffffff"],
					["#3AAA35", "#ffffff"],
					["#B7BBD0", "#ffffff"],
					["#BCCF00", "#ffffff"],
					["#59A578", "#ffffff"],
					["#F9BA51", "#ffffff"],
					["#EC6856", "#ffffff"],
					["#4EC0E7", "#ffffff"],
					["#E53061", "#ffffff"],
					["#8B7ACC", "#ffffff"],
					["#226EDD", "#ffffff"],
				],
				courseColors: {
					"0": ["#59A578", "#ffffff"],
					"1": ["#EC6856", "#ffffff"],
					"2": ["#8B7ACC", "#ffffff"],
					"3": ["#F9BA51", "#ffffff"],
					"4": ["#4EC0E7", "#ffffff"],
					"5": ["#282C62", "#ffffff"],
					"6": ["#282C62", "#ffffff"],
				}
			}
		},
		methods: {
			baseInitApi() {
				return this.baseInitNetwork();
			},
			baseInitNetwork() {
				let endpoints = {
					"user": this.getApiPath() + "user/",
					"product": this.getApiPath() + "product/",
					"upload": this.getApiPath() + "upload/",

					"edu": this.getApiPath() + "product/",
					"course": this.getApiPath() + "product/",
					"lesson": this.getApiPath() + "product/",
				};
				this.prepareApiClientByEndpoints(endpoints);
			},

			// Auth
			checkUser(user) {
				if (!user || !user.key) return false;
				return true;
			},
			isStudent(user) {
				if (!this.checkUser(user)) return false;
				return (user.role == 1);
			},
			isTeacher(user) {
				if (!this.checkUser(user)) return false;
				return (user.role == 2);
			},
			isMethodist(user) {
				if (!this.checkUser(user)) return false;
				return (user.role == 3);
			},
			isEduAdmin(user) {
				if (!this.checkUser(user)) return false;
				return (user.role == 4);
			},
			isAdmin(user) {
				if (!this.checkUser(user)) return false;
				return (user.role == 5);
			},
			checkUserRole(user, role) {
				if (!this.checkUser(user)) return false;
				return user.role == role;
			},
			checkUserPermissions(user, role, minLevel = -1) {
				if (!this.checkUser(user)) return false;
				if (minLevel < 0) {
					return this.user.role >= role;
				} else {
					return this.user.role >= role && this.user.level >= minLevel;
				}
			},
			baseSetupUser() {
				let pageUser = this.getPageController().getUser();
				if (pageUser) {
					this.user = pageUser;
				}
			},

			// API


			// Product

			// Course
			loadCourse() {
				let courseId = this.objectId;
				this.requestApi("edu", "course_get", {
					courseId
				}, (result) => {
					console.log(result);
					this.course = result;
					//this.form.item = this.course;
					this.lessonItems = result["classes"];
					this.studentItems = result["students"] || [];
					// Vue.set(this.lessonItems, "items", result);
					Vue.set(this.lessonsView, "items", this.lessonItems);
				})
			},

			// Class
			loadClass(user = null) {
				let classId = this.objectId;
				this.requestApi("edu", "class_get", {
					classId: 1,
					studentId: user ? user.id : null
				}, (result) => {
					console.log("Class loaded", result);
					this.journalItems = result["journal"];
					let form = {
						item: result
					};
					Vue.set(this, "form", form);
					//Vue.set(this.lessonsView, "items", this.lessonItems);
				});
			},
			normalizeUrl(url) {
				if (!url) return "";
				if (url.indexOf("https://") < 0 && url.indexOf("http://") < 0) {
					return "https://" + url;
				}
				return url;
			},
			createClass(item) {

				item.courseId = this.course.courseId;
				item.img = this.normalizeUrl(item.img);
				item.video = this.normalizeUrl(item.video);
				this.requestApi("product", "class_create", item, (result) => {
					this.loadCourse();
					this.alert("Новое занятие добавлено");

				});
			},
			updateProduct(item) {

				item.courseId = this.course.courseId;
				item.productId = this.course.productId;

				item.img = this.normalizeUrl(item.img);
				item.video = this.normalizeUrl(item.video);
				this.requestApi("product", "product_update", item, (result) => {
					this.alert("Данные обновлены");

				});
			},

			//
			selectLesson(lesson) {
				this.selectedLesson = lesson;
			},
			setMark(item, grade) {
				item.homeworkMark = grade;
				//			this.selectedLesson.homeWork.grade = item.homeWork.grade;
				//console.log(control);
				//control.variant = "danger";
			},
			getMarkColorClass(mark, asVariant = false) {
				let textColor = "text-white";
				let bgColor = "bg-success";
				let variant = "success";
				if (mark < 3) {
					bgColor = "bg-danger";
					variant = "danger";
				} else if (mark < 4) {
					bgColor = "bg-warning";
					variant = "warning"
				}
				return asVariant ? variant : "" + textColor + " " + bgColor;
			},

			onHomeworkAnswer(item) {
				let userJournal = item.studentJournal;
				if (!((userJournal.homeworkAnswer || "").trim())) {
					this.showError("Введите текст ответа");
					return;
				}
				this.requestApi("product", "homework_answer_set", userJournal, (result) => {
					this.alert("Домашнее задание принято");
					userJournal.homeworkDone = true;
				})

			},
			onHomeworkAnswerInJournal(item) {
				let userJournal = item.journal[0]; //this.getItemById(item.journal, this.user.id);
				console.log(userJournal);
				//userJournal.homeworkAnswer = item.homeworkAnswer;
				userJournal.homeworkDate = "2021-01-01";

				this.requestApi("product", "homework_answer_set", userJournal, (result) => {
					this.alert("Домашнее задание принято");
					userJournal.homeworkDone = true;
				})


			},
			onHomeworkMarkUpdate(item) {
				let userJournal = item;
				this.requestApi("product", "homework_mark_update", userJournal, (result) => {
					this.alert("Оценка изменена");
					userJournal.homeworkDone = true;
				})

			},
			onQuizSaveResult(item) {
				
				let userJournal = item.studentJournal;
				if (!((item.quizText || "").trim())) {
					this.showError("Нет активного теста");
					return;
				}

				let quizStatistic = this.getStatistic();

				userJournal.quizJson = this.quiz;
				userJournal.quizResult = JSON.stringify(quizStatistic);
				userJournal.completed = (1 * quizStatistic.ok == 1 * quizStatistic.all) ? 1 : 0;


				this.requestApi("product", "quiz_answer_set", userJournal, (result) => {
					this.alert("Ответы на тест приняты");
					userJournal.quizDone = true;
				})

			},
			updateClassContent(item) {
				item.img = this.normalizeUrl(item.img);
				item.video = this.normalizeUrl(item.video);
				this.btnSaveQuiz();

				this.requestApi("product", "class_update", item, (result) => {
					this.alert("Изменения сохранены");

				});
			},
			deleteClass(item) {
				if (!confirm("Вы уверены, что хотите удалить информацию об этом занятии?")) return;
				this.requestApi("product", "class_delete", item, (result) => {
					this.alert("Занятие удалено");

				});
			},
			onClassSelect(course) {
				console.log(course);
				//let u = this.user;
				this.currentCourse = course;
				this.user.course = course;
				//this.user = u;
				//this.$set(this.user, "course", course);
				console.log(this.user);
			},
		}

	};

	let quizMixin = {
		//el: "#vueApp",
		//template: tmpl_question,

		data() {
			return {
				quiz: {
					title: "Тест без вопросов",
					startQuestionIndex: 0,
					isMultiQuestions: false,
					isMultiAnswers123: false,
					canChangeAnswer: true,
					showRightAnswer: false,
					autoNextQuestion: false,
					cycledQuestions: true,
					strictNavMode: false,
					easyMode: true,

					type: "list", // list input
					choiceView: "list", // "list" "btn" "check"
					choiceShort: false, // "lg"
					selectedChoice: {},
					answersInQuestion: true,
					answerPrefixes: "12345678", // "АБВГ", "ABCD"
					questions: [],
					currentIndex: 0
				},

			}
		},
		computed: {
			lang() {
				return {
					introText: "Предлагаем пройти тест на закрепление материала!",
					btn_start: "Пройти тест",
					btn_start_again: "Пройти тест еще раз",
					btn_next: "Следующий >",
					btn_prev: "< Предыдущий",
					btn_results: "Результаты",
					btn_save: "Сохранить",
					btn_load: "Загрузить",

				}
			},
			questions() {
				return this.quiz.questions;
			},
			currentQuestion() {
				return this.getQuestion(this.quiz.currentIndex);

			},
			isMultiQuestions() {
				return this.quiz.isMultiQuestions;
			},
			isAutoNextQuestion() {
				return this.quiz.isAutoNextQuestion;
			},
			isShowNavButtons() {
				return (this.quiz.isShowNavButtons || !this.isAutoNextQuestion) && !this.isMultiQuestions;
			},
			isLastQuestion() {
				return this.questionsNum <= (this.quiz.currentIndex + 1);
			},
			isFirstQuestion() {
				return this.quiz.currentIndex == 0;
			},
			showNextBtn() {
				let question = this.currentQuestion;
				//let selectedChoice = question.selectedChoice;
				console.log(question);

				if (this.quiz.strictNavMode) { // Если активен режим, когда показываем кнопку только после наличия ответов
					// Идем дальше только если есть ответ (для открытых вопросов проверка не выполняется)
					if (!question.selectedChoice && !this.checkTypeInput(question)) {
						return false;
					}
				}
				// Проверяем, не последний ли вопрос и нет ли режима зацикленных вопросов
				if (!this.quiz.cycledQuestions && this.isLastQuestion) {
					return false;
				}
				return true;
			},
			showPrevBtn() {
				if (this.quiz.strictNavMode) {
					//return false;
				}
				if (!this.quiz.cycledQuestions && this.isFirstQuestion) {
					return false;
				}
				return true;
			},

			questionsNum() {
				return this.quiz.questions.length;
			}

		},
		methods: {
			questionVisible(item) {
				return this.isMultiQuestions || (this.currentQuestion.id == item.id); // (item.index == this.quiz.currentIndex || this.quiz.currentIndex == -1);
			},
			checkQuizState(mode) {
				if (!this.quiz.currentState) {
					this.quiz.currentState = "quiz";
				}
				return this.quiz.currentState == mode;
			},
			checkQuestionView(question, view, size) {
				return true;

			},
			checkTypeInput(question) {
				return (question.type || 'choice') == "input";
			},
			checkAnswersView(question, type, view = null, size = null) {
				let quiz = this.quiz;

				let questionType = question.type || "choice";
				let answerView = question.choiceView || quiz.choiceView || "list";
				let answerShort = question.choiceShort || quiz.choiceShort || false;
				return questionType == type && (view === null ? true : (answerView == view)) && (size === null ? true : answerShort == size);
			},
			checkAnswersInQuestion(question) {
				return question.answersInQuestion || this.quiz.answersInQuestion;
			},
			getAnswerPrefix(answer) {
				let prefix = answer.prefix;
				return (prefix ? prefix + ". " : '');
			},
			getAnswerText(answer, full = true) {
				return this.getAnswerPrefix(answer) + (full ? answer.text : '');
			},
			getControlAnswerText(question, answer) {
				return answer.controlText;
				let isFull = !(question.choiceShort || this.quiz.choiceShort);
				return this.getAnswerText(answer, isFull);
			},
			getStatistic() {
				let stat = {};
				stat.all = this.questionsNum || 0;
				stat.ok = 0;
				stat.answered = 0;

				this.questions.forEach(question => {
					if (!question.result) {
						question.result = {};
					}
					question.result.ok = true;
					if (question.selectedChoice) {
						stat.answered++;
					}

					if (question.type == "sortable") {
						let answers = question.answers;
						for (let i = 0; i < answers.length; i++) {
							const answer = answers[i];
							if (answer.index != i) {
								question.result.ok = false
							}
						}
					} else {
						question.answers.forEach(answer => {
							if (answer.selected) {}
							if (answer.right && !answer.selected || !answer.right && answer.selected) {
								question.result.ok = false;
								return;
							}
						});
					}
					if (question.inputs) {
						question.inputs.forEach(input => {
							if (!input.rightValue) {
								return;
							}
							if (!input.value && input.rightValue) {
								question.result.ok = false;
								return;
							}

							// Check with types
							let eq = true;
							if (!isNaN(input.rightValue) && !isNaN(input.value)) {
								eq = parseFloat(input.rightValue) == parseFloat(input.value);
							} else {
								eq = input.value == input.rightValue;
							}
							if (!eq) {
								question.result.ok = false;
								return;
							}
						});
					}
					if (question.result.ok) stat.ok++;
				});
				stat.correct = stat.ok;
				stat.wrong = stat.all - stat.ok;

				return stat;
			},


			getQuestion(i) {
				let index = i < 0 ? 0 : i;
				index = index < this.questionsNum ? index : this.questionsNum;
				return this.questions[index];
			},
			toNextQuestion() {
				if (this.quiz.currentIndex < this.questionsNum - 1) {
					this.quiz.currentIndex++;
				} else {
					if (this.quiz.cycledQuestions) {
						this.quiz.currentIndex = 0;
					}
				}
			},
			toPrevQuestion() {
				if (this.quiz.currentIndex > 0) {
					this.quiz.currentIndex--;
				} else {
					if (this.quiz.cycledQuestions) {
						this.quiz.currentIndex = this.questionsNum - 1;
					}
				}
			},
			switchStateToIntro() {
				this.quiz.currentState = "intro";
			},
			switchStateToQuiz() {
				this.quiz.currentIndex = 0;
				this.quiz.currentState = "quiz";
			},
			switchStateToResults() {
				this.quiz.currentState = "results";
			},


			setAnswer(question, answer) {
				if (question.type == "sortable") {
					return;
				}
				if (question.selectedChoice && !this.quiz.canChangeAnswer) {
					return;
				}
				if (!question.result) {
					question.result = {};
				}
				if (!question.result.selected) {
					question.result.selected = new Array(question.answers.length);
				}
				if (!question.result.inputs) {
					question.result.inputs = new Array((question.inputs || []).length);
				}

				question.selectedChoice = answer;
				let selected = answer.selected || false;
				Vue.set(answer, "selected", !selected);
				Vue.set(answer, "changed", true);

				question.result.selected[answer.index] = answer;

				if (this.isAutoNextQuestion) {
					this.toNextQuestion();
				}
			},
			buttonColor(answer) {
				if (answer.changed && this.quiz.showRightAnswer) {
					return (answer.selected ? '' : 'outline-') + (answer.right ? 'success' : 'danger');
				} else {
					return (answer.selected ? '' : 'outline-') + 'danger';
				}
			},
			buttonColor2(answer) {
				if (answer.changed && this.quiz.showRightAnswer) {
					return (!answer.selected ? '' : (answer.right ? 'success' : 'danger'));
				} else {
					return (answer.selected ? 'primary' : '');
				}
			},
			questionSectionColor(item) {
				if (this.quiz.showRightAnswer) {
					return item.result.ok ? 'text-success' : 'text-danger';
				} else {
					return 'text-primary';
				}
			},
			onBtnNext() {
				this.toNextQuestion();
			},
			onBtnPrev() {
				this.toPrevQuestion();
			},
			createEmptyQuiz() {
				return {
					title: "Пример теста",
					startQuestionIndex: 0,
					isMultiQuestions: false,
					isMultiAnswers123: false,
					canChangeAnswer: true,
					showRightAnswer: false,
					autoNextQuestion: false,
					cycledQuestions: false,
					strictNavMode: false,
					easyMode: true,

					type: "list", // list input
					choiceView: "list", // "list" "btn" "check"
					choiceShort: false, // "lg"
					selectedChoice: {},
					answersInQuestion: true,
					answerPrefixes: "12345678", // "АБВГ", "ABCD"
					questions: [],
					currentState: 'intro',
					currentIndex: 0
				}
			},
			shuffle(array) {
				for (let i = array.length - 1; i > 0; i--) {
					let j = Math.floor(Math.random() * (i + 1));
					[array[i], array[j]] = [array[j], array[i]];
				}
			},



			prepareQuiz(_quiz) {
				let quiz = _quiz;
				let questions = quiz.questions;
				for (let index = 0; index < questions.length; index++) {
					const question = questions[index];
					question.index = index;
					if (!question.type) {
						question.type = "choice";
					}
					if (!question.title) {
						question.title = "Вопрос " + (1 * question.index + 1);
					}

					let prefixes = quiz.answerPrefixes || "1234567";

					let rightAnswers = question.right;
					let answers = question.answers || [];
					//let isFullControlText = question.answerSize != "sm";
					let isFullControlText = !(question.choiceShort || quiz.choiceShort);
					this.shuffle(answers);


					for (let j = 0; j < answers.length; j++) {
						let answer = answers[j];
						answer.pos = j;
						answer.prefix = question.type == 'choice' ? prefixes.charAt(j) : "";

						answer.controlText = isFullControlText ? answer.text : answer.prefix;
						answer.align = isFullControlText ? "text-left" : "text-center";

						if (answer.right === undefined) {
							answer.right = false;
							if (rightAnswers) {
								rightAnswers.forEach(answerId => {
									if (answerId == answer.id) {
										answer.right = true;
									}
								});
							}
						}


						//console.log(answer);

					}


				}
				return quiz;
			},
			// TestMaker
			checkIsEditor() {
				return this.currentEditorMode == 'editor';
			},
			loadQuiz(quiz) {
				this.quiz = this.prepareQuiz(quiz);
			},
			createNewQuiz() {
				this.quiz = this.createEmptyQuiz();

				let title = "" + this.quiz.title;
				this.quiz.title = title;
				this.quizes.push(this.quiz);
				this.currentEditorMode = "editor";
			},

			updateQuiz(txt) {
				let text = (txt || this.quizSrc || "").trim();
				if (!text) {
					console.log("Empty quizSrc");
					return;
				}
				this.quiz.questions = this.parseQuizQuestions(text);
				this.prepareQuiz(this.quiz);
				//this.loadQuiz();
			},
			onUpdateQuiz() {
				let text = (this.quizSrc || "").trim();
				this.updateQuiz(text);
			},
			initQuestion(question) {
				if ((!question.answers || question.answers.length == 0) && (!question.inputs || question.inputs.length == 0)) {
					question.type = 'input';
					question.answers = [];
					question.inputs = [{
						type: 'input',
						text: ''
					}];
				}

				if (!question.inputs) {
					question.inputs = [];
				}
				let answers = question.answers;
				let rightAnswersNum = 0;
				answers.forEach(answer => {
					if (answer.right == 1) {
						rightAnswersNum++;
					}
				});
				if (rightAnswersNum == 0 && answers.length > 1) {
					question.type = "sortable";
				}

				return question;
			},
			getRandomInt(min, max) {
				min = Math.ceil(min);
				max = Math.floor(max);
				return Math.floor(Math.random() * (max - min)) + min; //Максимум не включается, минимум включается
			},
			getRandomIntInclusive(min, max) {
				min = Math.ceil(min);
				max = Math.floor(max);
				return Math.floor(Math.random() * (max - min + 1)) + min; //Максимум и минимум включаются
			},
			parseMarkdown(markdownText) {
				const htmlText = markdownText
					.replace(/^### (.*$)/gim, '<h3>$1</h3>')
					.replace(/^## (.*$)/gim, '<h2>$1</h2>')
					.replace(/^# (.*$)/gim, '<h1>$1</h1>')
					.replace(/^\> (.*$)/gim, '<blockquote>$1</blockquote>')
					.replace(/\*\*(.*)\*\*/gim, '<b>$1</b>')
					.replace(/\*(.*)\*/gim, '<i>$1</i>')
					.replace(/!\[(.*?)\]\((.*?)\)/gim, "<img alt='$1' src='$2' />")
					.replace(/\[(.*?)\]\((.*?)\)/gim, "<a href='$2'>$1</a>")
					.replace(/\n$/gim, '<br />')

				return htmlText.trim()
			},
			parseAutoTestMath(line) {
				let result = {};
				let str = "" + line; //line.substr(1);
				if (!str || str.trim().length == 0) {
					return null;
				}

				const parts = str.split(";");
				let patternQ = parts[0];
				let patternA = parts.length > 1 ? parts[1] : "";
				let numVariants = parts.length > 2 ? parts[2] : 1;
				let repeats = parts.length > 3 ? parts[3] : 1;

				if (!patternQ) return null;

				// Parsing question
				let expr = "";
				let vars = {};

				let chars = patternQ.split("", 50);
				//chars.replace(/[abcdef]+/gi, (name) => {vars[name]});

				chars.forEach(char => {
					if (char == 'a' || char == 'b' || char == 'c' || char == 'd') {
						const name = char;
						const size = 1; //parseInt(char);
						const val = this.getRandomIntInclusive(1, Math.pow(10, size));
						vars[name] = val;
						expr += val;
						if (patternA) {
							patternA = patternA.replace(new RegExp(name, 'gi'), val);
						}
						Math.random();
						Math.random();

					} else {
						expr += char;
					}
				});
				result.question = expr;
				result.calculated = null;
				let calculated = 0;
				try {
					calculated = eval(expr);
					if (!isNaN(calculated) && calculated != Math.ceil(calculated)) {
						calculated = calculated.toFixed(2);
					}
					result.calculated = calculated;

				} catch (error) {
					console.log(error)
				}

				result.answer = patternA || result.calculated || result.question;
				return result;
			},
			createAutoQuestion(question, line) {

				let expr = this.parseAutoTestMath(line);
				if (!expr) {
					return null;
				}

				let answer = {};
				answer.id = 1;
				answer.right = 0;
				answer.type = "input";

				question.text += expr.question;
				answer.rightValue = expr.answer;
				question.inputs.push(answer);
				return question;

			},
			createNewQuestion(id, text = "", type = "") {
				let question = {};
				question.id = id;
				question.type = "";
				question.text = text;
				question.answers = [];
				question.inputs = [];
				question.selectedChoice = null;
				return question;
			},
			parseQuizQuestions(text) {

				if (!text) return;
				let lines = text.split("\n");
				let questions = [];
				let question = null;
				let answerIndex = 0,
					questionIndex = 0;

				lines.forEach(line => {
					if (!line || ("" + line).trim().length == 0) {
						return;
					}
					let firstSym = line.charAt(0);
					if (firstSym == '-' || firstSym == "+" || firstSym == "*") {
						// Ответ
						if (!question || line.length <= 1) {
							return;
						}
						let answer = {};
						answer.id = answerIndex;
						answer.index = answerIndex;
						answer.text = line.substr(1);

						let txt = "";
						if (firstSym == "+") {
							answer.right = 1;
							question.answers.push(answer);
						} else if (firstSym == "-") {
							answer.right = 0;
							question.answers.push(answer);
						} else if (firstSym == "*") {
							answer.right = 0;
							answer.type = "input";
							answer.rightValue = answer.text;
							//question.type = "input";

							question.inputs.push(answer);
						} else if (false && firstSym == "@") {
							let expr = this.autoTestMath(answer.text);
							let val = expr;
							answer.rightValue = answer.text;
							try {
								val = eval(expr);
								answer.rightValue = val;
							} catch (error) {}

							answer.right = 0;
							answer.type = "input";
							question.inputs.push(answer);
						}


						answerIndex++;

					} else {
						// Save old question
						if (question) {
							this.initQuestion(question);
							questions.push(question);
							questionIndex++;
						}
						// New question
						question = this.createNewQuestion(questionIndex, line);
						answerIndex = 0;
						if (firstSym == "@" || line.indexOf("@") >= 0) { // autoquestion
							const arr = line.split("@");
							question.text = arr[0];
							const aq = this.createAutoQuestion(question, arr[1]); //line.substr(line.indexOf("@"))
							if (aq) {
								question = aq;
							}
						}

					}
				});

				// Close last question
				if (question) {
					this.initQuestion(question);
					questions.push(question);
					questionIndex++;
				}
				return questions;
			},
			saveQuiz(_quiz) {
				this.form.item.quizText = this.quizSrc;
				let quiz = _quiz;
				quiz.src = this.quizSrc;
				let jsonStr = JSON.stringify(quiz);
				console.log(jsonStr);
				this.jsonStr = jsonStr;
				this.form.item.quizJson = jsonStr;
				//saveLocalStorage("quiz", json);
			},
			btnSaveQuiz() {
				this.saveQuiz(this.quiz);
			},
			btnLoadQuiz() {
				let q = JSON.parse(this.jsonStr);
				let src = q.src;
				if (!src) {
					alert("Нет данных src для построения теста");
					return;
				}
				this.quizSrc = src;

				this.createNewQuiz();
				this.updateQuiz(src);
				console.log();


			}


		}
	};
</script>