<!-- START HEADER -->
  <div class="header ">
    <!-- START MOBILE CONTROLS -->
    <div class="container-fluid relative">
      <!-- LEFT SIDE -->
      <div class="pull-left full-height visible-sm visible-xs">
        <!-- START ACTION BAR -->
        <div class="header-inner">
          <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
            <span class="icon-set menu-hambuger"></span>
          </a>
        </div>
        <!-- END ACTION BAR -->
      </div>
      <div class="pull-center hidden-md hidden-lg">
        <div class="header-inner">
          <div class="brand inline">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
          </div>
        </div>
      </div>
      <!-- RIGHT SIDE -->
      <div class="pull-right full-height visible-sm visible-xs">
        <!-- START ACTION BAR -->
        <div class="header-inner">
          <a href="#" class="btn-link visible-sm-inline-block visible-xs-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
            <span class="icon-set menu-hambuger-plus"></span>
          </a>
        </div>
        <!-- END ACTION BAR -->
      </div>
    </div>
    <!-- END MOBILE CONTROLS -->
    <div class=" pull-left sm-table hidden-xs hidden-sm">
      <div class="header-inner">
        <div class="brand inline">
          <img src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
        </div>
        <a href="#" class="search-link" data-toggle="search"><i class="pg-search"></i>Clique aqui para <span class="bold">pesquisar</span></a> </div>
    </div>
    <div class=" pull-right">
      <!-- START User Info-->
      <div class="visible-lg visible-md m-t-10">
        <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
          <span class="semi-bold">{{auth()->user()->name}}</span>
        </div>
        <div class="dropdown pull-right">
          <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="thumbnail-wrapper d32 circular inline m-t-5">
            <img src="{{ asset('assets/img/profiles/f2x.jpg') }}" alt="" data-src="{{ asset('assets/img/profiles/f2x.jpg') }}" data-src-retina="{{ asset('assets/img/profiles/f2x.jpg') }}" width="32" height="32">
        </span>
          </button>
          <ul class="dropdown-menu profile-dropdown" role="menu">
            <li class="bg-master-lighter">
              <a href="{{ route('logout') }}" class="clearfix" 
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  <span class="pull-left">Logout</span>
                  <span class="pull-right"><i class="pg-power"></i></span>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </div>
      </div>
      <!-- END User Info-->
    </div>
  </div>
  <!-- END HEADER -->