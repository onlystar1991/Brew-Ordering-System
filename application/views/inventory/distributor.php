<?php
	$this->load->view("_partials/header.php");
?>
	<main id="main" class="row">
	    <?php
            $this->load->view("_partials/side_bar.php");
        ?>
	    <div class="large-9 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            
	            <div id="inventory" class="content active">

                    <header class="store-action">
                        <span class="h4">&nbsp;</span>
                        
                        <!-- Actions -->
                        <ul class="no-bullet inline-list right">
                            <li><a class="button secondary" id="addBeerButton" href="#" title="Add Beer"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Beer</a></li>
                        </ul>
                    </header>
                    <article>
                    </article>
                    <form id="addBeerFrom" action="<?php echo base_url();?>inventory/saveBeer" method="post" >
                        <table class="table table--dsh" id="inventory">
                            <tr>
                                <th class="table--dsh__header">SKU</th>
                                <th class="table--dsh__header">Price</th>
                                <th class="table--dsh__header">Name</th>
                                <th class="table--dsh__header">Distributor</th>
                                <th class="table--dsh__header">Quantity</th>
                                <th class="table--dsh__header">Demand</th>
                                <th class="table--dsh__header">Status</th>
                            </tr>
                            <?php
                            $str = "";
                        	foreach($this->data['inventories'] as $inventory) {
                                $str = $str.$inventory->inventory_id."/";
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
                        				<?php 
                                        if($inventory->inventory_in_stock) {
                                            echo "in stock";  
                                        } else if ($inventory->inventory_arrive_date) {
                                                echo "arrives ".$inventory->inventory_arrive_date;    
                                            
                                        }
                                        ?>
                                    </td> <!-- end of actions -->
                        		</tr>
                        		<?php
                        	}
                            ?>
                            
                        </table>
                    </form>
                    <!-- Stores pagination -->
                        <a class="button alert" href="<?php echo base_url();?>inventory/edit/<?php echo $str;?>" title="Edit" style="margin-left: 76%;position: absolute;"><i class="fa fa-pencil"></i> Edit</a>
                        
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

	    </div>
	</main>

<?php
	$this->load->view("_partials/footer.php");
?>
<script>
    $(function() {
        $("#addBeerButton").click(function() {
            var html =  "<tr>" + 
                            "<td>" +
                                "<input type='text' id='td-sku' value='' name='sku' />" + 
                            "</td>" + 
                        
                            "<td>" +
                                "<input type='text' id='td-price' value='' name='price' />" +
                            "</td>" +
                        
                            "<td>" +
                                "<input type='text' id='td-name' value='' name='name' />" +
                            "</td>" +
                        
                            "<td>" +
                                "<input type='text' id='td-distributor' value='' name='distributor' />" +
                            "</td>" +
                        
                            "<td>" +
                                "<input type='number' id='td-quantity' value='' name='quantity' />" +
                            "</td>" +
                        
                            "<td>" +
                                "<input type='text' id='td-demand' value='' name='demand' />" +
                            "</td>" +
                            
                            "<td>" +
                                "<a href='#'' id='saveBeer' class='button secondary' style='margin: 0;'> Save </a>" +
                            "</td>" +
                        "</tr>";

            $("#inventory tbody").append(html);
            $("#saveBeer").click(function(e) {
                var isValid = true;
                if ($.isNumeric($("#td-sku").val()) && $.isNumeric($("#td-price").val()) && $.isNumeric($("#td-quantity").val()) && $.isNumeric($("#td-demand").val())) {
                    isValid = true;
                } else {
                    isValid = false;
                }
                if (!isValid) {
                    alert("Please input correct values");
                    return false;
                } else {
                    $("#addBeerFrom").submit();
                }
            });
        });
    })
</script>