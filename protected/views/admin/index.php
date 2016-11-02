<!-- Login block -->
<div class="login">
    <div class="navbar">
        <div class="navbar-inner">
            <h6><i class="icon-user"></i>Login page</h6>
            <div class="nav pull-right">
                <a href="#" class="dropdown-toggle navbar-icon" data-toggle="dropdown"><i class="icon-cog"></i></a>
                <ul class="dropdown-menu pull-right">
                    <!--<li><a href="#"><i class="icon-plus"></i>Register</a></li>-->
                    <li><a href="<?php echo Yii::app()->params->base_path; ?>admin/forgotPassword"><i class="icon-refresh"></i>Recover password</a></li>
                    <!--<li><a href="#"><i class="icon-cog"></i>Settings</a></li>-->
                </ul>
            </div>
        </div>
    </div>
    <div class="well">
        <form action="<?php echo Yii::app()->params->base_path;?>admin/AdminLogin" method="post" class="row-fluid">
            <div class="control-group">
                <label class="control-label">Email:</label>
                <div class="controls"><input class="span12" type="text" value="<?php if(isset($_COOKIE['email_admin'])) { echo $_COOKIE['email_admin']; } ?>" name="email_admin" placeholder="email" /></div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Password:</label>
                <div class="controls"><input class="span12" type="password" value="<?php if(isset($_COOKIE['password_admin'])) { echo $_COOKIE['password_admin']; }?>" name="password_admin" placeholder="password" /></div>
            </div>

            <div class="control-group">
                <div class="controls"><label class="checkbox inline"><input type="checkbox"  name="remember" class="styled"  <?php if(isset($_COOKIE['email_admin']) && $_COOKIE['email_admin'] != "") { ?> checked="checked" <?php } ?> >Remember me</label></div>
            </div>

            <div class="login-btn"><input type="submit" name="submit_login" value="Log me in" class="btn btn-danger btn-block" /></div>
        </form>
    </div>
</div>
<!-- /login block -->