<div class="text-center">
    <form class="form-inline">
        <fieldset>
            <div class="form-group">
                {!! Form::label('department', '系所', ['class' => 'sr-only']) !!}
                <select ng-model="search.department" ng-change="searchFormSubmit()" ng-options="department.name for department in options.departments track by department.id" class="form-control">
                    <option value="">系所</option>
                </select>
            </div>

            <div ng-show="117 === search.department.id" class="form-group">
                {!! Form::label('dimension', '系所', ['class' => 'sr-only']) !!}
                <select ng-model="search.dimension" ng-change="searchFormSubmit()" ng-options="dimension.name for dimension in options.dimensions track by dimension.id" class="form-control">
                    <option value="">向度</option>
                </select>
            </div>

            <div class="form-group">
                {!! Form::label('keyword', '代碼/課名/教授', ['class' => 'sr-only']) !!}
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-search"></span></span>
                    {!! Form::input('search', 'keyword', null, ['ng-model' => 'search.keyword', 'ng-change' => 'searchFormSubmit()', 'class' => 'form-control floating-label', 'placeholder' => '代碼/課名/教授']) !!}
                </div>
            </div>
        </fieldset>
    </form>
</div>

<div ng-show="courses.length" class="text-center">
    <hr>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="info">
                <th>系所</th>
                <th>課程代碼</th>
                <th>課程名稱</th>
                <th>授課教授</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="course in courses">
                <td>@{{ course.department.name }}</td>
                <td>@{{ course.code }}</td>
                <td><a ng-href="#/courses/@{{ course.id }}" data-toggle="tooltip" data-placement="bottom" title="@{{ course.name_en }}">@{{ course.name }}</a></td>
                <td>@{{ course.professor }}</td>
            </tr>
        </tbody>
    </table>
</div>