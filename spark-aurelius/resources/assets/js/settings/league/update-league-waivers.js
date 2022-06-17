module.exports = {
    props: ['user'],
    /**
     * The component's data.
     */
    data() {
        return {
            form: $.extend(true, new SparkForm({
                    name: '',
                    number_of_teams: '',
                    season: '',
                    season_type: '',
                    week: '',
                    draft_date: '',
                    override_system : '',
                    allow_team_qb :'',
                    is_co_commissioner :'',
                    league_owner :'',
                    isReadOnly :'',
                    id :'',
                    online_draft: '',
                    fantasy_player:'',
                }),
                Spark.forms.updateLeagueDetails)
        };
    },

    /**
     * Bootstrap the component.
     */

    created(){

        this.$store.dispatch('offlineFantasyDraftPlayerListAvailable');
        //console.log('------------------'+this.$store.getters.getFantasyPlayers(1));

    },


    mounted() {
        this.form.name 							= this.user.league_name;
        this.form.number_of_teams 				= 12;
        this.form.invite_code 					= this.user.invite_code;
        this.form.number_of_teams_registered	= this.user.teams_count;
        this.form.league_teams					= this.user.league_teams;
        this.form.season						= this.user.season;
        this.form.season_type					= this.user.season_type;
        this.form.week							= this.user.week;
        this.form.draft_date					= this.user.draft_date;
        this.form.override_system 				= this.user.override_system ;
        this.form.allow_team_qb 				= 1 ;
        this.form.is_co_commissioner 			= this.user.is_co_commissioner ;
        this.form.isReadOnly 					= this.user.isReadOnly ;
        this.form.league_owner 					= this.user.league_owner ;
        this.form.id 							= this.user.id ;
        this.form.online_draft					= this.user.online_draft ;
    },

    methods: {
        /**
         * Update the league information.
         */
        update() {
            Spark.put('/league/update', this.form)
                .then(() => {
                    this.form.updated 							= true;
                    this.form.removed 						    = false;
                    Bus.$emit('updateUser');
                });
        },

        clearteam() {
            Spark.post('/league/clearteam', this.form)
                .then(() => {
                    this.form.removed 							= true;
                    this.form.updated 							= false;
                });
        },
    }
};
