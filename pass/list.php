<?php foreach($lang['passPage']['description'] as $value): ?>
    <p><?php echo $value; ?></p>
<?php endforeach; ?>

<div class="pass"></div>

<script type="text/javascript">
    $(function () {
        $('#headerTitle').text('<?php echo $lang['canvas'][$activeMenu] ?>');
        $('head > title').prepend('<?php echo $lang['canvas'][$activeMenu] ?>');

        $.ajax({
            url:  '<?php echo $host; ?>/app/services/admin/pass.php?mode=all',
            method: 'post',
            data: { status: 'a' },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    if(response.data.length > 0){
                        $.each(response.data, function (i, item) {
                            var alertNode = $('<div>').addClass('alert alert-info');
                            alertNode.appendTo('.pass');

                            var rowNode = $('<div>').addClass('row');
                            rowNode.appendTo(alertNode);

                            $('<div>', { text: item.name }).addClass('col-xs-7').css('padding-right', 0).appendTo(rowNode);
                            $('<div>', { text: '฿'+ parseFloat(item.price).toLocaleString() }).addClass('col-xs-3 text-right').css('padding', 0).appendTo(rowNode);
                            var colAddCartNode = $('<div>').addClass('col-xs-2 text-right');
                            colAddCartNode.appendTo(rowNode);

                            var btnAddCart = $('<a>').attr('href', '?action=reserve&id=' + item.id);
                            btnAddCart.appendTo(colAddCartNode);
                            $('<img src="<?php echo $host ?>/images/add-cart.png">').appendTo(btnAddCart);
                        });
                    }
                    else{
                        $('<p>', { text: 'Not found pass.' }).addClass('text-muted').appendTo('.list');
                    }
                }
            }
        });
    });
</script>