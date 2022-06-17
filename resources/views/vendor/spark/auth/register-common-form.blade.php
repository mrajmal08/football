<form role="form">

    @if (Spark::usesTeams() && Spark::onlyTeamPlans())
        <!-- Team Name -->
        <div class="form-group row" v-if=" ! invitation">
            <label class="col-md-4 col-form-label text-md-right">{{ __('teams.team_name') }}</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="team" v-model="registerForm.team" :class="{'is-invalid': registerForm.errors.has('team')}" autofocus>

                <span class="invalid-feedback" v-show="registerForm.errors.has('team')">
                    @{{ registerForm.errors.get('team') }}
                </span>
            </div>
        </div>

        @if (Spark::teamsIdentifiedByPath())
            <!-- Team Slug (Only Shown When Using Paths For Teams) -->
            <div class="form-group row" v-if=" ! invitation">
                <label class="col-md-4 col-form-label text-md-right">{{ __('teams.team_slug') }}</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="team_slug" v-model="registerForm.team_slug" :class="{'is-invalid': registerForm.errors.has('team_slug')}" autofocus>

                    <small class="form-text text-muted" v-show="! registerForm.errors.has('team_slug')">
                        {{__('teams.slug_input_explanation')}}
                    </small>

                    <span class="invalid-feedback" v-show="registerForm.errors.has('team_slug')">
                        @{{ registerForm.errors.get('team_slug') }}
                    </span>
                </div>
            </div>
        @endif
    @endif

    <!-- Name -->
	@if($inviteCode !='' && isset($league))
		<div class="alert alert-primary" role="alert">
		  You are joining the <strong>{{$league['name']}}</strong>.
		</div>
	@endif
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('Name')}}</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="name" v-model="registerForm.name" :class="{'is-invalid': registerForm.errors.has('name')}" autofocus>

            <span class="invalid-feedback" v-show="registerForm.errors.has('name')">
                @{{ registerForm.errors.get('name') }}
            </span>
        </div>
    </div>
	
	<!-- Team Name -->
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('Team Name')}}</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="team_name" v-model="registerForm.team_name" :class="{'is-invalid': registerForm.errors.has('team_name')}" autofocus>

            <span class="invalid-feedback" v-show="registerForm.errors.has('team_name')">
                @{{ registerForm.errors.get('team_name') }}
            </span>
        </div>
    </div>

	
	<!-- Short Name -->
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('Short Name')}}</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="short_name" v-model="registerForm.short_name" :class="{'is-invalid': registerForm.errors.has('short_name')}" autofocus>

            <span class="invalid-feedback" v-show="registerForm.errors.has('short_name')">
                @{{ registerForm.errors.get('short_name') }}
            </span>
        </div>
    </div>
    <!-- E-Mail Address -->
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address')}}</label>

        <div class="col-md-6">
            <input type="email" class="form-control" name="email" v-model="registerForm.email" :class="{'is-invalid': registerForm.errors.has('email')}">

            <span class="invalid-feedback" v-show="registerForm.errors.has('email')">
                @{{ registerForm.errors.get('email') }}
            </span>
        </div>
    </div>
	
	 <!-- League Name -->
	@if($inviteCode =='')
		<div class="form-group row">
			<label class="col-md-4 col-form-label text-md-right">{{__('League Name')}}</label>

			<div class="col-md-6">
				<input type="text" class="form-control" name="league_name" v-model="registerForm.league_name" :class="{'is-invalid': registerForm.errors.has('league_name')}" autofocus>

				<span class="invalid-feedback" v-show="registerForm.errors.has('league_name')">
					@{{ registerForm.errors.get('league_name') }}
				</span>
			</div>
		</div>
	@endif
    <!-- Password -->
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('Password')}}</label>

        <div class="col-md-6">
            <input type="password" class="form-control" name="password" v-model="registerForm.password" :class="{'is-invalid': registerForm.errors.has('password')}">

            <span class="invalid-feedback" v-show="registerForm.errors.has('password')">
                @{{ registerForm.errors.get('password') }}
            </span>
        </div>
    </div>

    <!-- Password Confirmation -->
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">{{__('Confirm Password')}}</label>

        <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation" v-model="registerForm.password_confirmation" :class="{'is-invalid': registerForm.errors.has('password_confirmation')}">

            <span class="invalid-feedback" v-show="registerForm.errors.has('password_confirmation')">
                @{{ registerForm.errors.get('password_confirmation') }}
            </span>
        </div>
    </div>

    <!-- Terms And Conditions -->
    <div v-if=" ! selectedPlan || selectedPlan.price == 0">
        <div class="form-group row" :class="{'is-invalid': registerForm.errors.has('terms')}">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" v-model="registerForm.terms">
                        {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="/terms" target="_blank">', 'linkClose' => '</a>']) !!}
                    </label>
					
					<input type="hidden" name="invite_code" value="{{$inviteCode}}">
					
                    <span class="invalid-feedback" v-show="registerForm.errors.has('terms')">
                        <strong>@{{ registerForm.errors.get('terms') }}</strong>
                    </span>
                </div>
            </div>
        </div>
		
		
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button class="btn btn-primary" @click.prevent="register" :disabled="registerForm.busy">
                    <span v-if="registerForm.busy">
                        <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Registering')}}
                    </span>

                    <span v-else>
                        <i class="fa fa-btn fa-check-circle"></i> {{__('Register')}}
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
