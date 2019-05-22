

    <ul class="navbar-nav" >

        <li class="{{ Request::is('home') ? 'nav-item active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}"><span class="active-item-here "></span>
                <img src="{{asset('images/svg/home.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                <span style="vertical-align: middle;" class="lato-bold">TABLEAU DE BORD</span>
            </a>
        </li>
        @if(Auth::user()->organisation_id == 1)

            <li class="
                @if( preg_match('(demande|createDemande|indexDemande)', Route::currentRouteName()) === 1 ))
                    nav-item active
                    @else
                    nav-item
                    @endif
                    ">
                <a class="nav-link" href="{{ route('indexDemande') }}"><span class="active-item-here"></span>
                    <img src="{{asset('images/svg/writing.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                    <span style="vertical-align: middle;" class="lato-bold">DEMANDES</span>
                </a>
            </li>

            <li class="
                     @if( preg_match('(convention|createConvention|indexConvention)', Route::currentRouteName()) === 1 ))
                    nav-item active
                    @else
                    nav-item
                    @endif">
                <a class="nav-link" href="{{ route('indexConvention') }}"><span class="active-item-here"></span>
                    <img src="{{asset('images/svg/resume.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                    <span style="vertical-align: middle;" class="lato-bold">CONVENTIONS</span></a>
            </li>

            <li class="
            @if( preg_match('(SuiviVersement|indexSuiviVersement)', Route::currentRouteName()) === 1 ))
                    nav-item active
                    @else
                    nav-item
                    @endif">
                <a class="nav-link" href="{{ route('indexSuiviVersement') }}"><span class="active-item-here"></span>
                    <img src="{{asset('images/svg/coin.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                    <span style="vertical-align: middle;" class="lato-bold">SUIVI DE VERSEMENT</span></a>
            </li>

            <li class="
            @if( preg_match('(indexAppelOffre|appel_offre)', Route::currentRouteName()) === 1 ))
                    nav-item active
                    @else
                    nav-item
                    @endif

                    ">
                <a class="nav-link" href="{{ route('indexAppelOffre') }}"><span class="active-item-here"></span>
                    <img src="{{asset('images/svg/report.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                    <span style="vertical-align: middle;" class="lato-bold">APPELS D'OFFRES</span></a>
            </li>
        @endif

        <li class="
@if( preg_match('(indexProjet|projet)', Route::currentRouteName()) === 1 ))
                    nav-item active
                    @else
                nav-item
@endif

                ">
            <a class="nav-link" href="{{ route('indexProjet') }}"><span class="active-item-here"></span>
                <img src="{{asset('images/svg/engineer.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                <span style="vertical-align: middle;" class="lato-bold">PROJETS</span>
            </a>
        </li>


        <li class="
            @if( preg_match('(statistics|indexStatistics)', Route::currentRouteName()) === 1 ))
                                nav-item active
                                @else
                            nav-item
            @endif
            ">
            <a class="nav-link" href="{{ route('indexStatistics') }}"><span class="active-item-here"></span>
                <img src="{{asset('images/svg/statistics.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                <span style="vertical-align: middle;" class="lato-bold">STATISTIQUES</span></a>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="cartographie"><span class="active-item-here"></span>
                <img src="{{asset('images/svg/layers.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                <span style="vertical-align: middle;" class="lato-bold">CARTOGRAPHIE</span></a>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="#"><span class="active-item-here"></span>
                <img src="{{asset('images/svg/settings-gears.svg')}}" style="width: 1.2em;margin-right: 5px;" />
                <span style="vertical-align: middle;" class="lato-bold">PARAMETRES</span></a>
        </li>
    </ul>


