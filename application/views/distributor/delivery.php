<?php
	$this->load->view("_partials/header.php");
	$distributors = $this->data['distributors'];
?>
	<main id="main" class="row">
	    <?php
	    	$this->load->view("_partials/side_bar.php");
	    ?>
	    <div class="large-12 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            <!-- Distributor -->
                <div id="distributor" class="content active">

                    <table class="table table--dsh">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Store</td>
                                <td>Price</td>
                                <td>Delivery ETA</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                                foreach ($distributors as $distributor) { 
                                    $i++;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?>
                                        </td>
                                        <td>
                                            <?php echo $distributor->delivery_store; ?>
                                        </td>
                                        <td>
                                            $<?php echo $distributor->delivery_price; ?>
                                        </td>
                                        <td>
                                            <input type="text" class="delivery_eta" text="<?php echo $distributor->delivery_id; ?>" value="<?php echo $distributor->delivery_eta; ?>">
                                        </td> 
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>

                    <!-- List of distributors -->
                    <ul class="no-bullet">

                	<?php
                		foreach ($distributors as $distributor) {
                			?>
                			<li>
                				<a class="lnk-underlined" href="<?php echo base_url()."distributor/view/".$distributor->distributor_id;?>" title="<?= $distributor->distributor_name ?>"><?= $distributor->distributor_name ?></a>
                			</li>
                			<?php
                		}
                	?>
                    </ul> <!-- end of list distributors -->
                </div>

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
			<!-- end of tabs content -->
	    </div>
	</main>

<?php
	$this->load->view("_partials/footer.php");
?>

<script>
    $(function() {

        $(".delivery_eta").datepicker();
        
        $(".delivery_eta").change(function() {
            var delivery_id = $(this).attr("text");

            $.ajax({
                url: "<?= base_url().'distributor/save_eta' ?>",
                data: {delivery_id: delivery_id, value: $(this).val()},
                dataTyep: "JSON",
                type: "POST",
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data.result);
                    if (data.result == "success") {
                        console.log(data);
                    }
                }
            });
        });
    })
</script>