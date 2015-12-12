<?php
	$this->load->view("_partials/header.php");
	$marketings = $this->data['marketings'];
?>
	<main id="main" class="row">
	    <?php
            $this->load->view("_partials/side_bar.php");
        ?>
	    <div class="large-9 medium-8 column">
	        <!-- Tabs content -->
	        <div id="main-content" class="tabs-content">
	            <!-- Marketing-->
                                <div id="marketing" class="content active">
                                    <!--
                                        MARKETING VIEW ACTION
                                    -->
                                    <header class="store-action">
                                        <span class="h4">&nbsp;</span>
                                        
                                        <!-- Actions -->
                                        <button  class="button dropdown alert li-item right " data-dropdown="drop1" aria-controls="drop1" aria-expanded="false">Orders</button>
                                        <ul id="drop1" data-dropdown-content class="f-dropdown" aria-hidden="true">
                                            <li><a href="#" title="Day">DAY</a></li>
                                            <li><a href="#" title="Month">MONTH</a></li>
                                            <li><a href="#" title="Year">YEAR</a></li>
                                            <li><a href="#" title="Region">REGION</a></li>
                                        </ul>  
                                        
                                        <ul class="no-bullet inline-list right">
                                            <li>
                                            	<a class="button secondary" href="<?php echo base_url()."marketing/add"; ?>" title="Create">
                                            		<i class="fa fa-plus"></i>&nbsp;&nbsp;Create
                                            	</a>
                                            </li>    
                                        </ul> <!-- end of: Actions -->
                                        
                                    </header> <!-- end of: MARKETING VIEW ACTION -->
                                    
                                    <article>
                                        <table class="table table--dsh">
                                            <thead>
                                                <tr>
                                                    <th>Campaign Name</th>
                                                    <th>Conversion</th>
                                                    <th>Reach</th>
                                                    <th>End Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php
                                            	foreach ($marketings as $marketing) {
                                            		?>
                                            		<tr>
                                            			<td>
                                            				<?php echo $marketing->marketing_name; ?>
                                            			</td>
                                            			<td>
                                            				<?php echo $marketing->marketing_convention; ?>
                                            			</td>
                                            			<td>
                                            				<?php echo $marketing->marketing_reach; ?>
                                            			</td>
                                            			<td>
                                            				<?php echo $marketing->marketing_end_date; ?>
                                            			</td>
	                                            			<!-- Action -->
	                                                    <td class="text-center">
	                                                        <!-- Edit -->
	                                                        <a class="action__edit hvr-bob" href="<?php echo base_url().'marketing/edit/'.$marketing->marketing_id; ?>" title="Edit campaign">
	                                                            <i class="fa fa-pencil"></i>
	                                                        </a> <!-- end of edit -->
	                                                        <!-- Remove -->
	                                                        <a class="action__remove hvr-bob" href="<?php echo base_url().'marketing/edit/'.$marketing->marketing_id; ?>" data-reveal-id="deleteCampaign" title="Delete campaign">
	                                                            <i class="fa fa-times"></i>
	                                                        </a> <!-- end of remove -->
	                                                    </td> <!-- end of: Action -->
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
                                    </article>
                                </div> <!-- end of #marketing -->
	        </div>
	        <!-- end of tabs content -->
	    </div>
	</main>

<?php
	$this->load->view("_partials/footer.php");
?>