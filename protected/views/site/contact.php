<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/contactus.js"></script>
<!-- Google Maps --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script> 
<script type="text/javascript" src="js/gmap3.js"></script>
<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb"> <a href="index.html"> <i class="fa fa-home fa-fw"></i> Home </a> <i class="fa fa-angle-right fa-fw"></i> <a href="Contact.html"> Contact </a></div>
      
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
<!-- Page title -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
        <h2>Get in touch</h2>
      </div>
    </div>
  </div>
</div>
<!-- end: Page title -->
<div class="row clearfix f-space10"></div>
<div class="container"> 
  <!-- row -->
  <div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12 main-column box-block">
      <div id="map" class="map"></div>
      <div class="clearfix f-space30"></div>
      <div class="contactform">
        <h2 class="title">Contact Form</h2>
        <p>Visit our shop to get fresh seasonal, regular and exotic vegetables direct from the farms and greenhouses.</p>
        <form action="<?php echo Yii::app()->params->base_path; ?>site/Contactus" id="contactusform" name="contactusform" onsubmit="return validateAll();" method="post">
          <div class="row">
            <div class="col-md-5">
            <span id="nameerror"></span>
              <input class="input4"  name="name" id="name" onkeyup="validateName()" onblur="validateName();" onfocus="this.style.color='black';" value="<?php echo $name; ?>" placeholder="Name*" data-validation="required">
              <span id="emailerror"></span>
              <input class="input4"  name="email" id="email" onkeyup="validateEmail()" onblur="validateEmail()" onfocus="this.style.color='black';" value="<?php echo $email; ?>" placeholder="Email*" data-validation="email">
              <div class="captcha1">
				<?php $this->widget('CCaptcha');
                 ?>
                <div class="clear"></div>
                <?php echo Chtml::textField('verifyCode',''); ?>
            </div>
            </div>
            <div class="col-md-7">
            <span id="commenterror"></span>
              <textarea class="input4" name="comment" id="comment"  rows="8" cols="60" placeholder="Message" data-validation="required" onkeyup="validateComment()"  onfocus="this.style.color='black';" ><?php echo $comment; ?></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <button  name="FormSubmit" id="FormSubmit" class="btn large color2 pull-right" type="submit">Send now</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <!-- side bar -->
    <div class="col-md-3 col-sm-12 col-xs-12 box-block page-sidebar">
      <div class="box-heading"><span>Contact Details</span></div>
      <!-- Contact Details -->
      <div class="box-content contactdetails-box-wr">
        <div class="contactdetails-box"> <span class="icon"><i class="fa fa-map-marker fa-fw"></i></span>
          <div class="details">
            <h1>Fresh n Pack</h1>
           23,24 Ground floor, Management enclave, <br/>
           Opp. Indraprastha bung. Vastrapur - Mansi road<br/>
            Vastrapur 380015.</div>
        </div>
        <div class="contactdetails-box"> <span class="icon"><i class="fa fa-phone fa-fw"></i></span> <span class="details">Phone 1: 079-40053900</span>
         </div>
          <div class="contactdetails-box"> <span class="icon"><i class="fa fa-phone fa-fw"></i></span> <span class="details">Phone 2: 079-40056900<br/>
          </span> </div>
        <div class="contactdetails-box"> <span class="icon"><i class="fa fa-envelope fa-fw"></i></span> <span class="details">Email: sales@freshnpack.com <br/>
          </span> </div>
      </div>
      
   
      
    </div>
    <!-- end:sidebar --> 
  </div>
  <!-- end:row --> 
</div>
<!-- end: container-->

<div class="row clearfix f-space30"></div>
<script>

(function($) {
  "use strict";
 $('#menuMega').menu3d();
 //Google Maps Configuration
			var lat="23.028048";
			var lon="72.557717";
			$('#map').gmap3({
			map:{
			options:{
			 center: [lat, lon],
			 zoom: 14
			}
			},
			marker:{
			latLng: [lat, lon]
			}
			});
			
			 //Help/Contact Number/Quick Message
			$('.quickbox').carousel({
				interval: 10000
			});
			
			//Best Sellers
			$('#productc4').carousel({
				interval: 4000
			});           
				
})(jQuery);


          
        </script>
	