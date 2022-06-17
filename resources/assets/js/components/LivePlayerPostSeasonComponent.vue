<template>
	<b-col>
		<div class="table-view zoomTarget" data-targetsize="0.40" data-duration="600" data-debug="false" data-preservescroll="true" data-closeclick="true" data-easing="ease-in-out">
            <div class="table-view-head">
                <div class="table-head--left cell-space">{{place | ordinalSuffix}} Place</div>
                <div class="table-head--right cell-space b-top b-left b-right">{{seasonData.fantasy_team_details.name}}</div>
            </div>
            <div class="table-view--content">
<!--                 <div class="table-data--container">
                    <div class="table--data cell-space txt-uppercase b-right cell-pos">POS</div>
                    <div class="table--data cell-space txt-uppercase b-right">Name</div>
                    <div class="table--data cell-space txt-uppercase b-right">team</div>
					 <div class="table--data cell-space txt-uppercase b-right">Score</div>
                    <div class="table--data cell-space txt-uppercase b-right">Stats</div>
                    <div class="table--data cell-space txt-uppercase">total</div>
                </div> -->
                      <template v-if="showFantasyTeam">
                      <div
                        v-for="player in sortedRoster"
                        :key="player.id"
                        class="mt-1"
                      >
                        <live-players-score-component
                          key="player.id"
                          :player="player"
                          :isPlayer="false"
                          :week="player.week"
                          :team_two_id="player.fantasy_team_id"
                        />
                      </div>
                    </template>
                    <template v-else>
                      <div>
                        <p>Hidden until the 1st Playoff Game Starts</p>
                      </div>
                    </template>
<!--                 <live-players-score-component
                    :key="player.id"
                    :player="player"
                    :isPlayer="false"
                    :week="week"
                    :team_two_id="team_two_id"
                /> -->
<!--                 <div class="table-data--container" v-for="player in seasonData.fantasy_team_details.fantasy_team_roster">
                    <div class="table--data cell-space b-top b-right cell-pos">{{player.fantasy_player.position}}</div>
                    <div :style="{ 'background-color': '#'+player.fantasy_player.team.primary_color+'','color': '#'+player.fantasy_player.team.secondary_color+'' }" class="table--data new cell-space b-top b-right">{{player.fantasy_player.name}}, {{player.fantasy_player.team.key}}</div>
                    <div :style="{ 'background-color': '#'+offense.primary_color+'','color': '#'+offense.secondary_color+'' }" class="table--data cell-space b-top b-right">{{offense.full_name}}</div>
      					   <div class="table--data cell-space b-top b-right">
      					     <p class="team_status"><player-individual-game-progress :player="player"></player-individual-game-progress></p>

					         </div>
                    <div class="table--data cell-space b-top b-right">{{player.statistics}}</div>

                    <div class="table--data cell-space b-top">{{player.fantasy_player.player_current_week_fantasy_points_acme}}</div>
                </div> -->

                <div class="table-data--container table-data--bottom">
                    <div class="table--data cell-space txt-right b-top b-right">TDS</div>
                    <div class="table--data cell-space font-16 font-bold b-top b-right">{{totalItem}}+{{seasonData.prev_tds}}={{seasonData.prev_tds + totalItem}}</div>
                    <div class="table--data cell-space txt-right b-top b-right">Week Total</div>
                    <div class="table--data cell-space b-top b-right">&nbsp;</div>
                    <div class="table--data cell-space font-16 font-bold b-top">{{seasonData.total_home_acme_points | twoDigits}}</div>
                </div>
            </div>
            <div class="table-view--footer">
                <div class="table-result--container">
                    <div class="table--result">
                        <div class="table-footer--data b-bottom cell-space b-right b-left txt-right">Previous Total</div>
                        <div class="table-footer--data b-bottom cell-space b-right">{{seasonData.prev_total | twoDigits}}</div>
                    </div>
                    <div class="table--result">
                        <div class="table-footer--data b-bottom cell-space b-right b-left txt-right">Grand Total</div>
                        <div class="table-footer--data font-16 cell-space font-bold b-bottom b-right">{{ grandTotal | twoDigits }}</div>
                    </div>
                </div>
            </div>
        </div>
	</b-col>
</template>


<style>

.no-table-margin table {
	margin-bottom: 0rem;
}

.player-table{
	border-bottom: 1px solid #e2e4e6;
	height: 75px;
}
.bg-success {
  transition: all 0.1s ease-out;

}
.bg-danger {
 transition: all 0.1s ease-out;

}
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
.team_status{

 width: 100% !important;
  color:#000;
}

.fa-plus-square{color:red}

</style>

<style>

	.table-view{max-width: 100%; font-family: "Arial", "sans-serif";    line-height: 100%; }
	.table-view-head div{font-size:16px;}
	.table-view-head{display: flex; align-items: center;}
	.table-head--left{width:calc((100% / 3) - 8px); }
	.table-head--right, .table--data {width:calc(100% / 1); }
	.cell-space{padding:8px 5px; }
	.b-top{border-top:1px solid #000;}
	.b-bottom{border-bottom:1px solid #000;}
	.b-left{border-left:1px solid #000;}
	.b-right{border-right:1px solid #000;}
	.table-view--content{border:1px solid #000;}
	.table-data--container{
		/*display: flex;align-items: stretch;*/
		display: flex;
		  flex-direction: row;
		  height: 100%;
		  justify-content: center;
	}
	.txt-uppercase{text-transform: uppercase;}
	.brown-bg{background-color:#993400; }
	.blue-bg{background-color:#0166cc; }
	.red-bg{background-color:#ff0000; }
	.black-text{color:#000; }
	.white-text{color:#fff; }
	.yellow-text{color:#FBD200; }
	.blue-text{color:#0166cc; }
	.table-data--bottom{}
	.font-16{font-size:16px; }
	.font-bold{font-weight: 600;}
	.txt-left{text-align:left;}
	.txt-right{text-align: right;}
	.table--result{display: flex; align-items: center; justify-content: flex-end;}
	.table-footer--data{width:calc(100% / 2);}
	.table-result--container{width: calc((100% - -1px) / 2);}
	.table-view--footer{display: flex; align-items: center; justify-content: flex-end;}
	.cell-pos {max-width:50px;}
</style>

<script>

export default {
	props:{
      seasonData: { type: Object, required: false },
      place: { type: Number, required: true },
    },
    watch: {
    },
    computed: {
      sortedRoster() {
        var sortOrder = ['TQB','RB','WR','TE','K','DEF','ST'];   // Declare a array that defines the order of the elements to be sorted.
        return this.seasonData.fantasy_team_details.fantasy_team_roster.sort(
            function(a, b){                              // Pass a function to the sort that takes 2 elements to compare
                if(a.position == b.position){                    // If the elements both have the same `position`,
                    return 0;
                }else{                                   // Otherwise,
                    return sortOrder.indexOf(a.position) - sortOrder.indexOf(b.position); // Substract indexes, If element `a` comes first in the array, the returned value will be negative, resulting in it being sorted before `b`, and vice versa.
                }
            }
        );
        //return this.seasonData.fantasy_team_details.fantasy_team_roster
      },
      showFantasyTeam() {
        // If we already have the state variable set, then show teams without anymore logic processing
        if(this.$store.state.playoffsShowAllFantasyTeams)
          return true;

        console.log('proceeding showFantasyTeam()')

        // If it's the user's team, show it always.
        if(this.seasonData.fantasy_team_details.user_id == this.spark.userId)
          return true;

        // Look if any games started and dispatch the state.
        const found = this.seasonData.fantasy_team_details.fantasy_team_roster.find(element => {
            if(element.fantasy_player.team_game)
              if(element.fantasy_player.team_game.score)
                return element.fantasy_player.team_game.score.has_started > 0
        });

        if(found)
          this.$store.dispatch('playoffsShowAllFantasyTeams',{show: true});

        return found;
      },
        grandTotal() {
            return parseFloat(this.seasonData.total_home_acme_points + this.seasonData.prev_total)
        },
        // TODO: Sum TD's easier
        totalItem(){
			let sum = 0;

			let teamData =  this.seasonData.fantasy_team_details.fantasy_team_roster ? this.seasonData.fantasy_team_details.fantasy_team_roster : [];
            if(teamData.length > 0){
                teamData.forEach(function(item) {
                  if(item.fantasy_player.position != 'DEF')
                  {
                    if(item.fantasy_player.player_game.length > 0)
                    {
                      sum += item.fantasy_player.player_game[0].receiving_touchdowns;
                      sum += item.fantasy_player.player_game[0].rushing_touchdowns;
                      sum += item.fantasy_player.player_game[0].passing_touchdowns;
                    }
                  }
                  if(item.fantasy_player.position == 'DEF')
                  {
                    if(item.fantasy_player.fantasy_defense_game.length > 0)
                    {
                      sum += item.fantasy_player.fantasy_defense_game[0].interception_return_touchdowns;
                      sum += item.fantasy_player.fantasy_defense_game[0].fumble_return_touchdowns;
                    }
                  }
                });
            }

			return parseFloat(sum);
		},
    },
	methods: {

	},
    filters: {
        twoDigits(value) {
            return Math.round(value * 100) / 100
        },
        ordinalSuffix(i) {
            var j = i % 10,
                k = i % 100;
            if (j == 1 && k != 11) {
                return i + "st";
            }
            if (j == 2 && k != 12) {
                return i + "nd";
            }
            if (j == 3 && k != 13) {
                return i + "rd";
            }
            return i + "th";
        }
    },
}

</script>
