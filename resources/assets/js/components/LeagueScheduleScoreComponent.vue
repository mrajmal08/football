<template>
   <div v-if="team_details">
   
   <b-table  hover :items="team_details" :fields="fields" />
</div>
</template>

<script>
  export default {
  props:{
      teams: { required: true },
	  
    },
    data() {
      return {
	  fields: [
          {
            key: 'home_team',
            sortable: true
          },
          {
            key: 'visitor_team',
            sortable: true
          },
          {
            key: 'result',
         
            sortable: true,
           
          }
        ],
        items: [this.teams
          
        ]
      }
    },
	computed: {
		team_details:function(){			
			var team_score = this.items;
			const objteam_score = Object.values(team_score);
			return  Object.values(objteam_score[0]);		
		}
  }
  
  }
</script>
