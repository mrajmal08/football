<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="row no-gutters">
          <div class="col align-self-center">
            <div class="card-block">
              <h4 class="card-title division-name"><b>{{ name }}</b></h4>
              <b-table
                responsive
                class="no-table-margin"
                :fields="fields"
                :items="teams"
              >
                <template v-slot:cell(teamname_logo)="data">
                  <b-img
                    class="spark-nav-profile-photo"
                    rounded="circle"
                    :src="data.item.logo"
                  />
                  <span><b>{{ data.item.teamName }}</b></span>
                </template>
              </b-table>
            </div>
          </div>
        </div>
      </div>
    </b-col>
  </b-row>
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
    division: { type: Object, required: false, default: function () {
        return {  }
      }},
    isDivision: { type: Boolean, required: false, default: true },
    },
  data() {
      return {
      fields: [
        // A virtual column made up from two fields
        { key: 'teamname_logo', label: 'Team' },
        { key: 'W', label: 'Win','class': 'text-center' },
        { key: 'L', label: 'Loss','class': 'text-center' },
        { key: 'T', label: 'Tie','class': 'text-center' },
        { key: 'GB', label: 'GB','class': 'text-center' },

        ],
      name: '',
      teams: [],
    }
  },
  created(){
    //this.getDivisionData();
    if(this.division){
      this.name     = this.division.name;
      this.teams      = this.division.teams;
    }
    },
  methods: {
    // getDivisionData() {
    //         axios.get('/league/first-division')
    //   .then((response)=>{
    //     if(this.isDivision){
    //       this.name       = response.data.name;
    //       this.teams      = response.data.teams;
    //     }
    //   })
    //   .catch(error => {});
    //     }
  }
}
</script>
