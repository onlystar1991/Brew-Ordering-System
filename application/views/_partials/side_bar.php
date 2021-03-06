<div id="menu-bar" class="column">
<!-- #sidenav -->
	<ul id="sidenav" class="tabs vertical">
		<?php if (user_can(UP_STORE_ALL) || user_can(UP_STORE_VIEW)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'store')? 'active': ''; ?>">
	        <a class="tab-stores" href="<?= base_url()?>store" title="Stores">
	            <span class="icon"></span> Stores</a>
	    </li>
	    <?php } if (user_can(UP_INVENTORY_ALL) || user_can(UP_INVENTORY_VIEW)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'inventory')? 'active': ''; ?>">
	        <a class="tab-inventory" href="<?= base_url()?>inventory" title="Inventory">
	            <span class="icon"></span> Inventory</a>
	    </li>
	    <?php } if (user_can(UP_ORDER_ALL) || user_can(UP_ORDER_VIEW)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'order')? 'active': ''; ?>">
	        <a class="tab-orders" href="<?= base_url()?>order" title="Orders">
	            <span class="icon"></span> Orders</a>
	    </li>
	    <?php } if (user_can(UP_DASHBOARD_ALL)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'dashboard')? 'active': ''; ?>">
	        <a class="tab-dashboard" href="<?= base_url()?>dashboard" title="Dashboard">
	            <span class="icon"></span> Dashboard</a>
	    </li>
	    <?php } if (user_can(UP_DISTRIBUTOR_ALL) || user_can(UP_DELIVERY_ALL)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'distributor')? 'active': ''; ?>">
	        <a class="tab-distributor" href="<?= base_url()?>distributor" title="Distributor">
	            <span class="icon"></span> <?php echo ($this->session->userdata("role") == UR_DISTRIBUTOR) ? "Delivery" : "Distributor" ?>
	        </a>
	    </li>
	    <?php } if (user_can(UP_MARKETING_ALL)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'marketing')? 'active': ''; ?>">
	        <a class="tab-marketing" href="<?= base_url()?>marketing" title="Marketing">
	            <span class="icon"></span> Marketing</a>
	    </li>
	    <?php } if (user_can(UP_ALL)) { ?>
	    <li class="tab-title <?php echo ($this->data['page'] == 'users')? 'active': ''; ?>">
	        <a class="tab-users" href="<?= base_url()?>users" title="Users">
	            <span class="icon"></span> Users</a>
	    </li>
	    <?php } ?>
	</ul>
	<ul id="sidebottomnav" class="tabs vertical">
		<li class="tab-title <?php echo ($this->data['page'] == 'chat')? 'active': ''; ?>">
	        <a class="tab-chat" href="<?= base_url()?>chat" title="Chat">
	            <span class="icon"></span> Chat</a>
	    </li>
	    <li class="tab-title <?php echo ($this->data['page'] == 'help')? 'active': ''; ?>">
	        <a class="tab-help" href="<?= base_url()?>help" title="Help">
	            <span class="icon"></span> Help</a>
	    </li>
	</ul>
<!-- end of #sidenav -->
</div>