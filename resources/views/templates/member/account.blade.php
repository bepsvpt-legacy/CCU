<blockquote>
    <profile-picture nickname="@{{ $root.user.nickname }}" size="profile-picture"></profile-picture>
    <button type="file" ngf-select="changeProfilePicture($file)" accept="image/jpeg,image/png" ngf-max-size="4MB" class="btn btn-link">上傳</button>
</blockquote>

<blockquote>
    <span>暱稱：@{{ $root.user.nickname }} <a ng-click="showChangeNicknameForm = true" ng-hide="showChangeNicknameForm" class="cursor-pointer">變更</a></span>

    <div ng-show="showChangeNicknameForm">
        <br>

        <form ng-submit="changeNicknameForm.$valid && changeNicknameFormSubmit()" name="changeNicknameForm" method="POST" class="form-inline">
            <fieldset>
                <div class="form-group">
                    {!! Form::label('nickname', '新暱稱', ['class' => 'sr-only']) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                        {!! Form::text('nickname', null, ['ng-model' => 'changeNickname.nickname', 'class' => 'form-control floating-label', 'data-hint' => '需為5~16個英文或數字', 'placeholder' => '新暱稱', 'pattern' => '^\w{5,16}$', 'required']) !!}
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