<ul class="navbar-nav">
    <li class="{{ Request::is('home') ? 'nav-item active' : '' }}">
        <a class="nav-link" href="/home"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/home.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Tableau de Bord</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/engineer.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Projets</span>
        </a>
    </li>

    <li class="{{ Request::is('demandes') ? 'nav-item active' : '' }}">
        <a class="nav-link" href="/demandes"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/writing.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Demandes</span>
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/resume.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Conventions</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/report.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Aappels D'offres</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/coin.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Suivi de Versement</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/statistics.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Statistiques</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/layers.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Cartographie</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"><span class="active-item-here"></span>
            <img src="{{asset('images/svg/settings-gears.svg')}}" style="width: 1.2em;margin-right: 5px;" />
            <span style="vertical-align: middle;">Parametres</span></a>
    </li>
</ul>
