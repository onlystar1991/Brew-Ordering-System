<?php
	$this->load->view("_partials/header.php");

	$hours = array("1am", "2am","3am", "4am","5am", "6am","7am", "8am","9am", "10am","11am", "12pm","1pm", "2pm","3pm", "4pm","5pm", "6pm","7pm", "8pm","9pm", "10pm","11pm", "12am");
	$store = $this->data['store'];
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
                    
                    <form action="<?php echo base_url(); ?>store/save" method="post" enctype="multipart/form-data">
                        <header class="store-action">
                            <!-- Back button -->
                            <a class="h4" href="<?= base_url() ?>store/" title="Back to store"><i class="fa fa-angle-left"></i> Back to store</a> <!-- end of back button -->

                            <!-- Actions -->
                            <ul class="no-bullet inline-list right">
                                <li>
                                	<a href="<?php echo base_url().'store/edit/'.$store->store_id; ?>" class="button secondary" title="Edit">
                                		<i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                                	</a>
                                </li>
                                <li>
                                	<button class="button" data-reveal-id='deleteStore<?php echo $store->store_id;?>' title="">
                                		<i class="fa fa-times"></i>&nbsp;&nbsp;Delete
                                	</button>
                                </li>
                            </ul>
                        </header> <!-- END OF STORE EDIT ACTION -->
                        <input type="hidden" name="store_id" value="<?php echo $store->store_id; ?>"
                        <!-- Store details -->
                        <article class="store-details">
                            <div class="row">
                                <!-- Store name -->
                                <input id="storeName" class="h3" name="storeName" type="text" 
                                       placeholder="Store name"
                                       data-autosize-input="{ 'space': 0 }"
                                       value="<?php echo $store->store_name; ?>" style="background:transparent;border:0;padding-left:0" disabled="disabled"/> <!-- end of store name -->

                                <!-- Store address -->
                                <div class="store__address">
	                                <input id="storeAddress" name="storeAddress" type="text" 
	                                       placeholder="Address"
	                                       data-autosize-input="{ 'space': 0 }"
	                                       value="<?php echo $store->store_address; ?>" style="background:transparent;border:0;padding-left:0" disabled="disabled"/> <!-- end of store address -->
                                </div>
                                <!-- Store schedule -->
                                <ul class="store__schedule no-bullet">
                                    <li>
                                        <span class="store__day">Mo</span>
                                        <span class="store__time">
	                                        	<?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_monday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_monday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">Tu</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_tuesday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_tuesday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">We</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_wednesday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_wednesday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">Th</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_thursday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_thursday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">Fr</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_friday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_friday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">Sa</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_saturday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_saturday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="store__day">Su</span> 
                                        <span class="store__time">
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_from_sunday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                            - 
                                            
                                                <?php
	                                        	for($i = 0; $i < 24; $i++) {
	                                        		if (strtolower($store->store_to_sunday) == $hours[$i]) {
	                                        			?>
	                                        			<?php echo $hours[$i];?>
	                                        			<?php
	                                        		}
	                                        	}
	                                        	?>
                                        </span>
                                    </li>
                                </ul> <!-- end of store schedule -->

                                <div class="large-6 column store__description">
                                    <!-- Store description -->
                                    <textarea id="storeDescription" name="storeDescripton" placeholder="Description" rows="6" style="background:transparent;border:0" disabled="disabled"><?php echo $store->store_description; ?></textarea>
                                </div>

                                <!-- Clearfix -->
                                <div class="clearfix"></div> <!-- end of clearfix -->

                                <!-- Store logo -->
                                <div class="photo-wrapper" style="width: 100px; height: 80px;">
                                    <input type="text" value="Logo" style="border: 0px; padding-left: 0px; text-align: left !important; width: 277px; background: transparent;" disabled="disabled">
                                    <img class="th photo" id="img_store_logo" src="<?php echo $store->store_logo; ?>" style="max-width: 70px !important; max-height: 70px !important;" alt="" title="Top Hops Beer Shop"/>

                                     <!-- Delete action -->
                                </div> <!-- end of store logo -->

                                <!-- Clearfix -->
                                <p class="clearfix"></p> <!-- end of clearfix -->

                                <!-- Store photos -->
                                <article class="store__photos">
                                	<input type="text" value="Photos" style="border: 0px; padding-left: 0px; text-align: left !important; width: 277px; background: transparent;" disabled="disabled">
                                    <article class="photos">
                                        <div class="photo-wrapper" style="width: 150px; min-height: 100px;">
											<img class="th photo" id="img_store_image1" src="<?php echo $store->store_image1; ?>" style="max-width: 150px !important; max-height: 250px !important;" alt=""/>
                                        </div> 

                                        <div class="photo-wrapper" style="width: 150px; min-height: 100px;">
                                        	
                                            <img class="th photo" id="img_store_image2" src="<?php echo $store->store_image2; ?>" style="max-width: 150px !important; max-height: 250px !important;" alt=""/>
                                        </div> 
                                    </article>

                                    <!-- Clearfix -->
                                    <p class="clearfix"></p> <!-- end of clearfix -->

                                </article> <!-- end of store photos -->
                            </div>
                        </article> <!-- end of store details -->
                    </form>
                </div> <!-- end of #stores -->
	            <!-- end of #stores -->
	        </div>
	        <!-- end of tabs content -->
	    </div>
	</main>

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
	$this->load->view("_partials/footer.php");
?>
<script>
$(function() {
    var fileUpload_changed = 0;
    $("#file_upload_span").click(function() {
        $( "#file-upload-dialog" ).dialog();
    });

    //If there is file element having src, that element will be hidden
    if ($.trim($("#img_store_logo").attr("src")) != "") {
        $("#div-icon-upload").css("display", "none");
    }
    if ($.trim($("#img_store_image1").attr("src")) != "") {
        $("#div-image1-upload").css("display", "none");
    }
    if ($.trim($("#img_store_image2").attr("src")) != "") {
        $("#div-image2-upload").css("display", "none");
    }
    
    $("#delete_store_logo").click(function(e) {
        fileUpload_changed++;
        $("#img_store_logo").attr("src", "");
        
        $("#div-icon-upload").css("display", "block");
        
        $("#file_upload_span").show();

        $("#deleteIcon").val(1);
        e.preventDefault();
    })
    $("#delete_store_image1").click(function(e) {
        fileUpload_changed++;
        $("#img_store_image1").attr("src", "");
        
        $("#div-image1-upload").css("display", "block");

        $("#file_upload_span").show();
        $("#deleteStoreImage1").val(1);
        e.preventDefault();
    })

    $("#delete_store_image2").click(function(e) {
        fileUpload_changed++;
        $("#img_store_image2").attr("src", "");
        $("#div-image2-upload").css("display", "block");
        $("#file_upload_span").show();
        $("#deleteStoreImage2").val(1);
        e.preventDefault();
    });

    $("#div-icon-upload").click(function(e) {
        $("#file_store_icon").click();
        e.preventDefault();
    });

    $("#file_store_icon").change(function() {
        $("#div-icon-upload").text("Store Icon: Selected!");
        $("#logo_title").text($(this).val());
    })

    $("#div-image1-upload").click(function(e) {
        $("#file_store_image1").click();
        e.preventDefault();
    });

    $("#file_store_image1").change(function(e) {
        $("#div-image1-upload").text("Store Image1: Selected!");
        $("#image1_title").text($(this).val());
    });

    $("#div-image2-upload").click(function(e) {
        $("#file_store_image2").click();

        e.preventDefault();
    });
    $("#file_store_image2").change(function() {
        $("#div-image2-upload").text("Store Image2: Selected!");
        $("#image2_title").text($(this).val());
        alert($(this).val());
    });
});
</script>