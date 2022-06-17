
<template>
	<div>
		<b-row>
			<b-col md="4" class="my-1" id="popover-sync">
				&nbsp;
			</b-col>
		</b-row>
		<b-row>
			<loading :active.sync="isLoading" color="#007bff" :height="128" :width="128"></loading>
			<b-col class="my-1 table-responsive players-table">
				<v-client-table :data="getPlayerList" :columns="columns" :options="options" id="popoverButton-event" @loaded="onLoaded">
					<a slot="actions" slot-scope="props"> <!-- v-on:click.stop="" in the a slot prevents the annoying popup of the modal bt prevents any other messages -->
						<player-actions-component  :player="props.row" :player_id="props.row.player_id" :max_reached=props.row.max_reached :remove=props.row.remove :added=props.row.added :not_allowed=props.row.not_allowed :curUserId="curUserId" :user_id="user_id" :commissioner="commissioner" :show_draft_user="show_draft_user" :is_def="is_def" :is_st="is_st" :team_qb="team_qb" v-on:p-action="getPlayers(selectedTeam, 'ALL');"></player-actions-component>
					</a>
          <a href="#" slot="name" slot-scope="props" @click="rowClicked(props)">
            {{ props.row.name }}
          </a>
					<template slot="beforeTable">
						<div class="player-caption">Players</div>
						<player-detail-modal-component :player_id="player_id" :commissioner="commissioner" :show_draft_user="show_draft_user" v-bind:user_id="user_id" v-bind:is_def="is_def" v-bind:is_st="is_st" v-bind:team_qb="team_qb" v-bind:showModal="show_modal" v-on:update:showModal="show_modal = $event"         />
					</template>
				</v-client-table>
			</b-col>
		</b-row>
    <snackbar />
	</div>
</template>

<script>

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
	props:{
      show_team: { type: Boolean, required: false, default: true },
      from_stat: { type: Boolean, required: false, default: false },
      default_page: { type: Boolean, required: false, default: false },
	  commissioner: { type: String, required: false, default: '' },
	  show_draft_user: { type: String, required: false, default: '' },
	  user_id: { type: String, required: false, default: '' },
	  team_pop: { type: String, required: false, default: '' },
    },
	created() {
		this.team 			= this.team_pop;
		this.selectedTeam 	= this.team_pop;
    this.$store.dispatch("getSystemSettings", {});
    this.getPlayers(this.selectedTeam, 'ALL');
    },
	components: {
        Loading
    },
	computed: {
		getPlayerList(){
      console.log('getPlayerList');
			if(this.team_pop != ''){
				this.isLoading =  this.$store.getters.isLoading;
				if(this.isLoading){
					this.isLoading = false;
				}
				return this.$store.getters.getPopupTeamPlayer(this.team_pop);
			}else{
				return this.$store.state.playerList;
			}
		}
	},
    data () {
		return {
      selectedTeam:null,
			show_modal: false,
			showPopup: false,
			isLoading: false,
			fullPage: true,
			players: [],
			myTeamList: [],
			playerList: [],
			columns: [
				// 'available',
        // 'fantasy_team_owned_by.position',
				'actions',
				'fantasy_position',
				'name',
				// 'last_name',
				'team',
				// 'injury_status',
				// 'bye_week',
				// 'upcoming_game_opponent',
				// 'upcoming_opponent_rank',
				// 'average_draft_position',
				// 'fantasy_position_depth_order',
				// 'fantasy_points',
				// 'passing_yards',
				// // 'passing_completion_percentage',
				// 'passing_touchdowns',
				// 'passing_interceptions',
				// // 'passing_rating',
				// 'rushing_attempts',
				// 'rushing_yards',
				// '',
				// 'receptions',
				// // 'receiving_targets',
				// 'receiving_yards',
				// 'receiving_touchdowns',
				// 'points_allowed',
				// 'sacks',
				// 'interceptions',
				// 'fumbles_recovered',
				// 'punt_return_touchdowns'
        ],
			options: {
				filterByColumn: true,
				orderBy: {column: 'fantasy_position'},
				listColumns: {
					fantasy_position: [{
							id: 'RB',
							text: 'RB'
						},
						{
							id: 'TQB',
							text: 'TQB'
						},
						{
							id: 'K',
							text: 'K'
						},
						{
							id: 'WR',
							text: 'WR'
						},
						{
							id: 'TE',
							text: 'TE'
						},
						{
							id: 'DEF',
							text: 'DEF'
						},
						{
							id: 'ST',
							text: 'ST'
						}
					],
					available: [{
							id: '1',
							text: 'Yes'
						},
						{
							id: '0',
							text: 'No'
						}
					]
				},
				perPage:50,
				perPageValues:[15,30,50,100],
				pagination: { chunk:15,dropdown:false },
				filterable:['fantasy_position','team'],
				skin:'table table-bordered table-hover',
				headings: {
					actions: 'Actions',
					fantasy_position: 'Position',
					first_name: 'FName',
					last_name: 'LName',
					name: 'Name',
					team: 'Team',
					injury_status: 'Injury Status',
					upcoming_game_opponent: 'Upcoming Opponent',
					upcoming_opponent_rank: 'Opponent Rank',
					average_draft_position: 'ADP',
					fantasy_position_depth_order: 'Depth Chart',
					passing_yards: 'PaYd',
					passing_completion_percentage: 'Passing Completion Percentage',
					passing_touchdowns: 'PaTd',
					passing_interceptions: 'PaInt',
					passing_rating: 'PaRate',
					rushing_attempts: 'Rushing Attempts',
					rushing_yards: 'RuYd',
					rushing_touchdowns: 'RuTd',
					receptions: 'Rec',
					receiving_targets: 'Receiving Targets',
					receiving_yards: 'ReYd',
					receiving_touchdowns: 'ReTd',
					points_allowed: 'Points Allowed',
					sacks: 'Sck',
					interceptions: 'Int',
					fumbles_recovered: 'FumRec',
					punt_return_touchdowns: 'PrTd',
					fantasy_points: 'Fantasy Points'
				},
				customSorting: {
					fantasy_position: function (ascending) {
						return function(a,b){
							//Store initial order the two objects come in.
							let data = [a,b];
							//var order = ["TQB", "RB", "WR", "TE", "K", "DEF", "ST"];
							var order = ["ST", "DEF", "K", "TE", "WR", "RB", "TQB"];

							var sorted = _.sortBy(data, function(obj){
							    return _.indexOf(order, obj.fantasy_position);
							});

							//Compare if the fantasy_player_key value changed after we sorted.
				            if (!ascending)
				                return data[0].fantasy_player_key != sorted[0].fantasy_player_key ? 1 : -1;

				            return data[0].fantasy_player_key == sorted[0].fantasy_player_key ? 1 : -1;
						}
					}
				},
				multiSorting: {
			        'fantasy_position': [
			            {
			                column: 'fantasy_position_depth_order',
			                matchDir: true
			            }
			        ]
			    },
				rowClassCallback:function(row){
					if(row.available == 'No'){
						return 'alert-danger';
					}
				}
			},
			stat_table_columns: [  'first_name','last_name','name','team','bye_week','upcoming_game_opponent','upcoming_opponent_rank','average_draft_position','fantasy_position_depth_order'],
			currentPage: 1,
			perPage: 50,
			totalRows: 0,
			pageOptions: [ 15, 30, 35, 50, 100 ],
			filter: null,
			teams: null,
			positions: null,
			availablePlayer: null,
			playerPositions: [{ value: null, text: 'ALL' }],
			teamOptions: [{ value: null, text: 'ALL' }],
			availableDrop: [{ value: 1, text: 'Show Available Only' },{ value: 2, text: 'Show Taken' }],
			popoverShow: false,
			experience: '',
			fantasy_draft_name: '',
			fantasy_position: '',
			target: '',
			player_id: '',
			watched: '',
			record: '',
			added: '',
			not_allowed: '',
			available: '',
			max_reached: '',
			componentKey:0,
			remove: '',
			owned_by: '',
			is_def:0,
			is_st:0,
			team_qb:0,
			photo_url:'',
			curUserId:''
		}
	},
	methods: {
		edit (warehouseId) {
        // The id can be fetched from the slot-scope row object when id is in columns
		} ,
		onLoaded() {
			console.log('table loaded')
		},
		onFiltered (filteredItems) {
		  // Trigger pagination to update the number of buttons/pages due to filtering
		  this.totalRows = filteredItems.length
		  this.currentPage = 1
		},

		getPlayerTeam(){
			axios.get('/players/team')
			.then((response)=>{
				this.teamOptions = [];
				response.data.teams.forEach((value, key)=>{
					this.teamOptions.push({ id: value['key'], text: value['key'] })
				})
			})
			.catch(error => {});
		},
		getPlayerPosition(){
			axios.get('/players/positions')
			.then((response)=>{
				this.playerPositions = [{ value: null, text: 'ALL' }];
				response.data.positions.forEach((value, key)=>{
					this.playerPositions.push({ text: value, value: value })
				})
			})
			.catch(error => {});
		},
		getPlayers(selectedTeam,selectedPosition,selectedVal) {
      console.log('getPlayers')
			this.isLoading	= true;
			// this.$store.dispatch('loadPlayerList');
        this.$store
        .dispatch("loadPlayerListPlayoffs", {
          selectedTeam: selectedTeam,
          selectedPosition: selectedPosition,
          season: 2020,
          seasonType: 3,
          isProjection: 0
        })
        },
		// teamChange: function(e) {
		// 	var selectedTeam		=	e.target.value;
		// 	var selectedPosition	=	this.positions;
		// 	var selectedVal			=	this.availablePlayer;
		// 	this.getPlayers(selectedTeam,selectedPosition,selectedVal);
		// },
		positionChange: function(e) {
			var selectedPosition	=	e.target.value;
			this.is_def =0;
			this.is_st  =0;
			this.team_qb  =0;
			if(selectedPosition == 'DEF')
				this.is_def	=	1;
			if(selectedPosition == 'TQB')
				this.team_qb	=	1;
			if(selectedPosition == 'ST')
				this.is_st	=	1;
			var selectedTeam		=	this.teams;
			var selectedVal			=	this.availablePlayer;
			//this.getPlayers(selectedTeam,selectedPosition,selectedVal);
		},
		rowClicked(data){
      //console.log('rowCLicked', data);

      this.record        = data.row;
      this.experience     = data.row.experience;
      this.fantasy_draft_name = data.row.fantasy_draft_name;
      this.fantasy_position   = data.row.fantasy_position;
      this.player_id       = data.row.player_id;
      this.watched       = data.row.watched;
      this.added         = data.row.added;
      this.available      = data.row.available;
      this.max_reached     = data.row.max_reached;
      this.remove       = data.row.remove;
      this.owned_by       = data.row.owned_by;
      this.photo_url       = data.row.photo_url;
      this.is_def       = data.row.is_def;
      this.is_st         = data.row.is_st;
      this.team_qb       = data.row.team_qb;
      this.not_allowed     = data.row.not_allowed;

        this.showModal()
		},
		showModal () {
			//console.log('PlayersTableComponent show modal. fantasy_player.id ='+this.player_id)
			this.show_modal = true
	    },
		onShow () {
		  /* This is called just before the popover is shown */
		  /* Reset our popover "form" variables */

		},
		onShown () {
		  /* Called just after the popover has been shown */
		  /* Transfer focus to the first input */
		  this.focusRef(this.$refs.draftname);
		},
		onHidden () {
		  /* Called just after the popover has finished hiding */
		  /* Bring focus back to the button */
		  this.focusRef(this.$refs.draftname);
		},
		focusRef (ref) {
		  /* Some references may be a component, functional component, or plain element */
		  /* This handles that check before focusing, assuming a focus() method exists */
		  /* We do this in a double nextTick to ensure components have updated & popover positioned first */
		  this.$nextTick(() => {
			this.$nextTick(() => { (ref.$el || ref).focus() });
		  });
		},
		watchPlayer() {
			axios.post('/players/player-transaction',{
					player_id: this.player_id,
					transaction_id: 4,
					is_def: this.is_def,
					is_st: this.is_st,
					team_qb: this.team_qb
				},
				{
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
				})
				.then((response)=>{
					this.record.watched = 1;
					//alert(response.data.message)
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});
				})
				.catch(error => {});
			//this.$refs.popover.$emit('close')
		},
		addPlayer() {
			axios.post('/players/player-transaction',{
					player_id: this.player_id,
					transaction_id: 1,
					is_def: this.is_def,
					is_st: this.is_st,
					team_qb: this.team_qb
				},
				{
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
				})
				.then((response)=>{
					this.record.added = 1;
					this.record.available = 'No';
					this.record.remove = 1;
					this.record.owned_by = response.data.owned_by;

					this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});


				})
				.catch(error => {});
			//this.$refs.popover.$emit('close')

		},
		unWatchPlayer(){
			axios.put('/players/unwatch',{
					player_id: this.player_id,
					is_def: this.is_def,
					is_st: this.is_st,
					team_qb: this.team_qb
				},
				{
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
				})
				.then((response)=>{
					this.record.watched = 0;
					//alert(response.data)
					this.$store.dispatch('showSnackBarSuccess',{message:response.data});
				})
				.catch(error => {});
			//this.$refs.popover.$emit('close')

		},
		removePlayer(){
			axios.put('/players/remove',{
					player_id: this.player_id,
					is_def: this.is_def,
					is_st: this.is_st,
					team_qb: this.team_qb
				},
				{
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
				})
				.then((response)=>{
					this.record.remove = 0;
					this.record.added  = 0;
					this.record.available  = 'Yes';
					this.record.owned_by  = '';
					//alert(response.data)

				if(response.data.status==1){
					this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

				}else{
					this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
				}

				})
				.catch(error => {});
			//this.$refs.popover.$emit('close')

		},
		addBenchPlayer(){
			axios.post('/players/bench-player',{
				player_id: this.player_id,
				is_def: this.is_def,
				is_st: this.is_st,
				team_qb: this.team_qb
			},
			{
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			})
			.then((response)=>{

				this.record.added = 1;
				this.record.remove = 1;
				this.record.owned_by = response.data.owned_by;

				if(response.data.already_added==1){
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

				}else{
				this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
				}


			})
			.catch(error => {});
			//this.$refs.popover.$emit('close')
		},
		availableChange: function(e) {
			var selectedVal			=	e.target.value;
			var selectedPosition	=	this.positions;
			var selectedTeam		=	this.teams;
			// this.getPlayers(selectedTeam,selectedPosition,selectedVal);
		},
		show() {
		  this.showPopup = true
		},
		hide(){
		  this.showPopup = false
		}

	}/*,
	mounted() {
		window.setInterval(() => {
			var selectedVal			=	this.availablePlayer;
			var selectedPosition	=	this.positions;
			var selectedTeam		=	this.teams;
			this.getPlayers(selectedTeam,selectedPosition,selectedVal)
		},10000);
	}, */
}
</script>
