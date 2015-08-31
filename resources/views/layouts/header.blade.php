<header>
    <nav class="navbar navbar-fixed-top navbar-material-grey-800">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#/">CCU</a>
            </div>
            <div id="navbar-collapse" class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#/courses" title="課程評論" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-fw fa-book"></span><span> 課程評論</span></a></li>
                    <li><a href="#/dormitories/roommates" title="宿舍找室友" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-fw fa-home"></span><span> 宿舍找室友</span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if ($guard->guest())
                        <li><a href="#/auth/register" title="註冊"><span class="fa fa-fw fa-user-plus"></span><span class="visible-xs-inline"> 註冊</span></a></li>
                        <li><a ng-init="$root.guest = true" href="#/auth/sign-in" title="登入"><span class="fa fa-fw fa-sign-in"></span><span class="visible-xs-inline"> 登入</span></a></li>
                    @else
                        <li><a href="#/member" title="敬請期待" data-toggle="tooltip" data-placement="bottom">{{ $guard->user()->user->nickname }}</a></li>
                        <li><a ng-init="$root.guest = false" href="#/auth/sign-out" title="登出"><span class="fa fa-fw fa-sign-out"></span><span class="visible-xs-inline"> 登出</span></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>