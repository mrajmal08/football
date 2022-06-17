<template>
   <div>
   
 
 
 
   <div v-for="item in news_data">
   
    <news-item-component :player_data="item" />
   </div>   
</div>
</template>

<script>
    export default {
	data () {
		return {
		
		news_data:'',
		}
	},
	 created(){
	 	
		this.getPlayerNews();
	 },
		methods: {
			
			getPlayerNews(){
				axios.get('/fantasy_player_news')
				.then((response)=>{							
					
					this.news_data 		=response.data;
				})
				.catch(error => {});		
						
			}
			
		},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
