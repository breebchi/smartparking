<!DOCTYPE html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

 
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
	  	echo $this->Html->css('/admin_assets/js/data-tables/DT_bootstrap.css')."\n";
	  	
	  	
	  	
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
		echo $this->Html->script('/admin_assets/js/table-editable.js')."\n"; 
	?>
<script type="text/javascript"> $(document).ready(function () { alert('JQuery is succesfully included'); }); </script>
<script>
    jQuery(document).ready(function() {
        EditableTable.init();
    });
</script>
  <link href="assets/favicon.ico" rel="shortcut icon">
  <link href="assets/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->

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


<!--logo end-->



<body>
	<?php if ($this->Session->check('Auth.User')) { 
		echo $this->Html->tag('div', $this->Html->tag('div', '', array('id'=>'loader')), array('id' => 'loading-page', 'style' => 'display:none;'))."\n";
	?>
	
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="index.html" class="logo">
        smart parking
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">4</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 4 Mails</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Jonathan Smith</span>
                                <span class="time">Just now</span>
                                </span>
                                <span class="message">
                                    Hello, this is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini-2.jpg"></span>
                                <span class="subject">
                                <span class="from">
                                lina 
                                </span>
                                <span class="time">2 min ago</span>
                                </span>
                                <span class="message">
                                    Nice admin template
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini-3.jpg"></span>
                                <span class="subject">
                                <span class="from">Tasi sam</span>
                                <span class="time">2 days ago</span>
                                </span>
                                <span class="message">
                                    This is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Mr. Perfect</span>
                                <span class="time">2 hour ago</span>
                                </span>
                                <span class="message">
                                    Hi there, its a test
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end -->
        <!-- notification dropdown start-->
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">3</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                <li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="images/avatar1_small.jpg">
                <span class="username"><?php echo $this->Session->read('Auth.User.username') ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
				<?php $items .= $this->Html->tag('li', $this->Js->link($this->Html->tag('i', '', array('class'=>'fa fa-key')).$this->Html->tag('span', __('Logout')), array('controller' => 'users', 'action' => 'logout'), array_merge($ajax, array('escape' => false))))."\n";?>
				<?php echo $items ;?>  
            </ul>
        </li>
        <!-- user login dropdown end -->
        <li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="index.html">
                        <i class="fa fa-dashboard"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-envelope"></i>
                        <span>Mail </span>
                    </a>
                    <ul class="sub">
                        <li><a href="mail.html">Inbox</a></li>
                        <li><a href="mail_compose.html">Compose Mail</a></li>
                        <li><a href="mail_view.html">View Mail</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-laptop"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub">
                        <li><a href="/admin/pages/adminslist">admins</a></li>
                        <li><a href="/admin/pages/deviceslist">devices</a></li>
                        
                    </ul>
                </li>
               
               
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class=" fa fa-bar-chart-o"></i>
                        <span>Maps</span>
                    </a>
                    <ul class="sub">
                        <li><a href="google_map.html">Google Map</a></li>
                       
                    </ul>
                </li>
               
                <li>
                    <a class="active" href="index.html">
                        <i class="fa fa-dashboard"></i>
                        <span>About us</span>
                    </a>
                </li>
<li>
                    <a href="login.html">
                        <i class="fa fa-user"></i>
                        <span>Login Page</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<div class="main-content" id="main-content">
				<?php echo $this->fetch('content'); ?>
				<?php //echo $this->element('sql_dump'); ?>
 			 </div>
<!--main content end-->
<!--right sidebar start-->
<div class="right-sidebar">
<div class="search-row">
    <input type="text" placeholder="Search" class="form-control">
</div>
<div class="right-stat-bar">
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left">work progress (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-delivery">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="30" data-width="90%" data-bar-color="#39b7ab" data-bar-width="5" data-data="[200,135,667,333,526,996,564,123,890,564,455]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info payment-info">
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-collection">
						<span class="pc-epie-chart" data-percent="45">
						<span class="percent"></span>
						</span>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="d-pending">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="col-md-12">
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                            <span class="sr-only">50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head terques-bg active clearfix">
        <span class="pull-left">contact online (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class="user-status text-success">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/chat-avatar2.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">John Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class="user-status text-warning">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class="user-status text-info">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <p class="text-center">
                <a href="#" class="view-btn">View all Contacts</a>
            </p>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head purple-bg active">
        <span class="pull-left"> recent activity (3)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        just now
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        2 min ago
                    </p>
                    <p>
                        <a href="#">Jane Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        1 day ago
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
        </li>
    </ul>
</li>

</ul>

</div>

</div>
<!--right sidebar end-->
</section>

		<?php }else{ ?>
			<div class="login-body">
				<?php echo $this->fetch('content'); ?>
			</div>
		<?php } ?>
</body>
<!-- Mirrored from saturn.pinsupreme.com/table.html by HTTrack Website Copier/3.x [XR&CO'2008], Mon, 11 Aug 2014 12:58:36 GMT -->
</html>




