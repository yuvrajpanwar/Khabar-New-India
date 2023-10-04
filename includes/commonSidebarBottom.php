<?php ?>
<div class="main--sidebar col-md-4 col-sm-5 ptop--30 pbottom--30" data-sticky-content="true">
						<div class="sticky-content-inner">
							
							<div class="widget">
								<div class="widget--title" data-ajax="tab">
									<h2 class="h4">Recent News</h2>
									
								</div>
								<div class="list--widget list--widget-1" data-ajax-content="outer">
									<div class="post--items post--items-3">
										<ul class="nav" data-ajax-content="inner">

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
												
												if($count>0 && $count<=4)
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
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>