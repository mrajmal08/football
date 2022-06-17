<template>
	<div class="card">
        <div class="row no-gutters">
            <div class="col align-self-center">
                <div class="card-block">
                    <h4 class="card-title division-name"><b>{{name}}</b></h4>
                    <b-table responsive class="no-table-margin" 
						:fields="fields" :items="teams">
						
						 <!-- A custom formatted column -->
						<template v-slot:cell(TEAM)="data">
						  <b-img class="spark-nav-profile-photo" rounded="circle" :src="data.item.logo" />
						  <span><b>{{data.item.name}}</b></span>
						</template>
						
					</b-table>
                </div>
            </div>
        </div>
    </div>
</template>



<script> 

export default {
	props:{
      division: { type: Object, required: false },
	  isDivision: { type: Boolean, required: false, default: true },
    },
	created(){
		this.getDivisionData();
		if(!this.isDivision){
			this.name		 	= this.division.name;
			this.teams			= this.division.teams;
		}
    },
	data() {
      return {
			fields: [
				{ key: 'TEAM', label: 'TEAM'},
				{ key: 'W', label: 'W','class': 'text-center' },
				{ key: 'L', label: 'L','class': 'text-center' },
				{ key: 'T', label: 'T','class': 'text-center' },
				{ key: 'PCT', label: 'PCT','class': 'text-center' },
				{ key: 'GB', label: 'GB','class': 'text-center' },
				{ key: 'STREAK', label: 'STREAK','class': 'text-center' },
				{ key: 'DIV', label: 'DIV','class': 'text-center' },
				{ key: 'WKS', label: 'WKS','class': 'text-center' },
				{ key: 'PF', label: 'PF','class': 'text-center' },
				{ key: 'BACK', label: 'BACK','class': 'text-center' },
				{ key: 'PA', label: 'PA','class': 'text-center' },
			  ],
			name: '',
			teams: [],
		}
	},
	methods: {
		getDivisionData() {
            axios.get('/league/first-division')
			.then((response)=>{
				if(this.isDivision){
					this.name 			= response.data.name;
					this.teams		 	= response.data.teams;
				}
			})
			.catch(error => {});
        }
	}
}
</script>