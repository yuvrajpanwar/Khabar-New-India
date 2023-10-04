<?php 

$counter=get_counter($db);
$visitCount='';
if($counter)
{
    $visitCount=$counter['visits'];
    $visitCount++;
    update_counter($db,$visitCount,1);
}
?>
<style>
		.sldImg{
			height:460px;
		}

        .logo{
            width:220px;
            height:150px;
        }


		/* On screens that are 992px wide or less, go from four columns to two columns */
       @media screen and (max-width: 992px) {
        .header--topbar .nav > li{
            font-size: 12px
        }

        .header--topbar .nav{
            line-height:0px;
        }

        .news--ticker .title h2{
            font-size:20px;
        }

        .logo{
            width:182px;
            height:121px;
        }

   
       }

       /* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
       @media screen and (max-width: 600px) {
        .header--topbar .nav > li{
            font-size: 12px
        }

        .header--topbar .nav{
            line-height:0px;
        }

        .news--ticker .title h2{
            font-size:20px;
        }

        .logo{
            width:182px;
            height:121px;
        }

      }

</style>		
	

    <!-- <div id="preloader">
		<div class="preloader bg--color-1--b" data-preloader="1">
			<div class="preloader--inner"></div>
		</div>
	</div>  -->
	<div class="wrapper">
		<header class="header--section header--style-1">
			<div class="header--topbar bg--color-2">
				<div class="container">
					<div class="float--left float--xs-none text-xs-center">
						<ul class="header--topbar-info nav">
							<li><i class="fa fm fa-map-marker"></i>Dehradun</li>
							
							<li><i class="fa fm fa-calendar"></i><?=date("l, j F Y",time())?></li>
						</ul>
					</div>
					<div class="float--right float--xs-none text-xs-center">
					
						<ul class="header--topbar-social nav">
							<li><a href="https://www.facebook.com/Khabar-New-India-109462975005785" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://twitter.com/Khabarnewindia" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="https://www.instagram.com/khabarnewindia/" target="_blank"><i class="fa fa-instagram"></i></a></li>
							<li><a href="https://www.youtube.com/channel/UCO-Nk1uQi6D_qKgBR2CRXLQ" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="header--mainbar">
				<div class="container">
					<div class="header--logo float--left float--sm-none text-sm-center">
						<h1 class="h1"> <a href="index.php" class="btn-link"> <img class="logo" src="img/KNI-Logo.png" alt="Logo">  </a> </h1> </div>
					<div class="header--ad float--right float--sm col-md-8 col-12">
                                        
                        <img class="banner" src="img/2.jpeg" alt="Banner">
                                           
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2559414196896524"crossorigin="anonymous"></script>
                        <!-- ad1 -->
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-client="ca-pub-2559414196896524"
                            data-ad-slot="7545060325"
                            data-ad-format="auto"
                            data-full-width-responsive="true"></ins>
                            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
					</div>
				</div>
			</div>
			<div class="header--navbar navbar bd--color-1 bg--color-1" data-trigger="sticky">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#headerNav" aria-expanded="false" aria-controls="headerNav"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
					</div>
					<div id="headerNav" class="navbar-collapse collapse float--left">
						<ul class="header--menu-links nav navbar-nav" data-trigger="hoverIntent">
							<li> <a href="<?=$redirectPath_site?>/index.php">होम</a>
						    </li>
							
							<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$categoryList[0]['name']?><i class="fa flm fa-angle-down"></i></a>
								<ul class="dropdown-menu">
                                    <?php
                                        $first_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

                                            if($first_count<=1 || $first_count==78 || $first_count==73|| $first_count==4 ||$first_count==81||$first_count==6||$first_count==51||$first_count==8||$first_count==63||$first_count==70||$first_count==34||$first_count==39||$first_count==13||$first_count==14||$first_count==84)
                                            {
                                                echo "<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";
                                            }

                                            // if($first_count>=14)
                                            // {
                                            // break;
                                            // }
                                            $first_count++;

                                        }
                                    ?>
								</ul>
							</li>

                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$categoryList[14]['name']?><i class="fa flm fa-angle-down"></i></a>
								<ul class="dropdown-menu">
                                <?php
                                        $second_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

											if($second_count>=97)
                                            {
                                                echo "<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";
                                            }
                                            if($second_count>101)
                                            {
                                            break;
                                            }
                    
                                        $second_count++;
                                   }
                                
                                ?> 
                             </ul>
                            </li>

							<li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>16){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>16){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>102){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>102){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>18 && $third_count<=20){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>20){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>25){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>25){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>21){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>21){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>
                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>24){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>24){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            <li>
                             
                                <?php
                                    $third_count=1;
                                    
                                    foreach($categoryList as $menu_category_third_index => $fetch_menu_category_third)
                                    {
                                        $menu_category_id =$fetch_menu_category_third ['id'];
                                        $menuencode_cat_id=base64_encode($menu_category_id);
                                         $menu_category_name =$fetch_menu_category_third ['name'];

                                        if($third_count>103 && $third_count<=105){
                                            echo"<li><a href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";  
                                        }


                                         if($third_count>105){
                                             break;
                                         }

                                    
                                            $third_count++;
                                            
                                    }
                                ?>
                             
                            </li>

                            	
						</ul>
					</div>
					<!-- <form action="#" class="header--search-form float--right" data-form="validate">
						<input type="search" name="search" placeholder="Search..." class="header--search-control form-control" required>
						<button type="submit" class="header--search-btn btn"><i class="header--search-icon fa fa-search"></i></button>
					</form> -->
				</div>
			</div>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-219293989-1"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-219293989-1');
            </script>
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2559414196896524"
     crossorigin="anonymous"></script>
		</header>
			<div class="news--ticker">
			<div class="container">
				<div class="title">
					<h2>BREAKING NEWS</h2></div>
				<div class="news-updates--list" data-marquee="true" data-duration="9500">
					<ul class="nav">

					<?php
                        $count=1;
						foreach($sliderContent as $key=>$value)
						{
							echo "<li><h3 class=\"h3\"><a href=\"#\">".$value['title'].".</a></h3></li>";

                            if($count==5){
                                break;
                            }
                            $count++;
						}

					?>
					
					</ul>
				</div>
			</div>
		</div>