<?php 
	$email='';
	$emailError='';
	$message='';
	$msg='';
	

    if(isset($_POST['subscribe'])){

	  include('./subscribe.php');	
	
    }
?>
                <div class="main--sidebar col-md-4 col-sm-5 ptop--30 pbottom--30" data-sticky-content="true">
						<div class="sticky-content-inner">
						<div class="widget">
								<div class="widget--title">
									<h2 class="h4">Most Watched</h2> <i class="icon fa fa-newspaper-o"></i> </div>
								<div class="list--widget list--widget-1">
									
									<div class="post--items post--items-3" data-ajax-content="outer">
										<ul class="nav" data-ajax-content="inner">
										    
										   
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
													
													if($count<=3)
													{
									
											          echo"<li>
												      <div class=\"post--item post--layout-3\">
													  <div class=\"post--img\">
														<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
														<div class=\"post--info\">
															<ul class=\"nav meta\">
																<li><a href=\"#\">$catAuthor</a></li>
																<li><a href=\"#\">$catDate</a></li>
															</ul>
															<div class=\"title\">
																<h3 class=\"h4\"><a href=\"details-$catId\" class=\"btn-link\">$catTitle.</a></h3> </div>
														   </div>
													      </div>
												        </div>
											           </li>";
											        }
											     $count++;
										        }
										    }
									    ?>
											
										</ul>
										 <img class="banner" src="img/1.jpeg" alt="Banner">
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
							</div>
							<div class="widget">
								<div class="ad--widget">
								<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2559414196896524"
                                      crossorigin="anonymous"></script> -->
                                   
                                 <!--   <ins class="adsbygoogle"
                                      style="display:block"
                                       data-ad-client="ca-pub-2559414196896524"
                                       data-ad-slot="3057669333"
                                       data-ad-format="auto"
                                       data-full-width-responsive="true"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>-->
								</div>
							</div>
							<div class="widget">
								<div class="widget--title">
									<h2 class="h4">Stay Connected</h2> <i class="icon fa fa-share-alt"></i> </div>
								<div class="social--widget style--1">
									<ul class="nav">
										<li class="facebook">
											<a href="https://www.facebook.com/Khabar-New-India-109462975005785" target="_blank"> <span class="icon"><i class="fa fa-facebook-f"></i></span>  </a>
										</li>
										<li class="twitter">
											<a href="https://www.twitter.com/Khabarnewindia" target="_blank"> <span class="icon"><i class="fa fa-twitter"></i></span>  </a>
										</li>
										<li class="instagram">
											<a href="https://www.instagram.com/khabarnewindia" target="_blank"> <span class="icon"><i class="fa fa-instagram"></i></span>  </a>
										</li>
										
										<li class="youtube">
											<a href="https://www.youtube.com//channel/UCO-Nk1uQi6D_qKgBR2CRXLQ" target="_blank"> <span class="icon"><i class="fa fa-youtube-square"></i></span> </a>
										</li>
									</ul>
								</div>
							</div>
							<div class="widget">
								
								<div class="widget--title">
									<h2 class="h4">Subscribe Us</h2> <i class="icon fa fa-envelope-open-o"></i> </div>
								<div class="subscribe--widget">
									<div class="content">
										<p>Subscribe Us For Latest Updates.</p>
									</div>
									<form  action="#" method="post" name="mc-embedded-subscribe-form">
										<div class="input-group">
											<input type="text" name="email" placeholder="E-mail address" class="form-control" autocomplete="off">
											<div class="input-group-btn">
												<button type="submit" name="subscribe" class="btn btn-lg btn-default active"><i class="fa fa-paper-plane-o"></i></button>
											</div>
										</div>
										
									</form>
									
								    
								</div>
								<div class="status" style="color:red"><?=$emailError?></div>
								<div class="status" style="color:green"><?=$msg?></div>
							</div>
							
							<div class="widget">
								<div class="widget--title">
									<h2 class="h4">Advertisement</h2> <i class="icon fa fa-bullhorn"></i> </div>
								<div class="ad--widget">
								<img class="banner" src="img/3.jpeg" alt="Banner">
									<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2559414196896524"
                                     crossorigin="anonymous"></script> -->
                            
                                    <!-- <ins class="adsbygoogle"
                                   style="display:block"
                                   data-ad-client="ca-pub-2559414196896524"
                                   data-ad-slot="1169872594"
                                      data-ad-format="auto"
                                      data-full-width-responsive="true"></ins> -->
                                <!-- <script>
                              (adsbygoogle = window.adsbygoogle || []).push({});
                                </script> -->
								</div>
							</div>
						</div>
					</div>
				</div>