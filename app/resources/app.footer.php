        </div><!--/.col-xs-12.col-sm-9-->


        <div id="divContentRight" class="hidden-xs col-sm-3 col-md-2">
            <div class="panel panel-default" id="divCheckOutBox">
                <div class="panel-body text-center">
                    <p style="font-weight: bold;"><?php echo $lang['viewcartCheckoutBox']['title'] ?></p>
                    <div class="row h5">
                        <div class="col-xs-5 text-left" style="padding-right: 0;"><?php echo $lang['viewcartCheckoutBox']['item'] ?></div>
                        <div class="col-xs-7 text-right" style="padding-left: 0;">
                            <span style="color: #ffff00; font-weight: bold;"><?php echo number_format($_SESSION['totalItem']) ?></span>
                        </div>
                    </div>
                    <div class="row h5">
                        <div class="col-xs-5 text-left" style="padding-right: 0;"><?php echo $lang['viewcartCheckoutBox']['total'] ?></div>
                        <div class="col-xs-7 text-right" style="padding-left: 0;">
                            <span style="color: #ffff00; font-weight: bold;">฿<?php echo number_format($_SESSION['totalPrice']) ?></span>
                        </div>
                    </div>
                    <a class="btn btn-sm btn-block btn-warning" href="<?php echo $host ?>/viewcart"><?php echo $lang['nav']['viewcart'] ?></a>
                    <?php if(count($_SESSION['productOrder']) > 0): ?>
                        <a class="btn btn-sm btn-block btn-warning" data-toggle="modal" data-target="#modalContract"><?php echo $lang['nav']['checkout'] ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer text-muted text-center">
        Copyright &copy; 2016 Rockin' Jump Bangkok All Rights Reserved<br>
        428 Ratchadaphisek-Rama3 Road Chongnonsee<br>
        Bangkok, Thailand
    </div>
</div>


<!-- modal alert -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalContract">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?=$host?>/checkout/" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$lang['label']['enterContractTitle']?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 hidden-xs control-label"><?=$lang['label']['fullName']?><b style="color: red;">*</b></label>
                        <div class="col-md-6"><input type="text" class="form-control" name="name" required placeholder="<?=$lang['label']['fullName']?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 hidden-xs control-label"><?=$lang['label']['telephone']?></label>
                        <div class="col-md-6"><input type="tel" class="form-control" name="telephone" placeholder="<?=$lang['label']['telephone']?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 hidden-xs control-label"><?=$lang['label']['email']?><b style="color: red;">*</b></label>
                        <div class="col-md-6"><input type="email" class="form-control" name="email" required placeholder="<?=$lang['label']['email']?>"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['button']['close']?></button>
                    <button type="submit" class="btn btn-warning"><?=$lang['button']['continue']?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---------------------- Bootstrap core JavaScript ---------------------->
<script src="<?php echo $host ?>/js/global.js"></script>
<script src="<?php echo $host ?>/js/app.js"></script>
</body>
</html>