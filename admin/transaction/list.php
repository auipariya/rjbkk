<?php
/**
 * Created by PhpStorm.
 * User: Aui
 * Date: 11/7/2559
 * Time: 19:06
 */

?>

<form class="form-horizontal" id="adminPass">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">KEYWORD</label>
                        <div class="col-sm-8">
                            <input type="text" name="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 hidden-xs"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">DURATION</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" name="duration_from" class="form-control">
                                <label class="input-group-addon">TO</label>
                                <input type="text" name="duration_to" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">STATUS</label>
                        <div class="col-sm-8">
                            <select name="status" class="form-control">
                                <option></option>
                                <?php foreach($admin['status'] as $key => $value): ?>
                                    <option value="<?=$key?>"><?=$value?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover table-condensed" id="tableTransaction">
        <thead>
        <tr>
            <th class="hidden-xs" style="width: 60px;">NO.</th>
            <th>TRANSACTION NO.</th>
            <th>CUSTOMER NAME</th>
            <th class="hidden-xs">PHONE NO.</th>
            <th class="hidden-xs">EMAIL</th>
            <th class="hidden-xs">CREATED AT</th>
            <th style="width: 61px;">STATUS</th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
            <td colspan="7">Not found transaction.</td>
        </tr>
        </tfoot>
    </table>
</div>

<!-- modal alert -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalTransaction">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">TRANSACTION INFORMATION</h4>
            </div>
            <div class="modal-body">
                <!--transaction id -->
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">INVOICE NO. </span>
                            <b><label class="col-xs-12 col-sm-8 control-label" aria-label="transactionNo"></label></b>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">METHOD</span>
                            <label class="col-xs-12 col-sm-8 control-label" aria-label="method"></label>
                        </div>
                    </div>
                </div>
                <!--/transaction id -->

                <hr style="margin: 5px 0;">

                <!--transaction info-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">NAME</span>
                            <label class="col-xs-12 col-sm-8 control-label" aria-label="name"></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">CREATED AT</span>
                            <label class="col-xs-12 col-sm-8 control-label" aria-label="createdAt"></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">PHONE NO.</span>
                            <label class="col-xs-12 col-sm-8 control-label" aria-label="phone"></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span class="col-xs-12 col-sm-4 control-label">EMAIL</span>
                            <label class="col-xs-12 col-sm-8 control-label" aria-label="email"></label>
                        </div>
                    </div>
                </div>
                <!--/transaction info-->

                <!--invoice item-->
                <div class="table-responsive">
                    <table class="table table-hover table-condensed" id="tableInvoiceItem">
                        <thead>
                        <tr>
                            <th style="width: 80px">Quantity</th>
                            <th>Description</th>
                            <th style="width: 100px" class="text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!--/invoice item-->

                <!--invoice summary-->
                <div class="row">
                    <div class="col-sm-offset-6 col-sm-6">
                        <table class="table table-striped table-bordered table-condensed">
                            <tr>
                                <td style="width: 40%">SUBTOTAL</td>
                                <td class="text-right">฿<span aria-label="subtotal"></span></td>
                            </tr>
                            <tr>
                                <td style="width: 40%">SALE TAX</td>
                                <td class="text-right">฿<span aria-label="saleTax"></span></td>
                            </tr>
                            <tr>
                                <td style="width: 40%">FEE</td>
                                <td class="text-right">฿<span aria-label="fee"></span></td>
                            </tr>
                            <tr style="font-weight: 600;">
                                <td style="width: 40%">ORDER TOTAL</td>
                                <td class="text-right">฿<span aria-label="orderTotal"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--/invoice summary-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.page-header .btn').addClass('hidden');

        createTransactionTable();
        $('input[name="keyword"], input[name=duration_from], input[name=duration_to]').on('keyup dp.change', function () {
            createTransactionTable();
        });

        function createTransactionTable(){
            var tableContent = $('#tableTransaction > tbody');
            var params = {
                keyword: $('input[name=keyword]').val(),
                durationFrom: $('input[name=duration_from]').val(),
                durationTo: $('input[name=duration_to]').val()
            };

            $.ajax({
                url: '<?php echo $host; ?>/app/services/admin/transaction.php?mode=all',
                method: 'post',
                data: params,
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        tableContent.empty();
                        if(response.data.length > 0){
                            $('#tableTransaction > tfoot').addClass('hidden');

                            $.each(response.data, function (i, item) {
                                var tableRow = $('<tr>')
                                    .css('cursor', 'pointer')
                                    .appendTo(tableContent)
                                    .on('click', tableRowClick);
                                $('<td>').text(i + 1).addClass('hidden-xs').appendTo(tableRow);
                                $('<td>').text(item.id).appendTo(tableRow);
                                $('<td>').text(item.customer_name).appendTo(tableRow);
                                $('<td>').text(item.customer_tel).addClass('hidden-xs').appendTo(tableRow);
                                $('<td>').text(item.customer_email).addClass('hidden-xs').appendTo(tableRow);
                                $('<td>').text(new Date(item.created_at).toLocaleString()).addClass('hidden-xs').appendTo(tableRow);
                                var cellStatus = $('<td>').addClass('text-center').appendTo(tableRow);
                                var status = <?=json_encode($admin['status'])?>;
                                status['p'] = 'Progress'; // add progress status
                                var statusClass = 'fa fa-';
                                if(item.status == 'a') 
                                    statusClass += 'check-circle text-success';
                                else if (item.status == 'p') 
                                    statusClass += 'hourglass-start text-info';
                                else 
                                    statusClass += 'circle-o text-danger';
                                $('<i>', { title: status[item.status] }).addClass(statusClass).appendTo(cellStatus);
                            });
                        }
                        else{
                            $('#tableTransaction > tfoot').removeClass('hidden');
                        }
                    }
                }
            });
        }

        function tableRowClick(){
            var invoiceId = $(this).find('td:nth-child(2)').text();
            $.ajax({
                url:  '<?php echo $host; ?>/app/services/admin/transaction.php?mode=retrieve',
                method: 'post',
                data: { invoiceId: invoiceId },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        var invoice = response.data['invoice'];
                        var invoiceItem = response.data['invoiceItem'];

                        $('[aria-label="transactionNo"]').empty().append(invoice.id);
                        $('[aria-label="name"]').empty().append(invoice.customer_name);
                        $('[aria-label="createdAt"]').empty().append(new Date(invoice.created_at).toLocaleString());
                        $('[aria-label="phone"]').empty().append(invoice.customer_tel);
                        $('[aria-label="email"]').empty().append(invoice.customer_email);
                        var method = <?=json_encode($lang['paysbuy']['method'])?>;
                        $('[aria-label="method"]').empty().append(method[invoice.method]);
                        $('[aria-label="subtotal"]').empty().append(parseFloat(invoice.amount).formatMoney(2, '.', ','));
                        $('[aria-label="saleTax"]').empty().append(parseFloat(0).formatMoney(2, '.', ','));
                        $('[aria-label="fee"]').empty().append(parseFloat(invoice.fee).formatMoney(2, '.', ','));
                        $('[aria-label="orderTotal"]').empty().append((parseFloat(invoice.amount) - parseFloat(invoice.fee)).formatMoney(2, '.', ','));

                        var transactionContent = $('#tableInvoiceItem > tbody').empty();
                        $.each(invoiceItem, function (i, item) {
                            var tableRow = $('<tr>').appendTo(transactionContent);
                            $('<td>').append(item.quantity).appendTo(tableRow);
                            var itemDescription = '';
                            if(item.type == 'jump'){
                                itemDescription += item.description + ' ' ;
                                itemDescription += new Date(item.reserve_date).toLocaleDateString() + ' ';
                                itemDescription += new Date(item.reserve_date + ' ' + item.reserve_time).formatTimeUS();
                            }
                            else if (item.type == 'pass'){
                                itemDescription = $('<span>', {
                                    text: item.first_name + ' ' + item.last_name +
                                    (item.telephone != '' ? ', Tel.:' + item.telephone : '') +
                                    (item.email != '' ? ', Email:' + item.email : '')
                                });
                            }
                            $('<td>')
                                .append(item.name)
                                .append($('<div>').append(itemDescription).css('font-style', 'italic').addClass('text-muted'))
                                .appendTo(tableRow);
                            $('<td>').append('฿').append(parseFloat(item.price * item.quantity).formatMoney(2, '.', ',')).addClass('text-right').appendTo(tableRow);
                        });

                        $('#modalTransaction').modal('show');
                    }
                }
            });
        }
    });
</script>