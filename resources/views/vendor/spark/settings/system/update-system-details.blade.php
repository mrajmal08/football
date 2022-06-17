<spark-update-system-details :user="user" inline-template resource="{{ route('system.settings') }}">
    <div class="card card-default" v-if="user">
        <div class="card-header">{{__('System Settings')}}</div>
		<div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('System settings details has been updated!')}}
            </div>

			 <div class="alert alert-success" v-if="form.message">
               
				  @{{ form.message}}
            </div>
			
		<div class="alert alert-danger" v-if="form.error">
               
				  @{{ form.error}}
            </div>
            <form role="form">
               
				<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Week')}}</label>

                    <div class="col-md-4">
						<select v-model="form.sys_week" class="form-control btn-secondary" :class="{'is-invalid': form.errors.has('sys_week')}">
						  <option disabled value="">Please select one</option>
						  @for($i=1;$i<23;$i++)
						   <option >{{$i}}</option>
							@endfor
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('sys_week')">
                            @{{ form.errors.get('sys_week') }}
                        </span>
                    </div>
                </div>
				<!-- League Season-->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Season')}}</label>

                    <div class="col-md-4">
						<select v-model="form.sys_season" class="form-control btn-secondary" :class="{'is-invalid': form.errors.has('sys_season')}">
						  <option disabled value="">Please select one</option>
						  <option>{{date("Y",strtotime("-1 year"))}}</option>
						  <option>{{ date('Y') }}</option>
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('sys_season')">
                            @{{ form.errors.get('sys_season') }}
                        </span>
                    </div>
                </div>

				
				<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Season Type')}}</label>

                    <div class="col-md-4">
						<select v-model="form.sys_season_type" class="form-control btn-secondary" :class="{'is-invalid': form.errors.has('sys_season_type')}">
						 <option disabled value="">Please select one</option>
						 <option value="1">REG</option>
						 <option value="2">PRE</option>
						 <option value="3">POST</option>
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('sys_season_type')">
                            @{{ form.errors.get('sys_season_type') }}
                        </span>
                    </div>
                </div>
				
				
				
				<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Waiver Period Enabled')}}</label>

                    <div class="col-md-4">
						<select v-model="form.sys_waiver_period_enabled" class="form-control btn-secondary" :class="{'is-invalid': form.errors.has('sys_waiver_period_enabled')}">
						 <option disabled value="">Please select one</option>
						 <option value="1">TRUE</option>
						 <option value="0">FALSE</option>
						 
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('sys_waiver_period_enabled')">
                            @{{ form.errors.get('sys_waiver_period_enabled') }}
                        </span>
                    </div>
                </div>
				
				
				<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Display Ads')}}</label>

                    <div class="col-md-4">
						<select v-model="form.sys_display_ads" class="form-control btn-secondary" :class="{'is-invalid': form.errors.has('sys_display_ads')}">
						 <option disabled value="">Please select one</option>
						 <option value="1">TRUE</option>
						 <option value="0">FALSE</option>
						 
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('sys_display_ads')">
                            @{{ form.errors.get('sys_display_ads') }}
                        </span>
                    </div>
                </div>
				
				
				<!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="sysupdate"
                                :disabled="form.busy">

                            {{__('Update')}}
                        </button>
                    </div>
                </div>
				
						 </div>

						 <div class="card-header">{{__('Update Console Commands')}}</div>
						 <div class="card-body">
				
				<br/>  
				<!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update_schedules"
                                :disabled="form.busy">

                            {{__('Update Schedules')}}
                        </button>
                    </div>
                </div>
				
				
				<br/>
				<!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update_boxscores_finished_games"
                                :disabled="form.busy">

                            {{__('Update BoxScores Finished Games')}}
                        </button>
                    </div>
                </div>
				
				<br/>
				
				<!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update_box_scores"
                                :disabled="form.busy">

                            {{__('Update BoxScores')}}
                        </button>
                    </div>
                </div>
				<br/>
				
				<!-- Update Button -->
                <div class="form-group row mb-0" v-if="form.sys_season_type==3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update_league_postseason_scores"
                                :disabled="form.busy">

                            {{__('Update League Postseason Scores')}}
                        </button>
                    </div>
                </div>
				
				
				
            </form>
        </div>
	</div>
</spark-update-system-details>