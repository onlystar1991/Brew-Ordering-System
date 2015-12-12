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
	            
	            <!-- Marketing-->
                <div id="marketing" class="content active">
                    <form id="newCampaign" action="<?php echo base_url()."marketing/create" ?>" method="post">
                        <!--
                            ACTION
                        -->
                        <input type="hidden" name="marketingId" value="<?php echo $marketing->marketing_id; ?>" />
                        <header class="store-action">
                            <span class="h4">&nbsp;</span>
                            <a class="h4" href="<?php echo base_url()."marketing/" ?>" title="Back to marketing"><i class="fa fa-angle-left"></i> Back to Marketing</a>
                            <!-- Actions -->
                            <ul class="no-bullet inline-list right">
                                <li><button class="secondary" type="submit"><i class="fa fa-check"></i> &nbsp; Save</button></li>    
                            </ul> <!-- end of: Actions -->
                        </header> <!-- end of: ACTION -->

                        <!-- New campaign details -->
                        <article>
                            <h3 title="New campaign">New campaign</h3>
                            <!-- .fieldset -->
                            <section class="fieldset">
                                <!-- Campaign name -->
                                <div class="row">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="campaignName">Campaign name</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <input id="campaignName" name="campaignName"  type="text" placeholder="Campaign name" value="" />
                                    </div>
                                </div> <!-- end of: Campaign name -->
                                
                                <!-- Locations -->
                                <div class="row select-locations">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="locations">Locations</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                    	
                                        <select id="locations" class="chosen-select" name="locations" multiple data-placeholder="Locations">
                                            <option value="usa" >USA</option>
                                            <option value="africa" >AFRICA</option>
                                            <option value="mexico" > >MEXICO</option>
                                            <option value="philippines" >PHLIPPINES</option>
                                            <option value="vietnam" >VIETNAM</option>
                                            <option value="china" >CHINA</option>
                                            <option value="uk">UK</option>
                                            <option value="japan" >JAPAN</option>
                                            <option value="korea" >KOREA</option>
                                            <option value="brazil">BRAZIL</option>
                                            <option value="bolivia">BOLIVIA</option>
                                        </select>
                                    </div>
                                </div> <!-- end of: Locations -->
                                
                                <!-- Schedule -->
                                <div class="row schedule">
                                    <div class="large-2 small-4 column">
                                        <label class="inline">Schedule</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <div class="row">
                                            <!-- Start date -->
                                            <div class="small-2 column">
                                                <label class="inline" for="startDate">
                                                    start
                                                </label>
                                            </div>
                                            <div class="small-4 column date">
                                                <input id="startDate" name="startDate" 
                                                       type="text" value=""/>
                                                
                                                <a class="icon-calendar" href="#" title="Start date"><i class="fa fa-calendar"></i></a>
                                            </div>
                                            <!-- end of: Start date -->
                                            
                                            <!-- Start time -->
                                            <div class="small-2 column">
                                                <label class="inline text-center" for="startTime">
                                                    at
                                                </label>
                                            </div>
                                            <div class="small-4 column">
                                                <input id="startTime" name="startTime" type="time" value=""/>
                                            </div>
                                            <!-- end of: Start time -->
                                        </div>
                                        
                                        <div class="row">
                                            <!-- End date -->
                                            <div class="small-2 column">
                                                <label class="inline" for="endDate">
                                                    end
                                                </label>
                                            </div>
                                            <div class="small-4 column date">
                                                <input id="endDate" name="endDate" type="text" value=""/>
                                                
                                                <a class="icon-calendar" href="#" title="End date"><i class="fa fa-calendar"></i></a>
                                            </div>
                                            <!-- end of: End date -->
                                            
                                            <!-- End time -->
                                            <div class="small-2 column">
                                                <label class="inline text-center" for="endTime">
                                                    at
                                                </label>
                                            </div>
                                            <div class="small-4 column">
                                                <input id="endTime" name="endTime" type="time" value=""/>
                                            </div>
                                            <!-- end of: End time -->
                                        </div>
                                    </div>
                                </div> <!-- end of: Schedule -->
                                
                                <!-- Headline -->
                                <div class="row">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="headline">Headline</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <input id="headline" name="headline" type="text" placeholder="Headlines" value=""/>
                                    </div>
                                </div> <!-- end of: Headline -->
                                
                                <!-- Text -->
                                <div class="row">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="text">Text</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <textarea id="text" name="text" placeholder="Text" rows="6">
                                        	
                                        </textarea>
                                    </div>
                                </div> <!-- end of: Text -->
                                
                                <!-- Image URL -->
                                <div class="row">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="imageURL">Image URL</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <input id="imageURL" name="imageURL" type="url" placeholder="Image URL" value=""/>
                                    </div>
                                </div> <!-- end of: Image URL -->
                                
                                <!-- Video URL -->
                                <div class="row">
                                    <div class="large-2 small-4 column">
                                        <label class="inline" for="videoURL">Video URL</label>
                                    </div>
                                    <div class="large-5 small-8 column end">
                                        <input id="videoURL" name="videoURL" type="url" placeholder="Video URL" value=""/>
                                    </div>
                                </div> <!-- end of: Video URL -->
                                
                                <!-- Call to action -->
                                <div class="row">
                                    <div class="large-5 large-offset-2 small-8 small-offset-4 column end">
                                        <button  class="button dropdown secondary li-item " data-dropdown="cta" aria-controls="cta" aria-expanded="false">Call to action</button>
                                        <ul id="cta" data-dropdown-content class="f-dropdown" aria-hidden="true">
                                            <li><a href="#" title="Buy Now">BUY NOW</a></li>
                                            <li><a href="#" title="Get Offer">GET OFFER</a></li>
                                            <li><a href="#" title="Newly Released">NEWLY RELEASED</a></li>
                                            <li><a href="#" title="News on Tap">NEWS ON TAP</a></li>
                                        </ul>  
                                    </div>
                                </div> <!-- end of: Call to action -->
                            </section> <!-- end of: .fieldset -->
                        </article> <!-- end of: New campaign details -->
                    </form>
                </div> <!-- end of #marketing -->
	        </div>
	        <!-- end of tabs content -->
	    </div>
	</main>
<?php
	$this->load->view("_partials/footer.php");
?>