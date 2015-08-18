<div class="modal fade" id="ajaxErrorsModal" tabindex="-1" role="dialog" aria-labelledby="ajaxErrorsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert alert-dismissable alert-danger modal-header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ajaxErrorsModalLabel"><span class="fa fa-warning"></span> Oops! There is something wrong.</h4>
            </div>
            <div class="modal-body">
                <ul>
                    <li ng-repeat="error in $root.errors">@{{ error }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>