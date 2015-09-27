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
            <div ng-include="'{{ routeAssets('templates.member.account', true) }}'" id="account" role="tabpanel" class="tab-pane active"></div>
        </div>
    </div>
</div>