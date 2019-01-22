<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="/"
            ><span class="active-item-here"></span
            ><ion-icon name="home"></ion-icon>
            <span>TABLEAU DE BORD</span></a
        >
    </li>

    <li class="nav-item" >
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><ion-icon name="map"></ion-icon> <span>PROJETS</span></a
        >
    </li>

    <li  class="{{ Request::is('demandes') ? 'nav-item active' : '' }}">
        <a class="nav-link" href="/demandes"
            ><span class="active-item-here"></span
            ><ion-icon name="document"></ion-icon> <span>DEMANDES</span></a
        >
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><i class="fa fa-dashboard mr-5"></i> <span>CONVENTIONS</span></a
        >
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><i class="fa fa-dashboard mr-5"></i>
            <span>APPELS D'OFFRES</span></a
        >
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><i class="fa fa-dashboard mr-5"></i>
            <span>SUIVI DES VERSEMENTS</span></a
        >
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><i class="fa fa-dashboard mr-5"></i> <span>STATISTIQUES</span></a
        >
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="#"
            ><span class="active-item-here"></span
            ><i class="fa fa-dashboard mr-5"></i> <span>CARTOGRAPHIE</span></a
        >
    </li>
</ul>
