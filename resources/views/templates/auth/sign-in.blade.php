<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div>
            <form ng-submit="signInForm.$valid && submit()" name="signInForm" method="POST" accept-charset="UTF-8" data-toggle="validator">
                <fieldset>
                    <div class="text-center">
                        <legend>登入</legend>
                    </div>

                    <div class="form-group has-feedback">
                        {!! Form::label('email', '信箱', ['class' => 'sr-only']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                            {!! Form::email('email', null, ['ng-model' => 'signIn.email', 'class' => 'form-control floating-label', 'placeholder' => '信箱', 'required']) !!}
                        </div>
                        {!! Form::validationMessage() !!}
                    </div>

                    <div class="form-group has-feedback">
                        {!! Form::label('password', '密碼', ['class' => 'sr-only']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-key"></span></span>
                            {!! Form::password('password', ['ng-model' => 'signIn.password', 'class' => 'form-control floating-label', 'placeholder' => '密碼', 'required']) !!}
                        </div>
                        {!! Form::validationMessage() !!}
                    </div>

                    <div class="text-right">
                        <div class="checkbox inline">
                            <label>
                                {!! Form::checkbox('rememberMe', true, true, ['ng-model' => 'signIn.rememberMe']) !!}
                                <span> 記住我</span>
                            </label>
                        </div>

                        <div class="inline">
                            {!! Form::button('登入', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="sign-in-register-hint text-center">
            <span>尚未註冊？</span>
            <span>{!! HTML::link('#/auth/register', '註冊') !!}</span>
        </div>
    </div>
</div>