<?php
	$this->load->view("_partials/header.php");
?>
	<main id="main" class="row">
	    <?php
            $this->load->view("_partials/side_bar.php");
        ?>
	    <div class="large-12 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            
	            <div id="inventory" class="content active">
                    <table class="table table--dsh">
                        <thead>
                            <tr>
                                <th class="table--dsh__header">SKU</th>
                                <th class="table--dsh__header">Price</th>
                                <th class="table--dsh__header">Name</th>
                                <th class="table--dsh__header">Distributor</th>
                                <th class="table--dsh__header">Quantity</th>
                                <th class="table--dsh__header">Demand</th>
                                <th class="table--dsh__header" style="text-align: center;"></th>
                                <th class="table--dsh__header" style="text-align: center;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                    	foreach($this->data['inventories'] as $inventory) {
                    		?>
                    		<tr>
                    			<td>
                    				<?php echo $inventory->inventory_sku; ?>
                    			</td>
                    		
                    			<td>
                    				<?php echo $inventory->inventory_price; ?>
                    			</td>
                    		
                    			<td>
                    				<?php echo $inventory->inventory_name; ?>
                    			</td>
                    		
                    			<td>
                    				<?php echo $inventory->inventory_distributor; ?>
                    			</td>
                    		
                    			<td>
                    				<?php echo $inventory->inventory_quantity; ?>
                    			</td>
                    		
                    			<td>
                    				<?php echo $inventory->inventory_demand; ?>
                    			</td>
                    		
                    			<td>
                    				<a class="action__edit hvr-bob" href="<?php echo base_url().'inventory/edit/'.$inventory->inventory_id; ?>" title="Edit Inventory">
		                                <i class="fa fa-pencil"></i>
		                            </a> <!-- end of edit -->
                    			</td>
                    		
                    			<td class="table--dsh__action">
                                    <!-- Order action -->
                                    <a class="button secondary right" href="#" title="Order">
                                        <i class="fa fa-plus"></i> Order
                                    </a> <!-- end of order action -->
                                </td> <!-- end of actions -->
                    		</tr>
                    		<?php
                    	}
                        if (count($this->data['inventories']) == 0) {?>
                            <tr>
                                <td colspan="10">Sorry, There is no data to show.</td>
                            </tr>
                        <?php }
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
                </div>

	        </div>
	        <!-- end of tabs content -->
	    </div>
	</main>

<?php
	$this->load->view("_partials/footer.php");
?>