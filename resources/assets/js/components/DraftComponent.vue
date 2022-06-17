<template>
   <div class="row py-1">
       <b-col>
          <b-alert show variant="info" class="p-3 m-0 text-center" >
            <div v-if="league_draft_date == null && commissioner == 1">
              <h2>Your draft date has not been set yet. <a href="/settings#/league" title="League settings" target="_blank">Set your draft date now.</a></h2>
            </div>
            <div v-else-if="league_draft_date == null && commissioner != 1">
                <h2>Your draft date has not been set yet.</h2>
            </div>
  			   <div v-else-if="message && draftStarted == 1">
              <h2>{{message}}</h2>
            </div>
            <div v-else-if="draftCompleted">
              <h2>Your draft is complete! <a title="View Roster" href="/team/roster">View your roster</a>.</h2>
            </div>
            <div v-else-if="draft_date && draftStarted != 1">
               <h2>{{draft_date}} & draftStarted = {{draftStarted}}</h2>
            </div>
            <div v-else>
               <h2>&nbsp; draftStarted = {{draftStarted}}</h2>
            </div>
          </b-alert>
        </b-col>
   </div>
</template>

<script>
var moment=require('moment');
var momentDurationFormatSetup = require("moment-duration-format");
momentDurationFormatSetup(moment);
    export default {
	props:{
		message: { type: String,  default: null },
		draft_date: { default: false },
		draftStarted: { default: false },
		draftCompleted: { default: false },
		league_draft_date: { default: false },
		commissioner: { default: false },
    }, data () {
		return {
		  
		end_Date:'',
		
		}
	},
        mounted() {
            //console.log('Component mounted.')
        },
  
	
	// filters:{
	
	// changeDateDilter:function(value){
	// 	var  end= moment(new Date()); //todays date
	// //console.log('-----------------------------'+end);
	// 	var now = moment(value); // another date
	// 	var duration = moment.duration(now.diff(end));
	// 	var timeToDraft = duration;


	// 	//console.log("Second: " + days);
 //        //return moment.duration(timeToDraft).seconds().humanize();

	// 	return moment.duration(timeToDraft).format("d [days], h [hours], m [minutes]", {
	// 	useSignificantDigits: true,
	// 	precision: 0
	// 	});
			
	// }
	
	// },
	  }
	
</script>
