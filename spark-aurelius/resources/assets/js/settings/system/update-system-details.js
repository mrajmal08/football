module.exports = {
    props: ['user'],
    /**
     * The component's data.
     */
    data() {
        return {
            form: $.extend(true, new SparkForm({                              
				sys_season: '',
				sys_season_type: '',
				sys_week: '',	
				sys_waiver_period_enabled:'',
				sys_display_ads:'',
				message:'',	
				error:'',	
            }), Spark.forms.updateSystemDetails)
        };
    },

	 /**
     * Bootstrap the component.
     */
    mounted() {
		
		this.form.sys_season						= this.user.sys_season;
		this.form.sys_season_type					= this.user.sys_season_type;
		this.form.sys_week							= this.user.sys_week;
		this.form.sys_waiver_period_enabled			= this.user.sys_waiver_period_enabled;
		this.form.sys_display_ads					= this.user.sys_display_ads;
    },

    methods: {
		/**
         * Update the user's contact information.
         */
        sysupdate() {
            Spark.put('/system/update', this.form)
                .then(() => {
					this.form.error= false;
                    Bus.$emit('updateUser');
                });
        },
		
		  update_schedules() {
            Spark.put('/system/update_schedules', this.form)
                .then(response => {
					
					this.form.successful= false;
					 this.form.message_status= true;
					 this.form.message= response;
                    Bus.$emit('updateUser');
                }).catch(error => {
					this.form.message_status= false;
					this.form.error= true;
					this.form.error=error.message
				
				});
        },
		update_boxscores_finished_games() {
            Spark.put('/system/update_boxscores_finished_games', this.form)
                .then(response => {
					this.form.successful= false;
					this.form.message_status= true;
					this.form.message= response;
                    Bus.$emit('updateUser');
                }).catch(error => {
					this.form.message_status= false;
					this.form.error= true;
					this.form.error=error.message
				
				});
        },
		update_box_scores() {
            Spark.put('/system/update_box_scores', this.form)
                .then(response => {
					this.form.successful= false;
					this.form.message_status= true;
					this.form.message= response;
                    Bus.$emit('updateUser');
                }).catch(error => {
					this.form.message_status= false;
					this.form.error= true;
					this.form.error=error.message;
				
				});
        },
		update_league_postseason_scores() {
            Spark.put('/system/update_league_postseason_scores', this.form)
                .then(response => {
					this.form.successful= false;
					this.form.message_status= true;
					this.form.message= response;
                   // Bus.$emit('updateUser');
                }) .catch(error => {
					this.form.message_status= false;
					this.form.error= true;
					this.form.error=error.message
				
				});
        },
		
		
		
    }
};
