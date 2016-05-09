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
                    <!-- List of distributors -->
                    <table class="table table--dsh">
                        <thead>
                            <tr>
                                <th class="table--dsh__header">Distributor Name</th>
                                <th class="table--dsh__header">Location</th>
                                <th class="table--dsh__header">Phone Number</th>
                                <th class="table--dsh__header">Contact Name</th>
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
                                    <a class="lnk-underlined" href="<?php echo base_url()."distributor/view/".$distributor->distributor_id;?>" title="<?= $distributor->distributor_name ?>"><?= $distributor->distributor_name ?></a>
                                </td>
                                <td>
                                    <?= $distributor->distributor_location ?>
                                </td>
                                <td>
                                    <?= $distributor->distributor_phone ?>
                                </td>
                                <td>
                                    <?= $distributor->distributor_contact ?>
                                </td>
                            </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

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