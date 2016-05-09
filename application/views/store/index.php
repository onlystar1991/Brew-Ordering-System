<?php
	$this->load->view("_partials/header.php");
?>
	<main id="main" class="row">
	    <?php
	    	$this->load->view("_partials/side_bar.php");
	    ?>
	    <div class="large-12 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            <!-- #stores -->
	            <div id="stores" class="content active">
	                <table class="table table--dsh">
	                	<thead>
		                    <tr>
		                        <th class="table--dsh__header">Store name</th>
		                        <th class="table--dsh__header">Address</th>
		                        <th class="table--dsh__header">Hours of Operation</th>
		                        <th class="table--dsh__header">Pictures/Logo</th>
		                        <th class="table--dsh__header">Description</th>
		                        <th class="table--dsh__header" style="width: 85px; text-align: center;">Action</th>
		                    </tr>
	                    </thead>
	                    <tbody>
                    	<?php
                    		foreach ($this->data['stores'] as $store) {
                			?>
                			<tr class="store">
                				<td class="store__name">
                					<a href="<?php echo base_url().'store/edit/'.$store->store_id; ?>" title="Top Hops Beer Shop">
                						<?php echo $store->store_name; ?>
		                        	</a>
		                       	</td>
		                        <td class="store__address">
		                           <?php echo $store->store_address; ?>
		                        </td>
		                        <td class="store__hours"><?php echo $store->store_from_monday. "&nbsp;-&nbsp;".$store->store_to_monday; ?></td>
		                        <td class="store__logo">
		                            <img src="<?php echo $store->store_logo; ?>" style="width: 50px; height: 50px;" title="Store Icon"/>
		                        </td>
		                        <td class="store__description">Top Hops is Ted Kenny's dream com true...</td>
		                        <!-- Action -->
		                        <td class="table--dsh__action-stores">
		                            <!-- Edit -->
		                            <a class="action__edit hvr-bob" href="<?php echo base_url().'store/edit/'.$store->store_id; ?>" title="Edit stores">
		                                <i class="fa fa-pencil"></i>
		                            </a> <!-- end of edit -->

		                            <!-- Remove -->
		                            <a class="action__remove hvr-bob" href="<?php echo base_url().'store/delete/'.$store->store_id; ?>" title="Delete store">
		                                <i class="fa fa-times"></i>
		                            </a> <!-- end of remove -->
		                        </td>
		                    </tr>
                			<?php
                    		}
                    	?>
	                    <!-- end of actions -->
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
	            <!-- end of #stores -->
	        </div>
	        <!-- end of tabs content -->
	    </div>
	</main>

<?php
	$this->load->view("_partials/footer.php");
?>