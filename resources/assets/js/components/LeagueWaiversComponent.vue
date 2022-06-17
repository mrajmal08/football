<template>
    <div class="container" >
        <snackbar />
        <div class="row pb-3 ">
            <div class="col">
                <h5>id</h5>
            </div>
            <div class="col">
                <h5>Week</h5>
            </div>
            <div class="col">
                <h5>Submitted</h5>
            </div>
            <div class="col">
                <h5>Coach Rank</h5>
            </div>
            <div class="col">
                <h5>Fantasy Team</h5>
            </div>
            <div class="col">
                <h5>Add</h5>
            </div>
            <div class="col">
                <h5>Conditional Drop</h5>
            </div>
            <div class="col-2">
                <h5>Action</h5>
            </div>
        </div>
        <div v-for="request in waivers">
            <div class="row pb-2">
                <div class="col">
                    {{request.id}}
                </div>
                <div class="col">
                    {{request.week}}
                </div>
                <div class="col">
                    {{ request.updated_at | moment }}
                </div>
                <div class="col">
                    {{request.fantasy_team.league_team_ranking.overall_coach_rank}}
                </div>
                <div class="col">
                    {{request.fantasy_team.name}}
                </div>
                <div class="col">
                    {{request.fantacy_player.name}} ({{request.fantacy_player.team}}, {{request.fantacy_player.position}})
                </div>
                <div class="col">
                    <span v-if="request.conditional_drop">Drop: {{request.drop_fantasy_player.name}} ({{request.drop_fantasy_player.team}}, {{request.drop_fantasy_player.position}})</span>
                </div>
                <div class="col-2">
                    <div v-if="request.approved">
                        Approved
                    </div>
                    <div v-else-if="request.rejected">
                        Rejected
                    </div>
                    <div v-else-if="!request.active">
                        Cancelled by user
                    </div>
                    <div v-else>
                        <b-button
                                size="small"
                                disabled="true"
                                v-if="request.fantacy_player.fantasy_team_owned_by.fantasy_team"
                        >Owned by {{request.fantacy_player.fantasy_team_owned_by.owner_name}}</b-button>
                        <b-button
                                size="small"
                                @click="playerTransaction(null, 7, null, request.id)"
                                v-else
                        ><b-icon
                                icon="person-plus"
                                aria-hidden="true"
                        ></b-icon> Approve</b-button>
                        <button class="btn btn-danger" @click="playerTransaction(null, 6, null, request.id)">Reject</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    var moment = require('moment-timezone');

    export default {

        props:{


        },
        filters: {
            moment: function (date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            }
        },
        data() {
            return {
                page: 'league-draft',
                waivers: {}
            }
        },

        created() {
            // console.log('created');
            this.getWaivers();
        },

        methods:{

            // 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject, 7=claim approve, 8=active to bench, 9=bench to active
            playerTransaction(player_id, transaction_id, fantasy_team_id = null, transaction_locator = null) {
                axios
                    .post("/players/player-transaction", {
                        player_id: player_id,
                        transaction_id: transaction_id,
                        fantasy_team_id: fantasy_team_id,
                        transaction_locator: transaction_locator,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            console.log("success player transacton");

                            this.$store.dispatch("showSnackBarSuccess", {
                                message: response.data.message,
                            });

                            window.location.reload();
                            // Reload current players table to show latest buttons
                            // this.getPlayers();
                        } else {
                            console.log("fail player transaction");
                            this.$store.dispatch("showSnackBarFailure", {
                                message: response.data.message,
                            });
                            window.location.reload();
                        }
                    })
                    .catch((error) => {});
            },

            getWaivers() {
                // this.loading = true;
                axios
                    .get("/league-waivers")
                    .then((response) => {
                        this.waivers = response.data;
                        // this.loading = false;
                    })
                    .catch((error) => {});
            },
        }

    }
</script>
