<script>
	let vueAppConfig = {
		el: '#jsApp',
		mixins: [projectMixin],
		data: ()=>{
			return{
				
			}
		},
		methods:{
			
		},
		created(){
			this.setupProject();
		},
	};
	PageController.setVueConfig(vueAppConfig);
	</script>