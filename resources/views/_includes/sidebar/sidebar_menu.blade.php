<!-- BEGIN SIDEBPANEL-->
  <nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <div class="sidebar-overlay-slide from-top" id="appMenu">
      <div class="row">
        <div class="col-xs-6 no-padding">
          <a href="#" class="p-l-40"><img src="{{ asset('assets/img/demo/social_app.svg') }}" alt="socail">
          </a>
        </div>
        <div class="col-xs-6 no-padding">
          <a href="#" class="p-l-10"><img src="{{ asset('assets/img/demo/email_app.svg') }}" alt="socail">
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6 m-t-20 no-padding">
          <a href="#" class="p-l-40"><img src="{{ asset('assets/img/demo/calendar_app.svg') }}" alt="socail">
          </a>
        </div>
        <div class="col-xs-6 m-t-20 no-padding">
          <a href="#" class="p-l-10"><img src="{{ asset('assets/img/demo/add_more.svg') }}" alt="socail">
          </a>
        </div>
      </div>
    </div>
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
      <img src="{{ asset('assets/img/logo_white.png') }}" alt="logo" class="brand" data-src="{{ asset('assets/img/logo_white.png') }}" data-src-retina="{{ asset('assets/img/logo_white_2x.png') }}" width="78" height="22">
      <div class="sidebar-header-controls">
        <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
        </button>
        <button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
        </button>
      </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
      <!-- BEGIN SIDEBAR MENU ITEMS-->
      <ul class="menu-items">
        <li class="m-t-30 ">
          <a href="{{ route('home') }}" class="detailed">
            <span class="title">Dashboard</span>
          </a>
          <span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
        </li>
        @if(auth()->user()->admin)
        <li class="">
          <a href="{{route('users.index')}}" class="detailed">
            <span class="title">Usuários</span>
          </a>
          <span class="icon-thumbnail">U</span>
        </li>
        @endif
        <li class="">
          <a href="{{route('categories.index')}}" class="detailed">
            <span class="title">Categorias</span>
          </a>
          <span class="icon-thumbnail">C</span>
        </li>
        <li>
          <a href="javascript:;"><span class="title">Contas</span>
          <span class=" arrow"></span></a>
          <span class="icon-thumbnail"><i class="pg-calender"></i></span>
          <ul class="sub-menu">
            <li class="">
              <a href="{{route('bill_pays.index')}}">A Pagar</a>
              <span class="icon-thumbnail">p</span>
            </li>
            <li class="">
              <a href="{{route('bill_receives.index')}}">A Receber</a>
              <span class="icon-thumbnail">r</span>
            </li>
          </ul>
        </li>
        <li class="">
          <a href="{{route('statement')}}">
            <span class="title">Extrato</span>
          </a>
          <span class="icon-thumbnail"><i class="pg-layouts"></i></span>
        </li>
        <li class="">
          <a href="{{route('charts')}}">
            <span class="title">Gráfico</span>
          </a>
          <span class="icon-thumbnail"><i class="pg-layouts"></i></span>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
  </nav>
  <!-- END SIDEBAR -->
  <!-- END SIDEBPANEL-->