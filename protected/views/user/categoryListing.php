<div class="row clearfix"></div>
<?php
	  		if(isset($_GET['page']) && $_GET['page'] != '')
			{
				$page = $_GET['page'];
			}
			else
			{
				$page = 1;
			}
			$pageItemCount = $data['pagination']->getItemCount();
			$limit = $data['pagination']->getLimit();
			$var1 =0;$var2=0;
			$var2 = $limit * $page;
			
			$var1 = $var2 - ($limit - 1);
			if($var2 >  $pageItemCount)
			{
				$var2 = $pageItemCount;
			}
			
	  ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="<?php echo Yii::app()->params->base_path;?>site"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> <a href="<?php echo Yii::app()->params->base_path;?>site/categoryListing"> Category List </a> </div>
      
      <!-- Quick Help for tablets and large screens -->
      <div class="quick-message hidden-xs">
        <div class="quick-box">
          <div class="quick-slide"> <span class="title">Help</span>
            <div class="quickbox slide" id="quickbox">
              <div class="carousel-inner">
                <div class="item active"> <a href="#"> <i class="fa fa-envelope fa-fw"></i> Quick Message</a> </div>
                <div class="item"> <a href="<?php echo Yii::app()->params->base_path;?>site/faq"> <i class="fa fa-question-circle fa-fw"></i> FAQ</a> </div>
                <div class="item"> <a href="#"> <i class="fa fa-phone fa-fw"></i> 079-40165800</a> </div>
              </div>
            </div>
            <a class="left carousel-control" data-slide="prev" href="#quickbox"> <i class="fa fa-angle-left fa-fw"></i> </a> <a class="right carousel-control" data-slide="next" href="#quickbox"> <i class="fa fa-angle-right fa-fw"></i> </a> </div>
        </div>
      </div>
      <!-- end: Quick Help --> 
      
    </div>
  </div>
</div>
<div class="row clearfix f-space10"></div>

<div class="row clearfix f-space10"></div>
<div class="container"> 
  <!-- row -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 box-block">
      <div class="box-heading category-heading">
      <?php $cnt = $data['pagination']->itemCount; if($cnt > 0 ){ ?>
      <span>Showing <?php echo $var1." - ".$var2; ?> of <?php echo $pageItemCount; ?> Categories</span>
      <?php } ?>
        <ul class="nav nav-pills pull-right">
          <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="#a"> Sort by <i class="fa fa-sort fa-fw"></i> </a>
            <ul class="dropdown-menu" role="menu">
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "c.category_name" && $ext['sortType'] == "asc") { ?> class="active" <?php } ?> ><a href="<?php echo Yii::app()->params->base_path;?>user/categoryListing/sortBy/c.category_name/sortType/asc">Name (A-Z)</a></li>
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "c.category_name" && $ext['sortType'] == "desc") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>user/categoryListing/sortBy/c.category_name/sortType/desc">Name (Z-A)</a></li>
              <li <?php if(isset($ext['sortBy']) && $ext['sortBy'] == "c.createdAt") { ?> class="active" <?php } ?>><a href="<?php echo Yii::app()->params->base_path;?>user/categoryListing/sortBy/c.createdAt/sortType/desc">Recent</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="row clearfix f-space20"></div>
      <div class="box-content">
        <div class="box-products"> 
         <?php 
			$i=1;
			$cnt = $data['pagination']->itemCount;
			if($cnt>0){
		  
			foreach($data['categorylisting'] as $row) { ?>  
          <!-- Product Row -->
          <div class="row list-product"> 
            <!-- Product --> 
             <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="producttitle">
                <h1><a href="<?php echo Yii::app()->params->base_path;?>user/productListingGrid/cat_id/<?php echo $row['cat_id'] ?>"  data-toggle="tooltip" title="See all products of this category"><?php echo $row['category_name']; ?></a></h1>
              </div>
              <div class="productmeta">
                <p><?php echo $row['cat_description']; ?></p>
              </div>
            </div>
          </div>
          
          <!-- end: Product Row -->
         <?php }  }?> 
          <div class="row clearfix f-space20"></div>
          
          
        </div>
      </div>
      <div class="clearfix f-space30"></div>
      <?php $cnt = $data['pagination']->itemCount; if($cnt > 0 ){ ?>
       <span class="pull-left">Showing <?php echo $var1." - ".$var2; ?> of <?php echo $pageItemCount; ?> Categories</span>
       <?php } else { ?> 
       <span class="pull-left">Category not found.</span>
       <?php }?>
      <?php
		 if($cnt > 0 && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
			 <div class="pagination pagination-lg">
			 <?php 
			 $extraPaginationPara='&keyword='.$ext['keyword'];
			 $this->widget('application.extensions.WebPager',
							 array('cssFile'=>Yii::app()->params->base_url.'css/style.css',
									 'extraPara'=>$extraPaginationPara,
									'pages' => $data['pagination'],
									'id'=>'link_pager',
			));
		 ?>	
		 <?php  
		 }?>
      </div>
    </div>
    
    <!-- side bar -->
    <?php /*?><div class="col-md-3 col-sm-12 col-xs-12 box-block page-sidebar">
      <div class="box-heading"><span>Shop by</span></div>
      <!-- Filter by -->
      <div class="box-content">
        <div class="shopby"> <span>Color</span>
          <div class="colors"> <a href="#a" data-toggle="tooltip" title="Orange (20)" class="color bg-orange"></a> <a href="#a" data-toggle="tooltip" title="Fuchsia (03)" class="color bg-fuchsia"></a> <a href="#a" data-toggle="tooltip" title="Blue (12)" class="color bg-blue"></a> <a href="#a" data-toggle="tooltip" title="Gray (20)" class="color bg-gray"></a> <a href="#a" data-toggle="tooltip" title="Coral (10)" class="color bg-coral"></a> <a href="#a" data-toggle="tooltip" title="Khaki (33)" class="color bg-khaki"></a> <a href="#a" data-toggle="tooltip" title="Green (20)" class="color bg-green"></a> <a href="#a" data-toggle="tooltip" title="Purple (20)" class="color bg-purple"></a> <a href="#a" data-toggle="tooltip" title="Salmon (44)" class="color bg-salmon"></a> <a href="#a" data-toggle="tooltip" title="Cyan (21)" class="color bg-cyan"></a> <a href="#a" data-toggle="tooltip" title="Gold (11)" class="color bg-gold"></a> <a href="#a" data-toggle="tooltip" title="Teal (30)" class="color bg-teal"></a> <a href="#a" data-toggle="tooltip" title="White (33)" class="color bg-white"></a> <a href="#a" data-toggle="tooltip" title="Black (18)" class="color bg-black"></a> </div>
          <hr>
          
          <!-- Price Range --> 
          <span>Price range</span>
          <div class="pricerange">
            <input type="text" id="price-range" name="price-range"/>
            <!-- 	data-from="30"                      // overwrite default FROM setting
data-to="70"                        // overwrite default TO setting
data-type="double"                  // slider type
data-step="10"                      // slider step
data-postfix=" pounds"              // postfix text
data-hasgrid="true"                 // enable grid
data-hideminmax="true"              // hide Min and Max fields
data-hidefromto="true"              // hide From and To fields
data-prettify="false"               // don't use spaces in large numbers, eg. 10000 than 10 000
 -->
            
            <button class="btn color1 normal pull-right" type="submit">Clear</button>
          </div>
          <!--end: Price Range --> 
        </div>
      </div>
      <!-- end: Filter by -->
      
      <div class="clearfix f-space30"></div>
      <div class="box-heading"><span>Categories</span></div>
      <!-- Categories -->
      <div class="box-content">
        <div class="panel-group" id="blogcategories">
          <div class="panel panel-default">
            <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseOne" data-toggle="collapse">
              <h4 class="panel-title"> <a href="#a"> <span class="fa fa-plus"></span> Men Wear </a><span class="categorycount">14</span> </h4>
            </div>
            <div class="panel-collapse collapse" id="collapseOne">
              <div class="panel-body">
                <ul>
                  <li class="item"> <a href="#a">Jeans</a></li>
                  <li class="item"> <a href="#a">Shirts</a></li>
                  <li class="item"> <a href="#a">Shoes</a></li>
                  <li class="item"> <a href="#a">Sports Wear</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading opened" data-parent="#blogcategories" data-target="#collapseTwo" data-toggle="collapse">
              <h4 class="panel-title"> <a href="#a"> <span class="fa fa-minus"></span> Women Wear </a> <span class="categorycount">10</span></h4>
            </div>
            <div class="panel-collapse collapse in" id="collapseTwo">
              <div class="panel-body">
                <ul>
                  <li class="item"> <a href="#a">Jeans</a></li>
                  <li class="item"> <a href="#a">Shirts</a></li>
                  <li class="item"> <a href="#a">Shoes</a></li>
                  <li class="item"> <a href="#a">Sports Wear</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseThree" data-toggle="collapse">
              <h4 class="panel-title"> <a href="#a"> <span class="fa fa-plus"></span> Fragrance </a> <span class="categorycount">23</span></h4>
            </div>
            <div class="panel-collapse collapse" id="collapseThree">
              <div class="panel-body">
                <ul>
                  <li class="item"> <a href="#a">Jeans</a></li>
                  <li class="item"> <a href="#a">Shirts</a></li>
                  <li class="item"> <a href="#a">Shoes</a></li>
                  <li class="item"> <a href="#a">Sports Wear</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseFour" data-toggle="collapse">
              <h4 class="panel-title"> <a href="#a"> <span class="fa fa-plus"></span> Music </a><span class="categorycount">06</span> </h4>
            </div>
            <div class="panel-collapse collapse" id="collapseFour">
              <div class="panel-body">
                <ul>
                  <li class="item"> <a href="#a">Jeans</a></li>
                  <li class="item"> <a href="#a">Shirts</a></li>
                  <li class="item"> <a href="#a">Shoes</a></li>
                  <li class="item"> <a href="#a">Sports Wear</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseFive" data-toggle="collapse">
              <h4 class="panel-title"> <a href="#a"> <span class="fa fa-plus"></span> Games </a><span class="categorycount">80</span> </h4>
            </div>
            <div class="panel-collapse collapse" id="collapseFive">
              <div class="panel-body">
                <ul>
                  <li class="item"> <a href="#a">Jeans</a></li>
                  <li class="item"> <a href="#a">Shirts</a></li>
                  <li class="item"> <a href="#a">Shoes</a></li>
                  <li class="item"> <a href="#a">Sports Wear</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end: Blog Categories -->
      
      <div class="clearfix f-space30"></div>
      <div class="box-heading"><span>Compare</span></div>
      <!-- Compare -->
      <div class="box-content">
        <div class="compare"> <span><a href="product.html">Ladies Stylish Handbag</a> <a href="#" class="pull-right"><i class="fa fa-times fa-fw"></i></a> </span> <span><a href="product.html">Female Strips Handbag</a> <a href="#" class="pull-right"><i class="fa fa-times fa-fw"></i></a> </span> <span><a href="product.html">Blue Fashion Bag</a> <a href="#" class="pull-right"><i class="fa fa-times fa-fw"></i></a> </span>
          <button class="btn color1 normal pull-right" type="submit">Compare</button>
        </div>
        
        <!-- Compare --> 
      </div>
      <div class="clearfix f-space30"></div>
      <!-- Get Updates Box -->
      <div class="box-content">
        <div class="subscribe">
          <div class="heading">
            <h3>Get updates</h3>
          </div>
          <div class="formbox">
            <form>
              <i class="fa fa-envelope fa-fw"></i>
              <input class="form-control" id="InputUserEmail" placeholder="Your e-mail..." type="text">
              <button class="btn color1 normal pull-right" type="submit">Sign
              up</button>
            </form>
          </div>
        </div>
      </div>
      <!-- end: Get Updates Box --> 
      
    </div><?php */?>
    <!-- end:sidebar --> 
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>

<script>

(function($) {
  "use strict";
  //Mega Menu
 $('#menuMega').menu3d();
             
              //Help/Contact Number/Quick Message
			$('.quickbox').carousel({
				interval: 10000
			});
			
				
			//Filter by Price Slider
$("#price-range").ionRangeSlider({
    min: 100,                        // min value
    max: 1000,                       // max value
    from: 200,                       // overwrite default FROM setting
    to: 600,                         // overwrite default TO setting
    type: "double",                 // slider type
    step: 50,                       // slider step
    postfix: "",             		// postfix text
    hasGrid: false,                  // enable grid
    hideMinMax: false,               // hide Min and Max fields
    hideFromTo: false,               // hide From and To fields
    prettify: false,                 // separate large numbers with space, eg. 10 000
    onChange: function(obj){        // function-callback, is called on every change
        console.log(obj);
    },
    onFinish: function(obj){        // function-callback, is called once, after slider finished it's work
        console.log(obj);
    }
});			
				
				
				
})(jQuery);

 </script>