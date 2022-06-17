<template>
  <b-container fluid>
    <b-row>
      <!--<div md="8" >
				<b-col v-if="!loading && error ==''">
					<snapshot-component :isDivision="true"></snapshot-component>
				</b-col>
			</div>-->

      <div
        v-for="division in divisions"
        :key="division.id"
      >
        <b-col v-if="!loading && error ==''">
          <snapshot-component
            :division="division"
            :isDivision="false"
          />
        </b-col>
      </div>

      <b-col
        v-if="!loading && error !=''"
        md="12"
        class="alert alert-info text-center"
      >
        {{ error }}
      </b-col>
    </b-row>
  </b-container>
</template>

<script>

//import DivisionComponent from "./DivisionComponent.vue";

export default {
	//components: { DivisionComponent },
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
