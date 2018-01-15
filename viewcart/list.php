<?php
if(isset($_POST) && count($_POST) > 0){
    if(!isset($_SESSION['productOrder'])){
        $_SESSION['productOrder'] = [];
    }

    if($_POST['type'] == 'pass'){
        $orderId = $_POST['orderId'];
        unset($_POST['orderId']);
        if($orderId != null){
            $_SESSION['productOrder'][$orderId] = $_POST;
        }
        else{
            $_SESSION['productOrder'][] = $_POST;
        }
    }
    else{
        foreach($_POST['id'] as $key => $value){
            if($_POST['quantity'][$key] > 0){
                $orderItem = [
                    'type' => $_POST['type'],
                    'id' => $_POST['id'][$key],
                    'name' => $_POST['name'][$key],
                    'price' => $_POST['price'][$key],
                    'quantity' => $_POST['quantity'][$key],
                    'description' => $_POST['description'],
                    'reserveDate' => $_POST['reserveDate'],
                    'reserveTime' => $_POST['reserveTime']
                ];
                $_SESSION['productOrder'][] = $orderItem;
            }
        }
    }

    $productOrder = [];
    foreach($_SESSION['productOrder'] as $value){
        if(count($value) > 0){
            $productOrder[] = $value;
        }
    }
    $_SESSION['productOrder'] = array_values($productOrder);
    calculateItemAndPrice();
    //echo '<pre>',print_r($_SESSION['productOrder']),'</pre>';
    //unset($_SESSION);

    echo '<script>window.location = location.href;</script>';
}
?>

<div class="table-responsive">
    <table id="tableProductOrder" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width: 10%;"><?php echo $lang['label']['quantity'] ?></th>
            <th style="width: 60%;"><?php echo $lang['label']['description'] ?></th>
            <th style="width: 30%;" class="text-right"><?php echo $lang['label']['amount'] ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot><tr><td colspan="4" class="text-muted"><?php echo $lang['msg']['notFound'] ?></td></tr></tfoot>
    </table>
</div>

<div class="row">
    <div class="col-sm-offset-6 col-sm-6">
        <table class="table table-striped table-bordered">
            <tr>
                <td style="width: 40%"><?php echo $lang['label']['subtotal'] ?>:</td>
                <td class="text-right">฿<span name="subtotal"></span></td>
            </tr>
            <tr>
                <td style="width: 40%"><?php echo $lang['label']['saleTax'] ?>:</td>
                <td class="text-right">฿<span name="saleTax"></span></td>
            </tr>
            <tr style="font-weight: 600;">
                <td style="width: 40%"><?php echo $lang['label']['orderTotal'] ?>:</td>
                <td class="text-right">฿<span name="orderTotal"></span></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 text-right">
        <a href="<?php echo $host ?>/buyticket" class="btn btn-link" name="keepShopping"><?php echo $lang['button']['keepShopping'] ?></a>
        <a class="btn btn-warning" name="checkout" data-toggle="modal" data-target="#modalContract"><?php echo $lang['nav']['checkout'] ?></a>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#headerTitle').text('<?php echo $lang['label']['mycart'] ?>');
        $('head > title').prepend('<?php echo $lang['label']['mycart'] ?>');
        $('#divContentRight').addClass('hidden');
        $('#divContentCenter').removeClass('col-sm-6 col-md-8').addClass('col-sm-9 col-md-10');

        var tableContent = $('#tableProductOrder').find('tbody');
        $.each(<?php echo json_encode($_SESSION['productOrder']) ?>, function (i, item) {
            var tableRow = $('<tr>').appendTo(tableContent);
            var cellPrice = null;
            // quantity
            var cellQuantity = $('<td>').appendTo(tableRow);
            if(item.type == 'pass'){
                cellQuantity.text(item.quantity);
            }
            else if(item.type == 'jump'){
                var quantityInput = $('<input>', {
                    type: 'number', value: parseInt(item.quantity), min: 1, max: 50
                }).addClass('form-control').appendTo(cellQuantity);
                quantityInput.on('change keyup', function (e) {
                    if($(this).val() != ''){
                        var quantity = parseInt($(this).val());
                        $.ajax({
                            url:  '<?php echo $host; ?>/app/services/viewcart/manageQuantity.php',
                            method: 'post',
                            data: { orderId: i, quantity: quantity },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success == true) {
                                    item.quantity = quantity;
                                    cellPrice.text('฿' + parseFloat(item.price * item.quantity).toLocaleString());
                                    calculateTotalPrice();
                                }
                            }
                        });
                    }
                });
            }

            // item
            var cellItem = $('<td>').appendTo(tableRow);
            cellItem.text(item.name);

            var subInfoItem = $('<div>', {
                text: item.type == 'pass' ? (item.firstname + ' ' + item.lastname + ' ') : (item.description + ' ' + item.reserveDate + ' ' + item.reserveTime)
            }).css('font-style', 'italic').addClass('text-muted').appendTo(cellItem);
            if(item.type == 'pass'){
                var btnEdit = $('<i class="fa fa-pencil"></i>')
                    .css('cursor', 'pointer')
                    .appendTo(subInfoItem);
                btnEdit.on('click', function () {
                    var formEditPassInfo = $('<form>', {
                        method: 'post',
                        action: '<?php echo $host ?>/pass/?action=reserve&id=' + item.id
                    }).appendTo('body');
                    $('<input>', {
                        type: 'hidden',
                        name: 'orderId',
                        value: i
                    }).appendTo(formEditPassInfo);
                    formEditPassInfo.submit();
                });
            }

            // price
            cellPrice = $('<td name="price['+i+']">')
                .text('฿' + parseFloat(item.price * item.quantity).toLocaleString())
                .addClass('text-right')
                .appendTo(tableRow);

            // button delete
            var cellBtnDelete = $('<td>').appendTo(tableRow);
            var btnDelete = $('<i class="fa fa-times text-danger"></i>').css('cursor', 'pointer').appendTo(cellBtnDelete);
            btnDelete.on('click', function () {
                $.ajax({
                    url:  '<?php echo $host; ?>/app/services/viewcart/deleteOrder.php',
                    method: 'post',
                    data: { orderId: i },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success == true) {
                            tableRow.remove();
                            calculateTotalPrice();
                        }
                    }
                });
            });
        });
        calculateTotalPrice();

        function calculateTotalPrice() {
            var subtotal = 0;
            var saleTax = 0;
            var orderTotal = 0;
            $.each(tableContent.find('td[name*=price]'), function (i, item) {
                subtotal += parseFloat(item.textContent.replace('฿', '').replace( /,/g, ''));
            });
            orderTotal += subtotal;

            $('span[name=subtotal]').text(subtotal.toLocaleString());
            $('span[name=saleTax]').text(saleTax.toLocaleString());
            $('span[name=orderTotal]').text(orderTotal.toLocaleString());
            if(orderTotal == 0){
                $('a[name=checkout]').addClass('disabled');
                $('a[name=keepShopping]').addClass('hidden');
                $('#tableProductOrder').find('tfoot').removeClass('hidden');
                $('#navCheckOut').addClass('hidden');
            }
            else{
                //$('a[name=checkout]').removeClass('disabled');
                $('a[name=keepShopping]').removeClass('hidden');
                $('#tableProductOrder').find('tfoot').addClass('hidden');
                $('#navCheckOut').removeClass('hidden');
            }
        }
    });
</script>