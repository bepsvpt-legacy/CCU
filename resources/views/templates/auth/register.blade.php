<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div>
            <form ng-submit="registerForm.$valid && registerFormSubmit()" name="registerForm" method="POST" accept-charset="UTF-8" data-toggle="validator">
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

                    <div>
                        <div class="text-right">
                            {!! Form::button('註冊', ['type' => 'submit', 'class' => 'btn btn-sm btn-success']) !!}
                        </div>
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

<div class="modal fade" id="register-terms-of-service" tabindex="-1" role="dialog" aria-labelledby="registerTermsOfServiceLabel">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="registerTermsOfServiceLabel">服務條款</h4>
            </div>
            <div class="modal-body">
                <hr>
                <ol>
                    <li>本網站所提供服務的相關網站原始碼可由 <a href="https://github.com/BePsvPT/CCU" target="_blank">此處</a> 查閱</li>
                    <li>本網站可能會隨時更改隱私條款或服務條款，且並不對會員負有通知條款更改生效的義務</li>
                    <li>在您按下註冊按鈕後，即代表您已詳閱並同意<a href="https://beta-ccu.bepsvpt.net/#/policy" target="_blank">網站隱私條款</a></li>
                    <li>在您按下註冊按鈕後，即代表您已詳閱並同意此服務條款</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>