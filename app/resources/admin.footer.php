        </div>
    </div>
</div>

<!--<div class="modal fade" tabindex="-1" role="dialog" id="modalChangePassword">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change password</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Whoops!</strong> There were some problems with your input.
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/update-password') }}" id="formChangePassword">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 hidden-xs control-label">Old Password</label>
                            <div class="col-md-6"><input type="password" class="form-control" name="old_password" placeholder="Old Password"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 hidden-xs control-label">Password</label>
                            <div class="col-md-6"><input type="password" class="form-control" name="password" placeholder="Password"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 hidden-xs control-label">Confirm Password</label>
                            <div class="col-md-6"><input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                </div>
        </div>
    </div>
</div>-->

<script src="<?php echo $host ?>/js/global.js"></script>
<script src="<?php echo $host ?>/js/admin.js"></script>
</body>
</html>
