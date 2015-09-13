<header>
    <nav class="navbar navbar-fixed-top navbar-material-grey-800">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" ui-sref="home">CCU</a>
            </div>
            <div id="navbar-collapse" class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#/courses" data-toggle="tooltip" data-placement="bottom" title="課程評論"><span class="fa fa-fw fa-book"></span><span> 課程評論</span></a></li>
                    {{--<li><a href="#/dormitories/roommates" data-toggle="tooltip" data-placement="bottom" title="宿舍找室友"><span class="fa fa-fw fa-home"></span><span> 宿舍找室友</span></a></li>--}}
                    <li><a href="https://ecourse.bepsvpt.net" data-toggle="tooltip" data-placement="bottom" title="Ecourse Lite"><span class="fa fa-fw fa-cloud"></span><span> Ecourse Lite</span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if ($guard->guest())
                        <li><a ui-sref="auth-register" data-toggle="tooltip" data-placement="bottom" title="註冊"><span class="fa fa-fw fa-user-plus"></span><span class="visible-xs-inline"> 註冊</span></a></li>
                        <li><a ui-sref="auth-signIn" data-toggle="tooltip" data-placement="bottom" title="登入"><span class="fa fa-fw fa-sign-in"></span><span class="visible-xs-inline"> 登入</span></a></li>
                    @else
                        <li>
                            <a href="#/member" data-toggle="tooltip" data-placement="bottom" title="會員中心">
                                <profile-picture nickname="@{{ $root.user.nickname }}" size="profile-picture-small"></profile-picture>
                                <span>@{{ $root.user.nickname }}</span>
                            </a>
                        </li>
                        <li><a ui-sref="auth-signOut" data-toggle="tooltip" data-placement="bottom" title="登出"><span class="fa fa-fw fa-sign-out"></span><span class="visible-xs-inline"> 登出</span></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>