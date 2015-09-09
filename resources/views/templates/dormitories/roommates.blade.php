<div class="row">
    <div ng-class="showCreateForm ? 'col-md-offset-0' : 'col-md-offset-3'" class="col-xs-12 col-md-6">
        <div>
            <p class="dormitories-roommates-title">找室友</p>
        </div>

        <div>
            <form ng-submit="searchForm.$valid && searchFormSubmit()" name="searchForm" class="form-inline" method="POST" accept-charset="UTF-8">
                <fieldset>
                    <div class="form-group">
                        {!! Form::label('searchName', '姓名', ['class' => 'sr-only']) !!}
                        {!! Form::text('searchName', null, ['ng-model' => 'search.name', 'class' => 'form-control floating-label', 'placeholder' => '姓名', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('searchRoom', '寢室房號', ['class' => 'sr-only']) !!}
                        {!! Form::text('searchRoom', null, ['ng-model' => 'search.room', 'class' => 'form-control floating-label', 'placeholder' => '寢室房號', 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::button('查詢', ['type' => 'submit', 'class' => 'btn btn-sm btn-success']) !!}
                        {!! Form::button('新增資料', ['ng-if' => ' !!! showCreateForm', 'ng-click' => 'createFormShow()', 'type' => 'button', 'class' => 'btn btn-sm btn-primary']) !!}
                    </div>
                </fieldset>
            </form>
        </div>

        <div ng-hide="undefined === searchResults" class="text-center">
            <hr>

            <span ng-hide="searchResults.length">查無資料</span>

            <table ng-show="searchResults.length" class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr class="info">
                        <th>床位</th>
                        <th>姓名</th>
                        <th>FB連結</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="searchResult in searchResults">
                        <td>@{{ searchResult.bed }}</td>
                        <td>@{{ searchResult.name }}</td>
                        <td><a ng-href="@{{ searchResult.fb }}" target="_blank">link</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr>

        <div class="text-center">
            <table class="table table-striped table-bordered table-hover shadow-z-1">
                <thead>
                    <tr class="info">
                        <th><span class="fa fa-magic" aria-hidden="true"></span></th>
                        <th><span class="fa fa-music" aria-hidden="true"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>夢想啟程</td>
                        <td>@{{ status[3] }}</td>
                    </tr>
                    <tr>
                        <td>最終伙伴</td>
                        <td>@{{ status[2] }}</td>
                    </tr>
                    <tr>
                        <td>成雙成對</td>
                        <td>@{{ status[1] }}</td>
                    </tr>
                    <tr>
                        <td>出發追夢</td>
                        <td>@{{ status[0] }}</td>
                    </tr>
                </tbody>
            </table>

            <span>每 1 小時更新一次</span>
        </div>
    </div>

    <div ng-if="showCreateForm" class="col-xs-12 col-md-4 col-md-offset-1">
        <form ng-submit="createForm.$valid && createFormSubmit()" name="createForm" method="POST" accept-charset="UTF-8">
            <fieldset>
                <div>
                    <legend>新增資料</legend>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::label('createRoom', '寢室房號', ['class' => 'sr-only']) !!}
                    {!! Form::text('createRoom', null, ['ng-model' => 'create.room', 'class' => 'form-control floating-label', 'placeholder' => '寢室房號 e.g. 1112', 'pattern' => '^[1-5][1-9](0[1-9]|1[0-6])$', 'required']) !!}
                    <span class="form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('createBed', '床位', ['class' => 'sr-only']) !!}
                    <select ng-init="options = ['A', 'B', 'C', 'D']" ng-model="create.bed" ng-options="o as o for o in options" name="createBed" class="form-control" required>
                        <option value="">床位</option>
                    </select>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::label('createName', '姓名', ['class' => 'sr-only']) !!}
                    {!! Form::text('createName', null, ['ng-model' => 'create.name', 'class' => 'form-control floating-label', 'placeholder' => '姓名', 'maxlength' => 8, 'required']) !!}
                    <span class="form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::label('createFb', 'FB連結', ['class' => 'sr-only']) !!}
                    {!! Form::url('createFb', null, ['ng-model' => 'create.fb', 'class' => 'form-control floating-label', 'placeholder' => 'FB連結', 'maxlength' => 128, 'required']) !!}
                    <span class="form-control-feedback" aria-hidden="true"></span>
                    <div class="help-block with-errors"></div>
                </div>

                <div>
                    {!! Form::recaptcha() !!}
                </div>

                <div class="text-center">
                    {!! Form::button('隱藏新增', ['ng-click' => 'createFormHide()', 'type' => 'button', 'class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::button('新增', ['type' => 'submit', 'class' => 'btn btn-sm btn-success']) !!}
                </div>
            </fieldset>
        </form>
    </div>
</div>