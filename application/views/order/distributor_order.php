<?php
	$this->load->view("_partials/header.php");
	$orders = $this->data['orders'];
?>
	<main id="main" class="row">
	    <?php
	    	$this->load->view("_partials/side_bar.php");
	    ?>
	    <div class="large-9 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            
	            <!-- #orders -->
                <div id="orders" class="content active">
                    <table class="table table--dsh">
                        <thead>
                            <tr>
                                <th class="table--dsh__header">Order ID</th>
                                <th class="table--dsh__header">Customer Name</th>
                                <th class="table--dsh__header">Date</th>
                                <th class="table--dsh__header">Payment Method</th>
                                <th class="table--dsh__header">Details</th>
                            </tr// >
                        </thead>
                        <tbody>
                        	<?php
                        	$i = 0;
                        	foreach ($orders as $order) {
                        		$i++;
                        		?>
                        	<tr>
                        		<td>
                        			<?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?>
                        		</td>
                        		<td>
                        			<?php echo $order->order_customer_name; ?>
                        		</td>
                        		<td>
                        			<?php echo $order->order_date; ?>
                        		</td>
                        		<td>
                        			<?php echo $order->order_payment_method; ?>
                        		</td>
                                <?php
                                    if (!$order->order_isAproved) {
                                        if (!$order->order_deniedReason) {
                                            ?>
                                            <td id="td-detail-<?php echo $order->order_id; ?>" class="has-details"><a href="#" data-reveal-id="orderDetails<?php echo $order->order_id; ?>" title="details">details</a></td>
                                            <?php
                                        } 
                                    ?>
                                    <?php
                                    } else {
                                        ?>
                                        <td id="td-detail-<?php echo $order->order_id; ?>" class="status-waiting" >
                                                <a href="#" title="Details">waiting for delivery and pickup</a></td> <!-- end of: Details -->
                                        <?php
                                    } 
                                ?>
                        		
                                    <?php 
                                        if (!$order->order_isAproved) {
                                            if ($order->order_deniedReason) {
                                                echo "<td class=''>Denied :".$order->order_deniedReason."</td>" ;
                                            } else {
                                            ?>

                                            <td class="table--dsh__action" id="td-<?php echo $order->order_id; ?>">
                                                <ul class="no-bullet inline-list">
                                                    <li> <!-- Approve action -->
                                                        <a class="button secondary action_approve" value="<?php echo $order->order_id; ?>" href="#" title="Approve">Approve</a> <!-- end of: Approve action -->
                                                    </li>
                                                    <li> <!-- Deny action -->
                                                        <a class="button action_deny" href="#" data-reveal-id="deniedReason"  value="<?php echo $order->order_id; ?>" title="Deny">Deny</a> <!-- end of: Deny action -->
                                                    </li>
                                                </ul>

                                            <?php
                                            }

                                        } else {

                                            ?>
                                            <td class="status-approved">approved
                                            <?php
                                        }
                                    ?>
                        		</td>
                        	</tr>
                            <?php
                        	}
                        	?>
                        </tbody>
                    </table>
                    
                    <!-- Stores pagination -->
	                <div id="pagination" class="pagination-centered" style="width: auto; height: auto;">
	                    <ul class="tsc_pagination" style="height: auto; width: 50%; margin: auto;">
	                        <?php 
		                        foreach ($this->data['links'] as $link) {
		                            echo "<li>". $link."</li>";
		                        }
		                    ?>
	                    </ul>
	                </div>

                </div> <!-- end of #orders -->
	        </div>
			<!-- end of tabs content -->
	    </div>
	</main>

    <div id="deniedReason" class="reveal-modal text-center" data-reveal aria-labelledby="orderTitle" aria-hidden="true" role="dialog">
        
        <img class="favicon" src="<?php echo asset_base_url();?>/images/favicon.png" alt="notibrew" title="notibrew"/>
        <label> Why do you deny this order?
            <br>
            <input type="text" required id="denied_reason" placeholder="Denied Reason Here..." />
        </label>
        <a class="button secondary denyWithReasonButton" value="<?php echo $order->order_id; ?>" href="#" title="Approve">Deny</a>
    </div>

    <?php
    foreach ($orders as $order) {
        ?>
            <div id="orderDetails<?php echo $order->order_id;?>" class="reveal-modal text-center" data-reveal aria-labelledby="orderTitle"
            aria-hidden="true" role="dialog">
            
            <!-- Store icon: favicon.png -->
            <img class="favicon" src="<?php echo asset_base_url();?>/images/favicon.png" alt="notibrew" title="notibrew"/> <!-- end of store icon -->
            
            <!-- Title message -->
            <h4 id="orderTitle" class="title">Order Details</h4> <!-- end of title message -->
            
            <!-- Order summary -->
            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Beer Name</th>
                        <th>Price</th>
                        <th class="text-right">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Beer name -->
                        <td><?php echo $order->order_beer_name; ?></td> <!-- end of beer name -->
                        
                        <!-- Price -->
                        <td>$<?php echo $order->order_beer_price; ?></td> <!-- end of price -->
                        
                        <!-- Quantity -->
                        <td class="text-right"><?php echo $order->order_beer_qty; ?></td> <!-- end of quantity -->
                    </tr>
                </tbody>
            </table> <!-- end of order summary -->
        </div>
        <?php
    }
    ?>
    
<?php
	$this->load->view("_partials/footer.php");
?>
<script>
    $(function() {
        $(".action_approve").click(function(e) {

            $.ajax({
                url: "<?= base_url().'order/action_approve' ?>",
                data: {order_id: $(this).attr('value')},
                dataTyep: "JSON",
                type: "POST",
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data.result);

                    if (data.result == "success") {
                        console.log(data);
                        $("#td-"+ data.id).addClass("status-approved").html("approved");

                        $("#td-detail-" + data.id).html('<a href="#" title="Details">waiting for delivery and pickup</a>')
                    }
                }
            });
            e.preventDefault();
        });
        var orderId = "";
        var deniedReason = "";
        $(".action_deny").click(function(e) {
            
            orderId = $(this).attr('value');
            $("#denied_reason").val("");
            e.preventDefault(); 
        });

        $(".denyWithReasonButton").click(function(e) {
            deniedReason = $("#denied_reason").val();
            if ($.trim(deniedReason) == "") {
                alert("Please input Deny Reason");
                return false;  
            } 
            $.ajax({
                url: "<?= base_url().'order/action_deny' ?>",
                data: {order_id: orderId, reason:deniedReason},
                dataType: "JSON",
                type: "POST",
                success: function(resp) {
                    $("#deniedReason").foundation('reveal', 'close');
                    if (resp.result == "success") {
                        $("#td-"+ resp.id).addClass("").html("Denied :" + resp.reason);
                    }
                }
            });
            e.preventDefault();
        });
    })
</script>