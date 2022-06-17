<template>
  <b-container fluid>
    <b-row>
      <div class="col-md-1">Year:	</div>
      <div class="col-md-4">
        <b-form-select
          v-model="season"
          @change="changeYear"
        >
          <option selected>2021</option>
        </b-form-select>
      </div>
      <div class="col-md-1">Week:	</div>
      <div class="col-md-4">
        <b-form-select
          v-model="week"
          @change="getSelectedItem"
        >
          <option
            v-for="index in system_week"
            :key="index"
            :value="index"
            @change="changeWeek(index)"
          >
            {{ index }}
          </option>
        </b-form-select>
      </div>
    </b-row>

    <b-row>
      <b-col
        v-if="!loading && error ==''"
        md="12"
      >
        <LeagueTeamRankingComponent
          :week="week"
          :season="season"
        />
      </b-col>
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

import LeagueTeamRankingComponent from "./LeagueTeamRankingComponent.vue";

export default {
	components: { LeagueTeamRankingComponent },
	props:{
	 system_week: { type: Number, required: true },
     week: { type: Number, required: true },
     season: { type: String, required: true },

    },
	data () {
		return {
		  divisions: [],
		  error	: '',
		  loading: false,
		}
	},
	created(){

	},
	methods: {

		getSelectedItem: function(week) {

			window.location.href = '/standings/coach-ratings/'+this.season+'/'+week;
		},
		changeWeek(week) {

			window.location.href = '/standings/coach-ratings/'+this.season+'/'+week;

		},
		changeYear: function(year) {

			window.location.href = '/standings/coach-ratings/'+year+'/'+this.week;


		}
	}
}
</script>
