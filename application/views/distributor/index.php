<?php
	$this->load->view("_partials/header.php");
	$distributors = $this->data['distributors'];
?>
	<main id="main" class="row">
	    <?php
	    	$this->load->view("_partials/side_bar.php");
	    ?>
	    <div class="large-9 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            <!-- Distributor -->
                <div id="distributor" class="content active">
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