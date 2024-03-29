<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AH Scoreboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap styles -->
    {{ HTML::style('/css/bootstrap.min.css') }}
    {{ HTML::style('/css/bootstrap-responsive.min.css') }}
    {{ HTML::style('/css/darkStrap.css') }}

    <!-- Extra styles -->
    {{ HTML::style('/vendor/font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('/vendor/select2/select2.css') }}
    {{ HTML::style('/vendor/messenger/build/css/messenger.css') }}
    {{ HTML::style('/vendor/messenger/build/css/messenger-theme-future.css') }}

    @yield('css')

    <!-- Local styles -->
    {{ HTML::style('/css/master.css') }}

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="/favicon.ico">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="brand">
            <i class="icon-trophy"></i>
            AH Scoreboard
          </div>
          <div class="">
            <ul class="nav">
                <li {{ routeIs( 'scoreboard') }}><a href="/scoreboard"><i class="icon-home"></i> Scoreboard</a></li>
                  <li {{ routeIs( 'about') }}><a href="/about"><i class="icon-question-sign"></i> About</a></li>
                @if (!isset($activeUser))
                  <li {{ routeIs( 'registration') }}><a href="/registration"><i class="icon-group"></i> Register</a></li>
                @endif
            </ul>
            @if (isset($activeUser))
                    <ul class="nav pull-right">
                      <li class="dropdown">
                        <a href="javascript: void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> {{ $activeUser->username }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="/user/account"><i class="icon-cogs"></i> Settings</a></li>
                          <li class="divider"></li>
                          @if ($activeUser->id == 1 || $activeUser->id == 5)
                            <li {{ routeIs( 'admin') }}><a href="/admin"><i class="icon-sun"></i> Admin Panel</a></li>
                            <li {{ routeIs( 'manage') }}><a href="/manage"><i class="icon-youtube"></i> Manage Episodes</a></li>
                            <li class="divider"></li>
                          @endif
                          <li><a href="/logout"><i class="icon-off"></i> Logout</a></li>
                        </ul>
                      </li>
                    </ul>
            @else
                <form class="navbar-form pull-right" method="POST" action="/login">
                  <input class="span2" type="text" placeholder="Username" name="username">
                  <input class="span2" type="password" placeholder="Password" name="password">
                  <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

        @if (isset($content))
            {{ $content }}
        @endif

    </div> <!-- /container -->

    <!-- Modal -->
    <div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
      </div>
    </div>

    <!-- javascript-->
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap-transition.js"></script>
    <script src="/js/bootstrap-alert.js"></script>
    <script src="/js/bootstrap-modal.js"></script>
    <script src="/js/bootstrap-dropdown.js"></script>
    <script src="/js/bootstrap-scrollspy.js"></script>
    <script src="/js/bootstrap-tab.js"></script>
    <script src="/js/bootstrap-tooltip.js"></script>
    <script src="/js/bootstrap-popover.js"></script>
    <script src="/js/bootstrap-button.js"></script>
    <script src="/js/bootstrap-collapse.js"></script>
    <script src="/js/bootstrap-carousel.js"></script>
    <script src="/js/bootstrap-typeahead.js"></script>
    <script src="/js/prefixer.js"></script>
    <script src="/vendor/select2/select2.js"></script>
    <script src="/vendor/bootbox/bootbox.min.js"></script>
    <script src="/vendor/messenger/build/js/messenger.min.js"></script>
    <script src="/vendor/messenger/build/js/messenger-theme-future.js"></script>
    <script src="/js/AHScoreboard.js"></script>
    @yield('jsInclude')

    <script>
      $(document).ready(function() {
        $("a[rel=popover]").popover();
        $("a.confirm-remove").click(function(e) {
              e.preventDefault();
              var location = $(this).attr('href');
              bootbox.confirm("Are you sure you want to remove this item?", "No", "Yes", function(confirmed) {
                  if(confirmed) {
                      window.location.replace(location);
                  }
              });
          });
        $("a.confirm-continue").click(function(e) {
              e.preventDefault();
              var location = $(this).attr('href');
              bootbox.confirm("Are you sure you want to continue?", "No", "Yes", function(confirmed) {
                  if(confirmed) {
                      window.location.replace(location);
                  }
              });
          });
        // Work around for multi data toggle modal
        // http://stackoverflow.com/questions/12286332/twitter-bootstrap-remote-modal-shows-same-content-everytime
        $('body').on('hidden', '#modal', function () {
          $(this).removeData('modal');
        });

        Messenger.options = {
          extraClasses: 'messenger-fixed messenger-on-top',
          theme: 'future'
        }

        var mainErrors = <?=(Session::get('errors') != null ? json_encode(implode('<br />', Session::get('errors'))) : 0)?>;
        var mainStatus = <?=(Session::get('message') != null ? json_encode(Session::get('message')) : 0)?>;

        if (mainErrors != 0) {
          Messenger().post({message: mainErrors,type: 'error'});
        }
        if (mainStatus != 0) {
          Messenger().post({message: mainStatus});
        }
        @yield('onReadyJs')
      });
    </script>

    @yield('js')

  </body>
</html>
