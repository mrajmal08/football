<template>
	<b-container fluid>
		<b-row>
			<b-col md="12" v-if="!loading && error ==''">
				<div v-for="division in divisions">
					<division-component
						:division="division"
						:isDivision="false"
					/>
				</div>
				
			</b-col>
			<b-col md="12" class="alert alert-info text-center" v-if="!loading && error !=''">
				{{error}}
			</b-col>
		</b-row>
	</b-container>
</template>


<script> 

import DivisionComponent from "./DivisionComponent.vue";

export default {
	components: { DivisionComponent },
	data () {
		return {
		  divisions: [],
		  error	: '',
		  loading: false,
		}
	},
	created(){
        this.getDivisions();
	},
	methods: {
		getDivisions() {
			this.loading = true;
            axios.get('/league/divisions')
				.then((response)=>{
					if(typeof(response.data.error) != "undefined" ){
						this.error 		= response.data.error;
						this.loading 	= false;
					}else{
						this.divisions 	= response.data;
						this.loading 	= false;
						this.error		= '';
					}
				})
				.catch(error => {});
        }
	}
}
</script>