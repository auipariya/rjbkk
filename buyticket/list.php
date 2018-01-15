<div class="list"></div>

<script type="text/javascript">
    $(function () {
        $('#headerTitle').text('<?php echo $lang['canvas'][$activeMenu] ?>');
        $('head > title').prepend('<?php echo $lang['canvas'][$activeMenu] ?>');

        $.ajax({
            url:  '<?php echo $host; ?>/app/services/admin/jumpclass.php?mode=all',
            method: 'post',
            data: { status: 'a' },
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    if(response.data.length > 0){
                        $.each(response.data, function (i, item) {
                            $('<div>', { text: item.name })
                                .addClass('alert alert-info')
                                .css('cursor', 'pointer')
                                .appendTo('.list')
                                .on('click', function () {
                                    location.href = '?action=reserve&id=' + item.id;
                                });
                        });
                    }
                    else{
                        $('<p>', { text: 'Not found jump class.' }).addClass('text-muted').appendTo('.list');
                    }
                }
            }
        });
    });
</script>