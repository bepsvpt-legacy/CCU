<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <h3>會員中心</h3>

        <hr>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#account" aria-controls="account" role="tab" data-toggle="tab" a-prevent-default>個人資料</a></li>
        </ul>

        <br>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="account">
                <blockquote>
                    <span>暱稱：@{{ $root.user.nickname }} <a ng-click="showChangeNicknameForm = true" ng-hide="showChangeNicknameForm" class="cursor-pointer">變更</a></span>

                    <div ng-show="showChangeNicknameForm">
                        <br>

                        <form ng-submit="changeNicknameForm.$valid && changeNicknameFormSubmit()" name="changeNicknameForm" class="form-inline" method="POST" accept-charset="UTF-8">
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::label('nickname', '新暱稱', ['class' => 'sr-only']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                        {!! Form::text('nickname', null, ['ng-model' => 'changeNickname.nickname', 'class' => 'form-control floating-label', 'placeholder' => '新暱稱', 'pattern' => '^\w{5,16}$', 'title' => '暱稱需為5~16個英文或數字', 'required']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::button('更改', ['type' => 'submit', 'class' => 'btn btn-sm btn-success']) !!}
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </blockquote>

                <blockquote>
                    <span>信箱：@{{ $root.user.email }} - @{{ $root.user.hasRole('verified-user') ? '已驗證' : '尚未驗證' }}</span>
                </blockquote>
            </div>
        </div>
    </div>
</div>