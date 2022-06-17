<template>
  <div class="card">
    <div class="row no-gutters">
      <div class="col align-self-center">
        <div class="card-block">
          <b-table
            responsive
            class="no-table-margin"
            :fields="fields"
            :items="teams"
          >
            <!-- A custom formatted column -->
            <template v-slot:cell(TEAM)="data">
              <b-img
                class="spark-nav-profile-photo"
                rounded="circle"
                :src="data.value.logo"
              />
              <span><b>{{ data.value.teamName }}</b></span>
            </template>
          </b-table>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.no-table-margin table {
	margin-bottom: 0rem;
}

.division-name{
	padding: 0.75rem 1.25rem;
	margin-bottom: 0px;
	background: #e2e4e6;
}
</style>

<script>

export default {
	props:{
      week: { type: Number, required: true },
      season: { type: String, required: true },

    },
	data() {
      return {
			fields: [
				{ key: 'TEAM', label: 'TEAM'},
				{ key: 'Prv', label: 'Prv','class': 'text-center' },
				{ key: 'head_to_head_pts', label: 'Head to Head','class': 'text-center' },
				{ key: 'head_to_head_pts_val', label: 'PTS','class': 'text-center' },
				{ key: 'sim_over_all_recod', label: 'Overall Record','class': 'text-center' },
				{ key: 'overall_pts', label: 'Pts','class': 'text-center' },
				{ key: 'average', label: 'Points/Average','class': 'text-center' },
				{ key: 'Pts', label: 'Pts','class': 'text-center' },
				{ key: 'Tournament', label: 'Tournament','class': 'text-center' },
				{ key: 'Tournament_Pts', label: 'Pts','class': 'text-center' },
				{ key: 'POWER', label: 'POWER','class': 'text-center' },
			  ],
			name: '',
			teams: [],
		}
	},
	created(){
		this.getDivisionData();

    },
	methods: {
	getDivisionData() {
			this.loading = true;
            axios.post('/league/leaque_team_rank', {

					  week: this.week,
					  season: this.season,

				})
				.then((response)=>{
					if(typeof(response.data.error) != "undefined" ){
						this.error 		= response.data.error;
						this.loading 	= false;
					}else{
						this.teams		 	= response.data.teams;
						this.loading 	= false;
						this.error		= '';
					}
				})
				.catch(error => {});
        }

	}
}
</script>
