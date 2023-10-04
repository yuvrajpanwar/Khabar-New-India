<?php 
  require_once('../classes/utils.php');
  set_timezone();
  
        $sectionOfTime = getDaySection();
		$route = (isset($_REQUEST['route']))?$_REQUEST['route']:'';
		$msg = '';

		switch($route) {

		case "102":
		$msg = 'Invalid userName / Password. Please Try again.';
		break;

		case "103":
		$msg = 'You are successfully logout.';
		break;

		default:
		$msg='';
		
		}
		// require_once('header.php');
       
?>
<!DOCTYPE html>
<html class=" ">
<head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Khabar New India - सोच ईमानदार, खबर दमदार </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        




        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/icheck/skins/square/orange.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
 
		<style>
		.error
		{
			color:red !important;
		}
		</style>
        <!-- CORE CSS TEMPLATE - END -->
		 <script src="i-js/jquery-2.2.3.min.js"></script>
	    <script src="i-js/jquery.validate.min.js"></script>
        
	    <script>
			(function($,W,D)
			{
				var JQUERY4U = {};

				JQUERY4U.UTIL =
				{
					setupFormValidation: function()
					{
						//form validation rules
						$("#login_form").validate({
							rules: {
										user_name:
										{
											required: true,
										},
										password:
										{
											required: true,
										},
							},
							messages: 
							{
								user_name:
								{
									required:"Please provide UserName",
								},
								password:
								{
									required:"Please Peovide Password",
								},
							},
							submitHandler: function(form) {
								form.submit();
							}
						});
						
				
					}
				}

				//when the dom has loaded setup form validation rules
				$(D).ready(function($) {
					JQUERY4U.UTIL.setupFormValidation();
				});

			})(jQuery, window, document);
	    </script>
</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" login_page">


        <div class="login-wrapper">
		<h3 style="text-align: center; color: red;"><?=$msg?></h3>
            <div id="login" class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-0 col-xs-12">
                <h1>
                    <a href="#" title="Login Page" tabindex="-1">Lekha Adda Admin</a>
                </h1>

                <form name="login_form" id="login_form" action="auth_login.php" method="post">
                    <p>
                        <label for="user_login">fill Username<br />
                            <input type="text" name="user_name" id="user_name" class="input" value="" size="20" /></label>
                    </p>
                    <p>
                        <label for="user_pass">Password<br />
                            <input type="password" name="password" id="password" class="input" value="" size="20" /></label>
                    </p>
                 
                    <p class="submit">
                        <input type="submit" name="Login" id="wp-submit" class="btn btn-orange btn-block" value="Login" />
                    </p>
                </form>

                <p id="nav">
                </p>


            </div>
        </div>

        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 

        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

        <!-- General section box modal start -->
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Section Settings</h4>
                    </div>
                    <div class="modal-body">

                        Body goes here...

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button class="btn btn-success" type="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
    </body>
</html>