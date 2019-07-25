<!-- START OVERLAY -->
  <div class="overlay hide" data-pages="search">
    <!-- BEGIN Overlay Content !-->
    <div class="overlay-content has-results m-t-20">
      <!-- BEGIN Overlay Header !-->
      <div class="container-fluid">
        <!-- BEGIN Overlay Logo !-->
        <img class="overlay-brand" src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
        <!-- END Overlay Logo !-->
        <!-- BEGIN Overlay Close !-->
        <a href="#" class="close-icon-light overlay-close text-black fs-16">
          <i class="pg-close"></i>
        </a>
        <!-- END Overlay Close !-->
      </div>
      <!-- END Overlay Header !-->
      <div class="container-fluid">
        <!-- BEGIN Overlay Controls !-->
        <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
        <br>
        <!-- END Overlay Controls !-->
      </div>
    </div>
    <!-- END Overlay Content !-->
  </div>
  <!-- END OVERLAY -->