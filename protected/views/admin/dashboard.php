<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">
            
				<!-- Breadcrumbs line -->
			    <div class="crumbs">
		            <ul id="breadcrumbs" class="breadcrumb"> 
		                <li class="active"><a href="<?php echo Yii::app()->params->base_url; ?>admin/dashboard">Dashboard</a></li>
		            </ul>
			        
		            
			    </div>
			    <!-- /breadcrumbs line -->
                
			    <!-- Page header -->
			    <div class="page-header">
			    	<div class="page-title">
				    	<h5>Dashboard</h5>
				    	<span>Welcome, <?php echo Yii::app()->session['fullName'] ; ?> !</span>
			    	</div>
 	
			    </div>
			    <!-- /page header -->

			    <!-- Action tabs -->
			    <div class="actions-wrapper">
				    <div class="actions">

				    	<div id="user-stats">
					        <ul class="round-buttons">
					            <li><div class="depth"><a href="<?php echo Yii::app()->params->base_path;?>admin/addUser" title="Add new user" class="tip"><i class="icon-plus"></i></a></div></li>
					            <!--<li><div class="depth"><a href="" title="RSS feed" class="tip"><i class="icon-rss"></i></a></div></li>-->
					            <li><div class="depth"><a href="<?php echo Yii::app()->params->base_path;?>admin/addUniversity" title="Add new university" class="tip"><i class="icon-sitemap"></i></a></div></li>
					            <li><div class="depth"><a href="<?php echo Yii::app()->params->base_path;?>admin/addDegree" title="Add new degree" class="tip"><i class="icon-th"></i></a></div></li>
                                <li><div class="depth"><a href="<?php echo Yii::app()->params->base_path;?>admin/myprofile" title="View profile" class="tip"><i class="icon-user"></i></a></div></li>
                                <li><div class="depth"><a href="<?php echo Yii::app()->params->base_path;?>admin/changePassword" title="Change Password" class="tip"><i class="icon-cogs"></i></a></div></li>
					        </ul>
				    	</div>

				    	<div id="quick-actions">
				    		<ul class="statistics">
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="blue-square"><i class="icon-group"></i></a>
					    				<strong><?php echo $count['totalUser'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>User registrations</span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="red-square"><i class="icon-indent-right"></i></a>
					    				<strong><?php echo $count['totalAdvert'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>Total Adverts</span>
				    			</li>
                                <li>
				    				<div class="top-info">
					    				<a href="#" title="" class="sea-square"><i class="icon-comment"></i></a>
					    				<strong><?php echo $count['totalAdvertReplyCount'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>Total Advert Replies</span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="purple-square"><i class="icon-question-sign"></i></a>
					    				<strong><?php echo $count['totalQuestion'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>Total Questions</span>
				    			</li>
                                <li>
				    				<div class="top-info">
					    				<a href="#" title="" class="dark-blue-square"><i class="icon-hand-up"></i></a>
					    				<strong><?php echo $count['totalAnswer'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>Total Answers</span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="green-square"><i class="icon-reorder"></i></a>
					    				<strong><?php echo $count['totalReview'] ; ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 100%;"></div></div>
									<span>Total Reviews</span>
				    			</li>
				    			
				    		</ul>
				    	</div>

				    	<ul class="action-tabs">
				    		<li><a href="#user-stats" title="">Quick actions</a></li>
				    		<li><a href="#quick-actions" title="">Website statistics</a></li>
				    	</ul>
				    </div>
				</div>
			    <!-- /action tabs -->
		    </div>
		    <!-- /content wrapper -->

		</div>
<!-- /content -->