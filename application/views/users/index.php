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

	                <table class="table table--dsh">
	                	<thead>
		                    <tr>
		                        <th class="table--dsh__header">Business Name</th>
		                        <th class="table--dsh__header">Contact Name</th>
		                        <th class="table--dsh__header">Email</th>
		                        <th class="table--dsh__header">Phone</th>
		                        <th class="table--dsh__header">Business Type</th>
		                        <th class="table--dsh__header" style="width: 85px; text-align: center;">Action</th>
		                    </tr>
	                    </thead>
	                    <tbody>
                    	<?php
                    		foreach ($this->data['users'] as $user) {
                			?>
                			<tr>
                				<td>
                					<?php echo $user->business_name; ?>
		                       	</td>
		                        <td>
		                           <?php echo $user->user_name; ?>
		                        </td>
		                        <td>
		                        	<?php echo $user->user_email; ?>
		                        </td>
		                        <td>
		                            <?php echo $user->user_phone; ?>
		                        </td>
		                        <td>
		                        	<?php echo $user->business_type; ?>
		                        </td>
		                        <!-- Action -->
		                        <td class="table--dsh__action-users">
		                            <!-- Edit -->
		                            <a class="button secondary" href="<?php echo base_url().'users/approve/'.$user->user_id; ?>" title="Approve">
		                                Approve
		                            </a>
		                            <a class="button" href="<?php echo base_url().'users/deny/'.$user->user_id; ?>" title="Deny">
		                                Deny
		                            </a>
		                        </td>
		                    </tr>
                			<?php
                    		}

                    		if (count($this->data['users']) == 0) {?>
                    		<tr>
                    			<td colspan="10">Sorry, There is no data to show.</td>
                    		</tr>
                    	<?php }
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