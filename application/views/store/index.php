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
	            <!-- #stores -->
	            <div id="stores" class="content active">

	            	<header class="store-action">
                        <span class="h4">&nbsp;</span>
                        
                        <!-- Actions -->
                        <ul class="no-bullet inline-list right">
                            <li><a class="button secondary" id="addStoreButton" href="<?php echo base_url().'store/add/'; ?>" title="Add Store"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Store</a></li>
                        </ul>
                    </header>
                    <article>
                    </article>

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
                					<a href="<?php echo base_url().'store/detail/'.$store->store_id; ?>" title="Top Hops Beer Shop">
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
		                            <a class="action__remove hvr-bob" href="#" data-reveal-id='deleteStore<?php echo $store->store_id;?>' title="Delete store">

		                            	<!-- base_url().'store/delete/'.$store->store_id; -->
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
        foreach ($this->data['stores'] as $store) {
            ?>
	<div id="deleteStore<?php echo $store->store_id;?>" class="reveal-modal text-center" data-reveal aria-labelledby="storeTitle"
        aria-hidden="true" role="dialog">
        
        <!-- Store icon: favicon.png -->
        <img class="favicon" src="<?php echo asset_base_url();?>/images/favicon.png" alt="notibrew" title="notibrew"/> <!-- end of store icon -->
        
        <!-- Title message -->
        <h4 id="storeTitle" class="title">Are you sure you want to delete this store?</h4> <!-- end of title message -->
        <p></p>
        <ul class="no-bullet inline-list action-group">
            <!-- Delete action -->
            <li>
                <a href="<?php echo base_url().'store/delete/'.$store->store_id;?>" class="button" title="Yes">YES</a>
            </li> <!-- end of finalize action -->

            <!-- Cancel action -->
            <li>
                <a class="button secondary close-reveal-modal" href="#" title="No">NO</a>
            </li> <!-- end of order action -->
        </ul> <!-- end of actions -->
    </div>
            <?php
        }
    ?>
<?php if ($this->data['regStoreId']) {?>
    <div id="registerStore" class="opened reveal-modal text-center" data-reveal aria-labelledby="storeTitle"
        aria-hidden="true" role="dialog">
        
        <!-- Store icon: favicon.png -->
        <img class="favicon" src="<?php echo asset_base_url();?>/images/favicon.png" alt="notibrew" title="notibrew"/> <!-- end of store icon -->
        
        <!-- Title message -->
        <h5 id="storeTitle" class="title">Thank you, your <a class="link" href="<?php echo base_url().'store/detail/'.$this->data['regStoreId'];?>"><?php echo $this->data['regStoreName'];?></a> has been added in a line to be verified and added. We will contact you before we publish it to the community. Any questions please email shawn@notibrew.com</h5> <!-- end of title message -->
        <p></p>
                <a class="button close-reveal-modal secondary" title="OK">OK</a>
        </ul> <!-- end of actions -->
    </div>
    
<?php } ?>
<?php
	$this->load->view("_partials/footer.php");
?>
<script>
    $(document).ready(function(){
    	$("#registerStore").foundation('reveal', 'open');
    });
    </script>