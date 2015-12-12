<div class="large-3 medium-3 column">
<!-- #sidenav -->
	<ul id="sidenav" class="tabs vertical">

	    <li class="tab-title <?php echo ($this->data['page'] == 'store')? 'active': ''; ?>">
	        <a class="tab-stores" href="<?= base_url()?>store" title="Stores">
	            <span class="icon"></span> Stores</a>
	    </li>
	    <li class="tab-title <?php echo ($this->data['page'] == 'inventory')? 'active': ''; ?>">
	        <a class="tab-inventory" href="<?= base_url()?>inventory" title="Inventory">
	            <span class="icon"></span> Inventory</a>
	    </li>
	    <li class="tab-title <?php echo ($this->data['page'] == 'order')? 'active': ''; ?>">
	        <a class="tab-orders" href="<?= base_url()?>order" title="Orders">
	            <span class="icon"></span> Orders</a>
	    </li>
	    <li class="tab-title <?php echo ($this->data['page'] == 'distributor')? 'active': ''; ?>">
	        <a class="tab-distributor" href="<?= base_url()?>distributor" title="Distributor">
	            <span class="icon"></span> <?php echo ($this->session->userdata("permission") == "distributor") ? "Delivery" : "Distributor" ?>
	        </a>
	    </li>
	</ul>
<!-- end of #sidenav -->
</div>