<?php ?>
   <style>
		

		/* On screens that are 992px wide or less, go from four columns to two columns */
        @media screen and (max-width: 992px) {
            .footer--copyright .text{
                padding:3px;
               
           } 

           .footer--copyright{
               height:150px;
           }
   
        }

       /* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
			
            .footer--copyright .text{
               padding:3px;
               
           }

           .footer--copyright{
               height:150px;
           }
	
        }
	</style>		
	 		
	
        <footer class="footer--section">
			<div class="footer--widgets pd--30-0 bg--color-2">
				<div class="container">
					<div class="row AdjustRow">
						<div class="col-md-4 col-xs-6 col-xxs-12 ptop--30 pbottom--30">
							<div class="widget">
								<div class="widget--title">
									<h2 class="h4">About Us</h2> <i class="icon fa fa-exclamation"></i> </div>
								<div class="about--widget">
									<div class="content">
										<p>‘Khabar New India - सोच ईमानदार, खबर दमदार ’ is a leading and fastest news service station which provides you news and analysis from India.</p>
									</div>
									<div class="action">  </div>
									<ul class="nav">
										<li> <i class="fa fa-home"></i> <span>Rahul Kumar</span>
										<span>79, Kanwali Dehradun
                                        Uttarakhand -248001</span> </li>
										<li> <i class="fa fa-envelope-o"></i> <a >khabarnewindia@gmail.com</a> </li>
										<li> <i class="fa fa-phone"></i> <a href="tel:+123456789">+91-9548859920</a> </li>
									</ul>
								</div>
								

							</div>
                            
						</div>
						<div class="col-md-4 col-xs-6 col-xxs-12 ptop--30 pbottom--30">
							<div class="widget">
								<div class="widget--title">
									<h2 class="h4">Popular News</h2> <i class="icon fa fa-expand"></i> </div>
								<div class="links--widget">
									<ul class="nav">
                                    <?php
                                            
                                        $count=1;
                                        if(count($popularContent)>0)
                                        {
                                            foreach($popularContent as $key=>$value)
                                            {
                                                $catImg=$value['post_image'];
                                                $catTitle=strip_tags($value['title']);
                                                
                                                $catDate=date("d M Y",strtotime($value['created_on']));
                                                $catAuthor=$value['author'];
                                                $catId=base64_encode($value['id']);
                                                
                                                if($count>0 && $count<=3)
                                                {
                                                    echo "<li class=\"clearfix\">
                                                    <div class=\"utf_post_block_style post-float clearfix\">
                                                    <div class=\"utf_post_thumb\">
                                                        
                                                        <!-- Image -->
                                                        <a href=\"details-$catId\" class=\"image\"><img src=\"./post_images/$catImg\" alt=\"Post\" style=\"width:104px;height:55px;\"></a>
                                                        </div>
                                                        <!-- Content -->
                                                        <div class=\"utf_post_content\">
                            
                                                            <!-- Title -->
                                                            <h5 class=\"utf_post_title title-small\"><a href=\"details-$catId\">$catTitle.</a></h5>
                            
                                                            <!-- Meta -->
                                                            <div class=\"utf_post_meta\">
                                                                <span class=\"utf_post_date\"><i class=\"fa fa-clock-o\"></i>$catDate</span>
                                                            </div>
                            
                                                        </div>
                                                        
                                                    </li>
                                                    ";
                                                }
                                                $count++;
                                            }
                                        }
                                    ?>

									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-xs-6 col-xxs-12 ptop--30 pbottom--30">
							<div class="widget">
								<div class="widget--title">
									<h2 class="h4">Recent News</h2> <i class="icon fa fa-bullhorn"></i> </div>
								<div class="links--widget">
									<ul class="nav">
                                    <?php
                                            
                                        $count=1;
                                        if(count($sliderContent)>0)
                                        {
                                            foreach($sliderContent as $key=>$value)
                                            {
                                                $catImg=$value['post_image'];
                                                $catTitle=strip_tags($value['title']);
                                                $catDate=date("d M Y",strtotime($value['created_on']));
                                                $catAuthor=$value['author'];
                                                $catId=base64_encode($value['id']);
                                               
                                                if($count>0 && $count<=3)
                                                {
                                                    echo "<li class=\"clearfix\">
                                                    <div class=\"utf_post_block_style post-float clearfix\">
                                                    <div class=\"utf_post_thumb\">
                                                        
                                                        <!-- Image -->
                                                        <a href=\"details-$catId\" class=\"image\"><img src=\"./post_images/$catImg\" alt=\"Post\" style=\"width:104px;height:55px;\"></a>
                                                        </div>
                                                        <!-- Content -->
                                                        <div class=\"utf_post_content\">
                            
                                                            <!-- Title -->
                                                            <h5 class=\"utf_post_title title-small\"><a href=\"details-$catId\">$catTitle.</a></h5>
                            
                                                            <!-- Meta -->
                                                            <div class=\"utf_post_meta\">
                                                                <span class=\"utf_post_date\"><i class=\"fa fa-clock-o\"></i>$catDate</span>
                                                            </div>
                            
                                                        </div>
                                                        
                                                    </li>
                                                ";
                                                }
                                                $count++;
                                            }
                                        }
                                    ?>
                
									</ul>
								</div>
							</div>
						</div>
						
						</div>
					</div>
				</div>
			</div>
			<div class="footer--copyright bg--color-3">
				<div class="social--bg bg--color-1"></div>
				<div class="container" style="height:50px">
					<p class="col-sm-4 col-md-4 text float--left">&copy; 2022 KHABAR NEW INDIA. All Rights Reserved.</p>
                    
					<ul class="nav social float--right">
						<li><a href="https://www.facebook.com/Khabar-New-India-109462975005785" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://twitter.com/Khabarnewindia" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://www.instagram.com/khabarnewindia/" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<li><a href="https://www.youtube.com/channel/UCO-Nk1uQi6D_qKgBR2CRXLQ" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
					</ul>
                    <center>
                        <div class="col-md-3">   
                            <div class="text float--center">
                                <div class="container" style="width:100%;padding-top:5px">
                                <div class="incremental-counter" data-value="<?=$visitCount;?>"></div>
                                </div>
                            </div>
                        </div>
                        
                    </center>
                    <p class="text">Website By :<a href="http://witds.com" target="_blank"> World IT Dimensional Solutions.</a></p>
                   
				</div>
			</div>
		</footer>

        
	
	<script src="<?=$redirectPath_site?>/js/jquery-3.2.1.min.js"></script>
	<script src="<?=$redirectPath_site?>/js/jquery.incremental-counter.js"></script>
	<script>
	  $(".incremental-counter").incrementalCounter();
	</script>