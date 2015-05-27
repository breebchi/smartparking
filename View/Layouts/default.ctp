

  <?php
  	
	  	echo $this->Html->css('/admin_assets/bs3/css/bootstrap.min')."\n";
	  	echo $this->Html->css('/admin_assets/js/jquery-ui/jquery-ui-1.10.1.custom.min')."\n";
	  	echo $this->Html->css('/admin_assets/css/bootstrap-reset')."\n";
	  	echo $this->Html->css('/admin_assets/css/style-responsive')."\n";
	  	echo $this->Html->css('/admin_assets/css/style')."\n";
	  	echo $this->Html->css('/admin_assets/js/morris-chart/morris')."\n";
	  	echo $this->Html->css('/admin_assets/js/css3clock/css/style')."\n";
	  	echo $this->Html->css('/admin_assets/css/clndr')."\n";
	  	echo $this->Html->css('/admin_assets/js/jvector-map/jquery-jvectormap-1.2.2')."\n";
	  	echo $this->Html->css('/admin_assets/font-awesome/css/font-awesome')."\n";
	  	echo $this->Html->css('/admin_assets/css/bootstrap-reset')."\n";
	  	
	  	
		echo $this->Html->script('/admin_assets/ajax.googleapis.com/jquery.min')."\n";
		echo $this->Html->script('/admin_assets/ajax.googleapis.com/jquery-ui.min')."\n";
		echo $this->Html->script('/admin_assets/js/jvector-map/jquery-jvectormap-us-lcc-en')."\n";
		echo $this->Html->script('/admin_assets/js/gauge/gauge')."\n";
		echo $this->Html->script('/admin_assets/js/scripts')."\n";
		echo $this->Html->script('/admin_assets/js/jquery.customSelect.min')."\n";
		echo $this->Html->script('/admin_assets/js/dashboard')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot.growraf')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot.animator.min')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot.pie.resize')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot.resize')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot.tooltip.min')."\n";
		echo $this->Html->script('/admin_assets/js/flot-chart/jquery.flot')."\n";
		echo $this->Html->script('/admin_assets/js/morris-chart/raphael-min')."\n";
		echo $this->Html->script('/admin_assets/js/morris-chart/morris')."\n";
		echo $this->Html->script('/admin_assets/js/sparkline/jquery.sparkline')."\n";
		echo $this->Html->script('/admin_assets/js/easypiechart/jquery.easypiechart')."\n";
		echo $this->Html->script('/admin_assets/js/css3clock/js/css3clock')."\n";
		
		echo $this->Html->script('/admin_assets/js/jvector-map/jquery-jvectormap-1.2.2.min')."\n";
		echo $this->Html->script('/admin_assets/js/evnt.calendar.init')."\n";
		echo $this->Html->script('/admin_assets/js/calendar/moment-2.2.1')."\n";
		echo $this->Html->script('http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min')."\n";
		echo $this->Html->script('/admin_assets/js/calendar/clndr')."\n";
		echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min')."\n";
		echo $this->Html->script('/admin_assets/js/jquery.scrollTo/jquery.scrollTo')."\n";
		echo $this->Html->script('/admin_assets/js/skycons/skycons')."\n";
		echo $this->Html->script('/admin_assets/js/jquery.nicescroll')."\n";
		echo $this->Html->script('/admin_assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll')."\n";
		echo $this->Html->script('/admin_assets/js/jquery.scrollTo.min')."\n";
		echo $this->Html->script('/admin_assets/js/jquery.dcjqaccordion.2.7')."\n";
		echo $this->Html->script('/admin_assets/bs3/js/bootstrap.min')."\n";
		echo $this->Html->script('/admin_assets/js/jquery-ui/jquery-ui-1.10.1.custom.min')."\n";
		echo $this->Html->script('/admin_assets/js/jquery')."\n";
		
	?>



	<?php 
	if ($this->Session->check('Auth.User')) {
	echo $this->Html->script('/admin_assets/ajax_admin')."\n";
	?>
	
	<script type="text/javascript">
		jQuery.ajax({
		 type: 'get',
		 url : '/admin/pages/menu',
		 success: function(data){
		  jQuery(".side").html(data);
		 }
		});
	</script>
	
<?php } ?>
</head>

<body>
	<?php if ($this->Session->check('Auth.User')) { 
		echo $this->Html->tag('div', $this->Html->tag('div', '', array('id'=>'loader')), array('id' => 'loading-page', 'style' => 'display:none;'))."\n";
	?>
	 
  <div class="main-content" id="main-content">
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?>
  </div>
</div>
<?php }else{ ?>
	<div class="all-wrapper no-menu-wrapper light-bg">
		<?php echo $this->fetch('content'); ?>
	</div>
<?php } ?>
</body>
<!-- Mirrored from saturn.pinsupreme.com/table.html by HTTrack Website Copier/3.x [XR&CO'2008], Mon, 11 Aug 2014 12:58:36 GMT -->
</html>
