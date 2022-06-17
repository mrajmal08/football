<spark-update-league-details :user="user" inline-template resource="{{ route('league.details') }}">
    <div class="card card-default" v-if="user">
        <div class="card-header">{{__('League')}}</div>
		<div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.updated">
                {{__('League details has been updated!')}}
            </div>
 <div class="alert alert-success" v-if="form.removed">
                {{__('All players has been removed from the League')}}
            </div>
            <form role="form">
                <!-- League Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('League Name')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- League Invite URL -->
                <div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right">{{__('League Invite URL')}}</label>
                    <div class="col-md-4">@{{ form.invite_code }}</div>
                </div>
				
				<!-- League Number of Teams -->
                <!--<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Number of Teams')}}</label>

                    <div class="col-md-4">
						<select v-model="form.number_of_teams" class="form-control">
						  <option disabled value="">Please select one</option>
						  <option>8</option>
						  <option>12</option>
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('number_of_teams')">
                            @{{ form.errors.get('number_of_teams') }}
                        </span>
                    </div>
                </div>
					<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Turn on Team QB')}}</label>

                    <div class="col-md-4">
						<select v-model="form.allow_team_qb " class="form-control" :class="{'is-invalid': form.errors.has('allow_team_qb ')}">
						 <option disabled value="">Please select one</option>
						 <option value="1">Yes</option>
						 <option value="0">No</option>
						
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('allow_team_qb ')">
                            @{{ form.errors.get('allow_team_qb ') }}
                        </span>
                    </div>
                </div>-->
				<div v-if="form.override_system">
					<!-- League Season-->
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">{{__('Season')}}</label>

						<div class="col-md-4">
							<select v-model="form.season" class="form-control" :class="{'is-invalid': form.errors.has('season')}">
							  <option disabled value="">Please select one</option>
							  <option>{{date("Y",strtotime("-1 year"))}}</option>
							  <option>{{ date('Y') }}</option>
							</select>
							<span class="invalid-feedback" v-show="form.errors.has('season')">
								@{{ form.errors.get('season') }}
							</span>
						</div>
					</div>

					
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">{{__('Season Type')}}</label>

						<div class="col-md-4">
							<select v-model="form.season_type" class="form-control" :class="{'is-invalid': form.errors.has('season_type')}">
							 <option  value="">Please select one</option>
							 <option value="1">REG</option>
							 <option value="2">PRE</option>
							 <option value="3">POST</option>
							</select>
							<span class="invalid-feedback" v-show="form.errors.has('season_type')">
								@{{ form.errors.get('season_type') }}
							</span>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">{{__('Week')}}</label>

						<div class="col-md-4">
							<select v-model="form.week" class="form-control" :class="{'is-invalid': form.errors.has('week')}">
							  <option disabled value="">Please select one</option>
							  @for($i=1;$i<19;$i++)
							   <option >{{$i}}</option>
								@endfor
							</select>
							<span class="invalid-feedback" v-show="form.errors.has('week')">
								@{{ form.errors.get('week') }}
							</span>
						</div>
					</div>
				</div>
				<div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Online Draft')}}</label>

                    <div class="col-md-6">
                       <select v-model="form.online_draft" class="form-control" :class="{'is-invalid': form.errors.has('online_draft ')}">
						 <option disabled value="">Please select one</option>
						 <option value="1">True</option>
						 <option value="0">False</option>
						
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('online_draft ')">
                            @{{ form.errors.get('online_draft ') }}
                        </span>
                    </div>
                </div>
				
				<div class="form-group row" v-if="form.online_draft == 1">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Draft Date')}}</label>

                    <div class="col-md-4">
                      @if(config('app.env') == 'production')
                        <datetime type="datetime" input-id="draft_date"  use12-hour :input-class="'form-control'"  v-model="form.draft_date" 
                        min-datetime="{{date('c',strtotime('+20 min'))}}" max-datetime="2021-09-10T20:01:00+00:00" :placeholder="'Select Date & Time'"></datetime>
                      @else
                        <datetime type="datetime" input-id="draft_date"  use12-hour :input-class="'form-control'"  v-model="form.draft_date" 
                        min-datetime="{{date('c',strtotime('+5 min'))}}" max-datetime="2021-09-10T20:01:00+00:00" :placeholder="'Select Date & Time'"></datetime>
                      @endif
						<span class="invalid-feedback" v-show="form.errors.has('draft_date')">
							@{{ form.errors.get('draft_date') }}
						</span>
                    </div>
					
                </div>
				
				<div class="form-group row" v-if="form.online_draft == 1">
                    <label class="col-md-4 col-form-label text-md-right">{{__(' Draft Max Time')}}</label>

                    <div class="col-md-6">
                       <select v-model="form.draft_pick_max_time" class="form-control" :class="{'is-invalid': form.errors.has('draft_pick_max_time ')}">
						 <option  value="30">30</option>						 
						 <option value="60">60</option>
						 <option value="90">90</option>
						 <option value="120">120</option>
						 <option value="150">150</option>
						 <option value="180">180</option>
						</select>
                        <span class="invalid-feedback" v-show="form.errors.has('draft_pick_max_time ')">
                            @{{ form.errors.get('draft_pick_max_time ') }}
                        </span>
                    </div>
                </div>
				<div class="form-group row" v-if="form.online_draft == 0">
                    <label class="col-md-4 col-form-label text-md-right"></label>

                    <div class="col-md-4">
						<a href="#league-team" aria-controls="league-team" role="tab" data-toggle="tab">
							Input Fantasy Team Rosters
						</a>
                    </div>
					
                </div>
				
				
				<div class="form-group row" v-if="form.online_draft == 0">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Start League Season')}}</label>

                    <div class="col-md-4" >					
						<button type="submit" class="btn btn-primary" 
                                @click.prevent="startleaque" 
                                :disabled="form.busy">

                            {{__('Start League')}}
                        </button>
                    </div>
					 <!--<div class="col-md-4" v-if="user.fantasy_team_has_fantasy_player != 12">					
						<button type="submit" class="btn btn-primary" disabled >

                            {{__('Start League')}}
                        </button>
                    </div>-->
                </div>
							
				
				<!-- League Number of Teams Registered -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Number of Teams Registered')}}</label>
                    <div class="col-md-4">@{{ form.number_of_teams_registered }}</div>
                </div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right">{{__('Team Names')}}</label>
					<ul id="v-for-object" style="list-style: none;padding-left: 15px;">
					  <li v-for="value in form.league_teams"  >
					  
						@{{ value.name }} 
						
						
						 
						<a :href="'/impersonate/take/'+ value.user_id" v-if="value.user_id!= form.id">login</a>
					  </li>
					</ul>
				</div>
				
				
				<div class="form-group row">
					<label class="col-md-4 col-form-label text-md-right">{{__('Select Co Commissioner')}}</label>
					<div class="col-md-4">
							<select v-model="form.is_co_commissioner" class="form-control" :class="{'is-invalid': form.errors.has('is_co_commissioner')}"   >
							 <option  value="">Please select one</option>
							 <option 
                  v-for="value in form.league_teams" 
                  v-bind:value="value.user_id" 
                  v-if="value.user_id!= form.league_owner"
                  :selected="value.user_id == form.co_commissioner"
                  v-bind:disabled="form.isReadOnly"
                >
									@{{ value.name }}
								  </option>
							</select>
							<span class="invalid-feedback" v-show="form.errors.has('is_co_commissioner')">
								@{{ form.errors.get('is_co_commissioner') }}
							</span>
						</div>
				</div>
				
				<!-- Update Button -->
               <!--  <div class="form-group ">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="clearteam"
                                :disabled="form.busy">

                            {{__('Clear Teams')}}
                        </button>
                    </div>
                </div>
				-->
				
                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
	</div>
</spark-update-league-details>
