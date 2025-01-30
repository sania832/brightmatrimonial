		<div class="app-sidebar sidebar-shadow">
			<div class="scrollbar-sidebar">
				<div class="app-sidebar__inner">
					<ul class="vertical-nav-menu">
						<li class="app-sidebar__heading">Menu</li>
						<li id="nav-dashboard">
							<li><a href="{{ route('home') }}"> <i class="metismenu-icon pe-7s-graph2"></i>{{trans('sidebar.dashboard')}}</a></li>
						</li>
						<li class="app-sidebar__heading">{{trans('sidebar.management')}}</li>
						<li><a href="{{ route('questions.index') }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.questions')}}</a></li>

						<li class="app-sidebar__heading">
							<a href="javascript:void(0);"> <i class="metismenu-icon pe-7s-graph"></i> Personal<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul>
								{{-- <li><a href="{{ route('optionPage', ['sexual_orientation']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.sexual_orientation')}}</a></li> --}}
								<li><a href="{{ route('optionPage', ['religion']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.religion')}}</a></li>
								<li><a href="{{ route('optionPage', ['community']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.community')}}</a></li>
								<li><a href="{{ route('optionPage', ['cast']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.cast')}}</a></li>
								<li><a href="{{ route('optionPage', ['sub_cast']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.sub_cast')}}</a></li>
								<li><a href="{{ route('optionPage', ['height']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.height')}}</a></li>
								<li><a href="{{ route('optionPage', ['diet']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.diet')}}</a></li>
								<li><a href="{{ route('optionPage', ['hobbies']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.hobbies')}}</a></li>
								<li><a href="{{ route('optionPage', ['interest']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.interest')}}</a></li>
								{{-- <li><a href="{{ route('optionPage', ['blood_group']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.blood_group')}}</a></li> --}}
								{{-- <li><a href="{{ route('optionPage', ['relation_type']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.relation_type')}}</a></li> --}}
								<li><a href="{{ route('optionPage', ['marital_status']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.marital_status')}}</a></li>
								<li><a href="{{ route('optionPage', ['family_type']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.family_type')}}</a></li>
								<li><a href="{{ route('optionPage', ['family_status']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.family_status')}}</a></li>
								<li><a href="{{ route('optionPage', ['gotra']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.gotra')}}</a></li>
								<li><a href="{{ route('languages.index') }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.mother_tongue')}}</a></li>
							</ul>
						</li>

						<li class="app-sidebar__heading">
							<a href="javascript:void(0);"> <i class="metismenu-icon pe-7s-graph"></i> Professional<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul>
								<li><a href="{{ route('optionPage', ['father_occupation']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.father_occupation')}}</a></li>
								<li><a href="{{ route('optionPage', ['mother_occupation']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.mother_occupation')}}</a></li>
								<!--<li><a href="{{ route('optionPage', ['ug_digree']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.ug_digree')}}</a></li>-->
								<!--<li><a href="{{ route('optionPage', ['pg_digree']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.pg_digree')}}</a></li>-->
								<li><a href="{{ route('optionPage', ['occupation']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.occupation')}}</a></li>
								<li><a href="{{ route('optionPage', ['highest_qualification']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.highest_qualification')}}</a></li>
								<li><a href="{{ route('optionPage', ['company_position']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.company_position')}}</a></li>
								<li><a href="{{ route('optionPage', ['working_with']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.working_with')}}</a></li>
								<li><a href="{{ route('optionPage', ['income_year']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.income_year')}}</a></li>
								<li><a href="{{ route('optionPage', ['income_month']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.income_month')}}</a></li>
								
								{{-- <li><a href="{{ route('optionPage', ['challenged']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.challenged')}}</a></li> --}}
							</ul>
						</li>

						<li class="app-sidebar__heading">
							<a href="javascript:void(0);"> <i class="metismenu-icon pe-7s-graph"></i> Favorite<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul>
								<li><a href="{{ route('optionPage', ['favorite_music']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.favorite_music')}}</a></li>
								<li><a href="{{ route('optionPage', ['favorite_books']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.favorite_books')}}</a></li>
								{{-- <li><a href="{{ route('optionPage', ['dress_style']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.dress_style')}}</a></li> --}}
								<!--<li><a href="{{ route('optionPage', ['favorite_movies']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.favorite_movies')}}</a></li>-->
								<li><a href="{{ route('optionPage', ['favorite_sports']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.favorite_sports')}}</a></li>
								<li><a href="{{ route('optionPage', ['cuisine']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.cuisine')}}</a></li>
								<!--<li><a href="{{ route('optionPage', ['tv_shows']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.tv_shows')}}</a></li>-->
							</ul>
						</li>

						<li class="app-sidebar__heading">
							<a href="javascript:void(0);"><i class="metismenu-icon pe-7s-graph"></i> Horoscope<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul>
								<!--<li><a href="{{ route('optionPage', ['sun_sign']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.sun_sign')}}</a></li>-->
								<!--<li><a href="{{ route('optionPage', ['rashi']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.rashi')}}</a></li>-->
								<!--<li><a href="{{ route('optionPage', ['nakshtra']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.nakshtra')}}</a></li>-->
								<li><a href="{{ route('optionPage', ['manglik_dosh']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.manglik_dosh')}}</a></li>
								<li><a href="{{ route('optionPage', ['horoscope_privacy']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.horoscope_privacy')}}</a></li>
							</ul>
						</li>

						{{-- <li class="app-sidebar__heading">
							<a href="javascript:void(0);"> <i class="metismenu-icon pe-7s-graph"></i> Extra<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul> --}}
								{{-- <li><a href="{{ route('optionPage', ['marital_status']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.marital_status')}}</a></li> --}}
								{{-- <li><a href="{{ route('optionPage', ['relation_type']) }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.relation_type')}}</a></li> --}}
								
							{{-- </ul>
						</li> --}}

						<li class="app-sidebar__heading">
							<a href="javascript:void(0);"><i class="metismenu-icon pe-7s-map-2"></i> LOCATION MANAGEMENT<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i></a>
							<ul>
								<li><a class="{{ Request::is('admin/countries*') ? 'mm-active' : '' }}" href="{{URL('/admin/countries')}}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.countries')}}</a></li>
								<li><a class="{{ Request::is('admin/states*') ? 'mm-active' : '' }}" href="{{URL('/admin/states')}}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.states')}}</a></li>
								<li><a class="{{ Request::is('admin/cities*') ? 'mm-active' : '' }}" href="{{URL('/admin/cities')}}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.cities')}}</a></li>
								{{-- <li><a class="{{ Request::is('admin/areas*') ? 'mm-active' : '' }}" href="{{URL('/admin/areas')}}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.areas')}}</a></li> --}}
                            </ul>
						</li>

						<li><a href="{{ route('users.index') }}"> <i class="metismenu-icon pe-7s-graph"></i>{{trans('sidebar.users')}}</a></li>
					</ul>
				</div>
			</div>
		</div>
