<template>
  <div>
    <b-row
      v-if="commissioner==1 || is_co_commissioner==1"
      class="d-flex justify-content-between"
    >
      <leaguetask-component />
    </b-row>
    <b-row v-if="draft_completed==1 ">
      <leaguesnapshot-component />
    </b-row>
    <b-row
      v-if="draft_completed==0 "
      class="col-lg-10"
    >
      <b-row>
        <div class="card">
          <div class="card-header">
            Current League Teams**
          </div>
          <div class="card-body">
            <active-fantasy-team-component />
          </div>
        </div>
      </b-row>
    </b-row>
    <b-row>
      <nflnews-component />
    </b-row>
  </div>
</template>

<script>

export default {

	data () {
		return {
		  commissioner: 0,
		  is_co_commissioner: 0,
		  error	: '',
		  loading: false,
		  draft_completed: 0,
		}
	},
	created(){
        this.getLeaqueTask();
	},
	methods: {
		getLeaqueTask() {
			this.loading = true;
            axios.get('/league/task')
				.then((response)=>{
					if(typeof(response.data.error) != "undefined" ){
						this.error 		= response.data.error;
						this.loading 	= false;
					}else{
					let leaque = response.data;
						this.is_co_commissioner	= leaque.is_co_commissioner;
						this.commissioner		= leaque.commissioner;
						this.loading 			= false;
						this.error				= '';
						this.draft_completed	= leaque.draft_completed;
					}
				})
				.catch(error => {});
        }
	}
}
</script>
