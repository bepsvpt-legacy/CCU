<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div>
            <form ng-submit="registerForm.$valid && submit()" name="registerForm" method="POST" accept-charset="UTF-8" data-toggle="validator">
                <fieldset>
                    <div class="text-center">
                        <legend>註冊</legend>
                    </div>

                    <div class="form-group has-feedback">
                        {!! Form::label('email', '信箱', ['class' => 'sr-only']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                            {!! Form::email('email', null, ['ng-model' => 'register.email', 'class' => 'form-control floating-label', 'placeholder' => '信箱', 'maxlength' => 96, 'required']) !!}
                        </div>
                        {!! Form::validationMessage() !!}
                    </div>

                    <div class="form-group has-feedback">
                        {!! Form::label('password', '密碼', ['class' => 'sr-only']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-key"></span></span>
                            {!! Form::password('password', ['ng-model' => 'register.password', 'class' => 'form-control floating-label', 'placeholder' => '密碼', 'data-minlength' => 6, 'required']) !!}
                        </div>
                        {!! Form::validationMessage() !!}
                    </div>

                    <div class="form-group has-feedback">
                        {!! Form::label('password_confirmation', '密碼確認', ['class' => 'sr-only']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-key"></span></span>
                            {!! Form::password('password_confirmation', ['ng-model' => 'register.password_confirmation', 'class' => 'form-control floating-label', 'data-match' => '#password', 'placeholder' => '密碼確認', 'required']) !!}
                        </div>
                        {!! Form::validationMessage() !!}
                    </div>

                    <div>
                        {!! Form::recaptcha() !!}
                    </div>

                    <div class="text-center">
                        {!! Form::button('註冊', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="sign-in-register-hint text-center">
            <span>已有帳號？</span>
            <span>{!! HTML::link('#/auth/sign-in', '登入') !!}</span>
        </div>
    </div>
</div>