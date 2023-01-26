<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: ()=>{
			return{
				contentGroups: {"1": "Утро", "2": "Вечер", "10": "Картинки"},
				tab: "common",
				columns: [
					{ name: 'created', align: 'left', label: 'Дата', field: 'created', sortable: true },
					{ name: 'contentGroup', align: 'left', label: 'Рассылка', field: 'contentGroup', format: (val)=>{let contentGroups= { "1": "Утро", "2": "Вечер", "10": "Картинки" }; return contentGroups[val]||"?"}, sortable: true },
					{ name: 'tags', align: 'left', label: 'Теги', field: 'tags', sortable: true },
					{ name: 'rating', align: 'left', label: 'Оценка', field: 'rating', sortable: true },
					{ name: 'content', align: 'left', label: 'Текст', field: 'messageText', format123: (val, row)=>{return row["messageImg"]?("<a href='"+ row["messageImg"] +"' target='top'>"+val+"</a>"):val}, sortable: true }
				],
				initialPagination: {
					//sortBy: 'desc',
					//descending: false,
					//page: 2,
					rowsPerPage: 30
					// rowsNumber: xx if getting data from a server
				}
			}
		},
		methods:{
			
			getGroups(val){
				return "ff";//this.contentGroups[val] || "?";
			}
			
		},
		created(){
			this.setupProject();
		},
	};
	PageController.setVueConfig(vueAppConfig);
</script>