<template>
   <div>

   <div class="pull-left col-md-12" v-for="(teams, tindex) in items" >

   <h4>Week {{tindex}}- {{teams.time_frame}} <span v-if="tindex == 7 || tindex == 15 ">{{getSpecialText}}</span> </h4>
  <leaque-schedule-score-component v-if="teams.teamData" 	:teams="teams.teamData"	/>
   </div>
	</div>

</div>
</template>

<script>
  export default {
    data() {
      return {

        items:''
      }
    },
	created(){
		this.getLeagueGames();
	},
  computed:{
    getSpecialText: function() {
      let text = "";
      // if(this.week == 7)
        text = "Positioning Round"
      return text;
    }
  },
	methods:{
		getLeagueGames(){
			axios.get('/get-all-league-game',{
				 params: {
					week:this.week,
				  }
			})
			.then((response)=>{
				this.items 	= response.data;
			})
			.catch(error => {});
		}
	}
  }
</script>
