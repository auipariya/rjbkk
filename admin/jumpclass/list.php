<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 11/7/2559
 * Time: 19:06
 */

?>

<div id="<?php echo $activeMenu ?>" class="list"></div>

<script type="text/javascript">
    $(function () {
        $('.page-header .btn').removeClass('hidden');

        $.ajax({
            url:  '<?php echo $host; ?>/app/services/admin/jumpclass.php?mode=all',
            method: 'post',
            success: function (response) {
                if (response.success == true) {
                    if(response.data.length > 0){
                        for(var i in response.data){
                            var item = response.data[i];

                            var alertDom = $('<div>', {
                                text: item.name
                            }).addClass('alert alert-' + (item.status == 'a' ? 'info' : 'warning' ));
                            $('<a href="?mode=update&id='+ item.id +'"><i class="fa fa-cog pull-right"></i></a>').appendTo(alertDom);
                            alertDom.appendTo('.list');
                        }
                    }
                    else{
                        $('<p>', { text: 'Not found jump class.' }).addClass('text-muted').appendTo('.list');
                    }
                }
            }
        });
    });
</script>