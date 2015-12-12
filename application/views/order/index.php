<?php
	$this->load->view("_partials/header.php");
	$orders = $this->data['orders'];
    $inStocks = $this->data['instocks'];
    $distributors = $this->data['distributors'];
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
                            </tr>
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
                                    if($order->order_isAproved) {
                                        ?>
                                        <td id="td-<?php echo $order->order_id;?>" class='has-details'><a href='#' data-reveal-id='orderDetails<?php echo $order->order_id;?>' title='Details'>details</a></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td id="td-<?php echo $order->order_id;?>" class='status-waiting'>waiting for delivery and pickup</td>
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

    <?php
        foreach($orders as $order) {
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
                                <td><?php echo $order->order_beer_price?"$".$order->order_beer_price:""; ?></td> <!-- end of price -->
                                
                                <!-- Quantity -->
                                <td class="text-right"><?php echo $order->order_beer_qty; ?></td> <!-- end of quantity -->
                            </tr>
                        </tbody>
                    </table> <!-- end of order summary -->

                    <!-- Actions -->
                    <ul class="no-bullet inline-list action-group" style="margin-bottom: 0;">
                        <li><a id="<?php echo $order->order_id;?>" class="button lnk-orderDetails secondary" href="#" data-details>Check inventory and distributor</a></li>
                    </ul> <!-- end of actions -->
                    
                    <!-- 
                        FULL ORDER DETAIL
                    -->
                    <article id="orderFullDetails<?php echo $order->order_id;?>" class="full-details">
                        <!-- IN STOCK -->
                        <article>
                            <!-- Legend -->
                            <h5>IN STOCK</h5> <!-- endo of legend -->
                            
                            <!-- In stock summary -->
                            <table class="order-summary">
                                <thead>
                                    <tr>
                                        <th>Beer Name</th>
                                        <th>Price</th>
                                        <th class="text-right">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($inStocks as $row) {
                                        if ($order->order_beer_name != $row->inventory_name) continue;
                                        ?>
                                        <tr>
                                            <!-- Beer name -->
                                            <td><?php echo $row->inventory_name; ?></td> <!-- end of beer name -->
                                            
                                            <!-- Price -->
                                            <td><?php echo $row->inventory_price; ?></td>
                                            <!-- Quantity -->
                                            <td class="text-right"><?php echo $row->inventory_quantity; ?></td> <!-- end of quantity -->
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table> <!-- end of in stock summary -->
                        </article> <!-- END OF IN STOCK -->
                        
                        <!-- ORDER  -->
                        <article>
                            <!-- Legend -->
                            <h5>Order</h5> <!-- endo of legend -->
                            
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
                                    <?php
                                    foreach($distributors as  $distributor) {
                                        if ($distributor->distributor_name != $order->order_beer_name) {
                                            continue;
                                        }
                                        ?>
                                        <tr>
                                            <!-- Beer name -->
                                            <td><?php echo $order->order_beer_name; ?></td> <!-- end of beer name -->
                                            
                                            <!-- Price -->
                                            <td><?php echo $order->order_beer_price; ?></td> <!-- end of price -->
                                            
                                            <!-- Quantity -->
                                            <td class="text-right"><?php echo $order->order_beer_qty; ?></td> <!-- end of quantity -->
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table> <!-- end of order summary -->
                        </article> <!-- END OF ORDER -->
                        
                        <!-- Actions -->
                        <ul class="no-bullet inline-list action-group">
                            <!-- Finalize action -->
                            <li>
                                <a href="#" class="button secondary orderFinalize" value="<?php echo $order->order_id; ?>" title="Finalize">Finalize</a>
                            </li> <!-- end of finalize action -->

                            <!-- Order action -->
                            <li>
                                <a class="button" href="#" title="Order">Order</a>
                            </li> <!-- end of order action -->
                        </ul> <!-- end of actions -->
                    </article> <!-- END OF FULL ORDER DETAILS -->
                </div>
            <?php
        }
    ?>
<?php
	$this->load->view("_partials/footer.php");
?>
<script>
    $(function() {
        $(".orderFinalize").click(function(e) {
            var id = $(this).attr("value");

            $.ajax({
                url: "<?= base_url().'order/finalizeOrder' ?>",
                data: {order_id: id},
                dataTyep: "JSON",
                type: "POST",
                success: function(response) {

                    var data = JSON.parse(response);
                    if (data.result == "success") {
                        $("#td-" + data.id).addClass("status-waiting");
                        $("#td-" + data.id).html("waiting for delivery and pickup");
                        $("#orderDetails" + data.id).foundation('reveal', 'close');
                    }
                }
            });
            e.preventDefault();
        })
    })
</script>