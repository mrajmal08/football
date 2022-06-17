<style>
#t th,
td {
  padding: 10px;
  
  text-align: center;
}
</style>
<template>
	<b-container fluid>
		<div class="alert alert-success" v-if="form.success > 0">
			Your team settings has been updated!
		</div>
		<div class="alert alert-danger" v-if="form.errors.length > 0">
			<span  v-show="form.errors.length > 0" v-for="error in form.errors">
						{{ error }}
					</span>
		</div>
		
		<table id="t">
  
  <tbody>
    <tr>
      <td >Select Player</td>
      <td width="80%"><v-select :options="fantasy_players"   label="name" id="fantasy_player_id"  @input="PlayerChange" >
				<template slot="option" slot-scope="option">        
					{{ option.name }}, {{ option.team }}
				</template>
			 </v-select></td>
     
    </tr>
	
	
	<tr>
      <td>Week</td>
      <td width="80%"><v-select :options="weeks" id="week"  v-model = "week"   @input="WeekChange" /></td>
     
    </tr>
	
	<tr>
      <td>Season</td>
      <td width="80%"><v-select :options="years" id="season"  v-model = "season"  @input="SeasonChange"  /></td>
     
    </tr>
	
	<tr>
      <td>Season Type</td> 
      <td width="80%">
	  
	  <v-select :options="seasonType" label="title" id="season_type"  v-model = "season_type" @input="SeasonTypeChange" >
				<template slot="option" slot-scope="option">        
					{{ option.title }}
				</template>
			 </v-select>
			 
	  
	 <!-- <v-select :options="weeks" id="season_type"   @input="SeasonTypeChange" />-->
	 </td>
     
    </tr>
	
	<tr v-if="score_details">
      <td>Game</td> 
      <td width="80%">{{score_details}} fpts:{{fantasy_points_acme}}</td>
     
    </tr>
	
	
	<tr>
      <td>Adjustment Amount</td>
      <td width="80%"><input class="form-control"  placeholder="Adjustment Amount" id="adjustment_amount" v-model="adjustment_amount">
</td>
     
    </tr>
	
	<tr>
      <td>Comment</td>
      <td width="80%"><textarea  class="form-control"  placeholder="Comment" id="comment" v-model="comment"></textarea></td>
     
    </tr>
	 

  </tbody>
  
  </table>
  
  
  
				   
	 

	 
<b-container fluid>

<button type="submit" class="btn btn-primary" @click.prevent="updateForm">

								Save Team
				   </button>
<br/><br/>
<h3>Scoring Review</h3>
  <div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							
							<th colspan="1">Player</th>
							<th colspan="1">Game Key</th>
							<th colspan="1">Week</th>
							<th colspan="1">Season</th>
							<th colspan="1">Season Type</th>
							<th colspan="1">Adjustment Amount</th>
							<th colspan="1">comment</th>
						  </tr>
						</thead>
						<tbody >
						
						
						
											
							 <tr v-for="(item,index) in scoring_review_details">							 
							 <td> {{ item.fantacy_player.name }}</td>
							 <td>{{ item.game_key }} </td>
							 <td>{{ item.week }} </td>
							 <td>{{ item.season }} </td>
							 <td> {{ item.season_type }}</td>
							 <td> {{ item.adjustment_amount }}</td>
							 <td>{{ item.comment }} </td>
							 </tr>
							 </tbody>
							 
					</table>
				</div>
				
	</b-container>		
				
	</b-container>
</template>


<script> 


export default {
props:{
      fantasy_player: { required: false },
	  years: { required: false },
	  sys_week: { required: false },
	  sys_season: { required: false },
	  sys_season_type: { required: false },
	   scoring_review: { required: false },
    },
	data () {
			return {
			form: {
				name: '',
				errors:[],
				success:'',
				error:''
			  },
			scoring_review_details:[],
			fantasy_players:[],
			week:'',
			season:'',
			season_type:'',
			fantasy_player_id:'',
			weeks:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
			score_details:'',
			fantasy_points_acme:'',
			game_key:'',
			adjustment_amount:'',
			comment:'',
			seasonType: [
					{
					  title: 'REG',
					  id: 1,
					  
					},
					{
					  title: 'PRE',
					  id: 2,
					},
					{
					  title: 'POST',
					  id: 3,
					}
			]
		  }
	},
	 mounted() {
	 
		this.scoring_review_details 						= this.scoring_review;
		this.fantasy_players 			= this.fantasy_player;
		this.years 						= this.years;
		this.week 			= this.sys_week;
		this.season_type 			= this.sys_season_type;
		this.season 			= this.sys_season;
		
    },
	methods: {
	
	PlayerChange(value){
		this.fantasy_player_id	=	value.id;
		this.onChange();
	},
	WeekChange(value){
		this.week	=	value;
		this.onChange();
	},
	SeasonChange(value){
		this.season	=	value;
		this.onChange();
	},
	SeasonTypeChange(value){
		this.season_type	=	value.id;
		this.onChange();
	},	
	onChange() {
	
			
         	axios.get('/score_review',{params: {fantasy_player_id:this.fantasy_player_id,week:this.week,season:this.season,season_type:this.season_type}})
			.then((response)=>{
			var response_data=response.data;
			console.log(response.data);
				this.score_details 	= response_data.score_card;
				this.game_key		= response_data.game_key;
				this.fantasy_points_acme		= response_data.fantasy_points_acme;
			})
			.catch(error => {});  
         }  ,  
     updateForm() {
	 
			if(this.game_key || this.fantasy_player_id==''){
								
					axios.post('/save_score_review',{
								fantasy_player_id:this.fantasy_player_id,
								week:this.week,
								game_key:this.game_key,
								season:this.season,
								season_type:this.season_type,
								adjustment_amount: this.adjustment_amount,
								comment: this.comment,
								
							},
							{
								headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
							})
							.then((response)=>{
								this.players_id=[];		
									if(response.data.status=='success'){
									this.form.errors 	= 0;
									this.form.success 	= 1;
									this.form.error 	= 0;
					
									
								}
							else{
									this.form.success = 0;
									this.form.error = 1;
									this.form.errors.push(response.message);
							
							}
							
							
							})
							.catch(error => {this.form.success = 0;
							this.form.error = 1;
							this.form.errors.push('Game key or player  is not Available');
					});
							
			}else{
							this.form.success = 0;
							this.form.error = 1;
							this.form.errors.push('Game key or player  is not Available');
					
									
					
			
			}
							
							
        },
	}
}
</script>