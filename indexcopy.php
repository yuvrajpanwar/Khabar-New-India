<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");
// $breakingNews=breaking_news_list($db);
$categoryList=category_listing($db);

$sliderContent=slider_content($db);
$popularContent=get_popular_post($db);
$videoPostContent=video_post_content($db);

session_start();
$counter_name = "counter.txt";

// Check if a text file exists.
// If not create one and initialize it to zero.
if (!file_exists($counter_name)) {
  $f = fopen($counter_name, "w");
  fwrite($f,"0");
  fclose($f);
}

// Read the current value of our counter file
$f = fopen($counter_name,"r");
$counterVal = fread($f, filesize($counter_name));
fclose($f);

// Has visitor been counted in this session?
// If not, increase counter value by one
if(!isset($_SESSION['hasVisited'])){
  $_SESSION['hasVisited']="yes";
  $counterVal++;
  $f = fopen($counter_name, "w");
  fwrite($f, $counterVal);
  fclose($f);
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Khabar New India - सोच ईमानदार, खबर दमदार </title>
	
	<link rel="stylesheet" href="<?=$redirectPath_site?>/css/jsdeliver.css" />

	<script src="<?=$redirectPath_site?>/js/swiper-bundle.min.js"></script>
	<?php include("includes/commonCss.php");?>

	<style>
		
		.sliderTitle{
			font-size:18px;
			font-weight:bold;
			margin: -5px;
		}

		.slImg{

			height:520px;
		}

		.sliderIm{
			height:320px;
		}

		

		/* On screens that are 992px wide or less, go from four columns to two columns */
        @media screen and (max-width: 992px) {
		    iframe{
			   height:200px;
			   width:330px;
		    }

			video{
				height:200px;
				width:330px;
			}


            .post--items.post--items-1 .post--item .post--info .title .h4{

				font-size: medium;
				margin-bottom: 40px;
			}

			
            .sliderTitle .h4{

				font-size: medium;
				
			}

	        .slImg{

				height:250px;
			}
   
        }

       /* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
			
		    iframe{
			   height:200px;
			   width:330px;
		    }

			video{
				height:200px;
				width:330px;
			}

			.post--items.post--items-1 .post--item .post--info .title .h4{
				
				font-size: medium;
				margin-bottom: 40px;
				
			}

			
            .sliderTitle .h4{

				font-size: medium;
				
			}

			.slImg{

              height:250px;
            }
        }

	

	</style>		
	<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>

</head>

<body class="boxed" data-bg-img="img/bg-pattern.png">
	<?php include("includes/commonHeader.php");?>
		<div class="main-content--section pbottom--30">
			<div class="container">
				<div class="main--content">
					<div class="post--items post--items-1 pd--30-0">
						<div class="row gutter--15">
					      <div class="col-md-6">		
						    <div class="sliderImg">
						        <?php
                                    $count=1;
									$contentLeft="";
									$contentRight="";
									$contentDown="";
                                    if(count($sliderContent)>0)
                                    {
                                        foreach($sliderContent as $key=>$value)
                                        {
                                            
                                            $img=$value['post_image'];
                                            $tid=base64_encode($value['id']);
                                            $title=strip_tags($value['title']);
                                            $date=date("d M Y",strtotime($value['created_on']));
                                            $author=$value['author'];
                                            $postCatType=$value['category_data'];

											if($postCatType!="")
								            {
									           $topCatNewsName=categoryTypeList($postCatType,$categoryList);
									   
								            }
                                           
                                            if($count>=1 && $count<=5)
                                            {
                        
							                  echo"<div class=\"post--item post--layout-1 post--title-larger\">
												    <div class=\"post--img\">
													  <a href=\"details-$tid\" class=\"thumb\"><img src=\"./post_images/$img\" alt=\"\" class=\"slImg\"></a> <a href=\"#\" class=\"cat\">$topCatNewsName</a> 
													  
													    <div class=\"post--info\">
														  <ul class=\"nav meta\">
															  <li><a href=\"#\">$author</a></li>
															  <li><a href=\"#\">$date</a></li>
														  </ul>
														  <div class=\"title\">
															  <h2 class=\"h4\"><a href=\"details-$tid\" class=\"btn-link\">$title.</a></h2> </div>
													    </div>
												    </div>
											  
										        </div>";
											}
												
										  else if($count>5 && $count<=7)
										  {

											$contentRight .= "<div class=\"col-xs-6 col-xss-12\">
											<div class=\"post--item post--layout-1 post--title-large\">
												<div class=\"post--img\">
													<a href=\"details-$tid\" class=\"thumb\"><img src=\"./post_images/$img\" alt=\"\"></a> <a href=\"#\" class=\"cat\">$topCatNewsName</a> 
													<div class=\"post--info\">
														<ul class=\"nav meta\">
															<li><a href=\"#\">$author</a></li>
															<li><a href=\"#\">$date</a></li>
														</ul>
														<div class=\"title\">
															<h2 class=\"sliderTitle\"><a href=\"details-$tid\" class=\"btn-link\">$title.</a></h2> </div>
													</div>
												</div>
											  </div>
										    </div>";
										   }
										   

										   else if($count>8 && $count<=9)
										   {
											 $contentDown .= "<div class=\"post--item post--layout-1 post--title-larger\">
											 <div class=\"post--img\">
												<a href=\"details-$tid\" class=\"thumb\"><img src=\"./post_images/$img\" class=\"sliderIm\" alt=\"\" class=\"SlImg\"></a> <a href=\"#\" class=\"cat\">$topCatNewsName</a> 
												<div class=\"post--info\">
													<ul class=\"nav meta\">
														<li><a href=\"#\">$author</a></li>
														<li><a href=\"#\">$date</a></li>
													</ul>
													<div class=\"title\">
														<h2 class=\"h4\"><a href=\"details-$tid\" class=\"btn-link\">$title.</a></h2> </div>
												    </div>
											   </div>
										      </div>";
										    }
											
										    $count++;
							            }
						            }
						        ?>
                             </div>
							</div>
							<div class="col-md-6">
								<div class="row gutter--15">
									
									 <?=$contentRight?>	
									 
									
									<div class="col-sm-12 hidden-sm hidden-xs">
										<?=$contentDown?>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>		
				
				<div class="row">
					<div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
						<div class="sticky-content-inner">
							<div class="row">
								<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[0]['name']?></h2>
										
									</div>
									<div class="post--items post--items-2" data-ajax-content="outer">
									 <ul class="nav row gutter--15" data-ajax-content="inner">
											

									<?php

										$postContent=post_content($db,$categoryList[0]['id'],$offset=0,$limit=8);
										$count=1;
										$left="";
										$right="";
											

										if(count($postContent)>0)
										{
										  foreach($postContent as $key=>$value)
										  {
											$catImg=$value['post_image'];
											$catTitle=strip_tags($value['title']);
											$catDate=date("d M Y",strtotime($value['created_on']));
											$catAuthor=$value['author'];
											$catId=base64_encode($value['id']);
											$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);
                                               
											
											
												if($count<=1)
                                                {
												  echo"<li class=\"col-xs-12\">
												    <div class=\"post--item post--layout-1\">
													<div class=\"post--img\">
														<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>  
														<div class=\"post--info\">
															<ul class=\"nav meta\">
																<li><a href=\"#\">$catAuthor</a></li>
																<li><a href=\"#\">$catDate</a></li>
															</ul>
															<div class=\"title\">
																<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
														   </div>
													    </div>
												     </div>
											         </li>";
												}
												elseif($count>1 && $count<=3)
												{
														
													$left.="<li class=\"col-xs-6\">
													<div class=\"post--item post--layout-2\">
													 <div class=\"post--img\">
														<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
														<div class=\"post--info\">
														 <ul class=\"nav meta\">
														  <li><a href=\"#\">$catAuthor</a></li>
														  <li><a href=\"#\">$catDate</a></li>
														 </ul>
														 <div class=\"title\">
														  <h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
												</div></li>";
												}
                                                elseif($count>3 && $count<=5)
												{
													$right.="<li class=\"col-xs-6\">
													<div class=\"post--item post--layout-2\">
													 <div class=\"post--img\">
													  <a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\"  alt=\"\"></a>
													   <div class=\"post--info\">
														<ul class=\"nav meta\">
														 <li><a href=\"#\">$catAuthor</a></li>
														 <li><a href=\"#\">$catDate</a></li>
														</ul>
														<div class=\"title\">
														 <h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a>
														 </h3> 
														</div>
																</div>
													</div>
												</div></li>";
												}
										            $count++;
                                                }
                                            }

										?>
										
										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$left?>
									   

										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$right?>
									    												
										</ul>
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
								<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[5]['name']?></h2>
										
									</div>
									<div class="post--items post--items-3" data-ajax-content="outer">
									 <ul class="nav" data-ajax-content="inner">

										<?php

											$postContent=post_content($db,$categoryList[5]['id'],$offset=0,$limit=8);
											$count=1;
											
											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);

													if($count<=1)
                                                    {
													  echo "<li>
														<div class=\"post--item post--layout-1\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>  
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
														</div>
													  </li>";
													}
                                                   
													elseif($count>1 && $count<=5)
                                                    {
												
														echo "<li>
															<div class=\"post--item post--layout-3\">
																<div class=\"post--img\">
																	<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>
																	<div class=\"post--info\">
																		<ul class=\"nav meta\">
																			<li><a href=\"#\">$catAuthor</a></li>
																			<li><a href=\"#\">$catDate</a></li>
																		</ul>
																		<div class=\"title\">
																			<h3 class=\"h4\"><a href=\"details-$catId\"
																			class=\"btn-link\">$catTitle.</a></h3> </div>
																	</div>
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
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
								<div class="col-md-12 ptop--30 pbottom--30">
									<div class="ad--space">
										<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2559414196896524"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-i2+f+w-b4+i1"
     data-ad-client="ca-pub-2559414196896524"
     data-ad-slot="3121933308"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
									</div>
								</div>
								<div class="col-md-12 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[14]['name']?></h2>
										
									</div>
									<div class="post--items post--items-2" data-ajax-content="outer">
										<ul class="nav row" data-ajax-content="inner">

										<?php

											$postContent=post_content($db,$categoryList[14]['id'],$offset=0,$limit=8);
											$count=1;
											$left="";
											$right="";
											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=40);
													
																																	if($count<=1)
																																	{
														
											        echo"<li class=\"col-md-6\">
												    <div class=\"post--item post--layout-2\">
													<div class=\"post--img\">
														<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"> 
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
												elseif($count>1 && $count<=3)
												{
												
														$left.="<li class=\"col-xs-6\">
															<div class=\"post--item post--layout-2\">
																<div class=\"post--img\">
																	<a href=\"details-$catId\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>
																	<div class=\"post--info\">
																		<ul class=\"nav meta\">
																			<li><a href=\"#\">$catAuthor</a></li>
																			<li><a href=\"#\">$catDate</a></li>
																		</ul>
																		<div class=\"title\">
																			<h3 class=\"h4\"><a href=\"details-$catId\"
																			class=\"btn-link\">$catTitle.</a></h3> </div>
																	</div>
																</div>
															</div>
														</li>";

														
													}
													elseif($count>3 && $count<=5)
													{
														
														$right.="<li class=\"col-xs-6\">
															<div class=\"post--item post--layout-2\">
																<div class=\"post--img\">
																	<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>
																	<div class=\"post--info\">
																		<ul class=\"nav meta\">
																			<li><a href=\"#\">$catAuthor</a></li>
																			<li><a href=\"#\">$catDate</a></li>
																		</ul>
																		<div class=\"title\">
																			<h3 class=\"h4\"><a href=\"details-$catId\"
																			class=\"btn-link\">$catTitle.</a></h3> </div>
																	</div>
																</div>
															</div>
														</li>";
													}

														$count++;
													}
												}
												?>
													
													<li class="col-md-6">
													<ul class="nav row">
														<li class="col-xs-12 hidden-md hidden-lg">
															<hr class="divider"> </li>
															<?=$left?>	

															<li class="col-xs-12">
															<hr class="divider"> </li>
															<?=$right?>		
												    </ul>
											       </li>
										</ul>
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>



								<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[16]['name']?></h2>
									
									</div>
									<div class="post--items post--items-2" data-ajax-content="outer">
										<ul class="nav row gutter--15" data-ajax-content="inner">
											

										<?php

											$postContent=post_content($db,$categoryList[16]['id'],$offset=0,$limit=8);
											$count=1;
											$left="";
											$right="";
											

											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);

												 if($count<=1)
                                                 {
													echo"<li class=\"col-xs-12\">
												    <div class=\"post--item post--layout-1\">
													<div class=\"post--img\">
														<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"> 
														<div class=\"post--info\">
															<ul class=\"nav meta\">
																<li><a href=\"#\">$catAuthor</a></li>
																<li><a href=\"#\">$catDate</a></li>
															</ul>
															<div class=\"title\">
																<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
														   </div>
													    </div>
												     </div>
											         </li>";
														}
														elseif($count>1 && $count<=3)
														{
														
														$left.="<li class=\"col-xs-6\">
														<div class=\"post--item post--layout-2\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
															</div></li>
															";
														}
                                                        elseif($count>3 && $count<=5)
														{
															
															$right.="<li class=\"col-xs-6\">
														<div class=\"post--item post--layout-2\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
															</div></li>
															";
														}
										                 $count++;
                                                }
                                            }

										?>
										
										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$left?>
									   

										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$right?>
									    												
										</ul>
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
								<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[102]['name']?></h2>
										
									</div>
									<div class="post--items post--items-3" data-ajax-content="outer">
										<ul class="nav" data-ajax-content="inner">


										<?php

											$postContent=post_content($db,$categoryList[102]['id'],$offset=0,$limit=8);
											$count=1;
											
											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);

													if($count<=1)
                                                    {
													  echo "<li>
														<div class=\"post--item post--layout-1\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>  
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
														</div>
													  </li>";
													}
                                                   
													elseif($count>1 && $count<=5)
                                                    {
												
														echo "<li>
															<div class=\"post--item post--layout-3\">
																<div class=\"post--img\">
																	<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>
																	<div class=\"post--info\">
																		<ul class=\"nav meta\">
																			<li><a href=\"#\">$catAuthor</a></li>
																			<li><a href=\"#\">$catDate</a></li>
																		</ul>
																		<div class=\"title\">
																			<h3 class=\"h4\"><a href=\"details-$catId\"
																			class=\"btn-link\">$catTitle.</a></h3> </div>
																	</div>
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
			

										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					
				<?php include("includes/commonSidebarTop.php");?>
				<div class="main--content pd--30-0">
					<div class="post--items-title" data-ajax="tab">
						<h2 class="h4">वीडियो</h2>
						
					</div>
					<div class="post--items post--items-4" data-ajax-content="outer">
					 <ul class="nav row" data-ajax-content="inner">
						<?php
                            
							$count=1;
							$countList="A1";
							$contentRight="";
                            if(count($videoPostContent)>0)
                            {
                                foreach($videoPostContent as $key=>$value)
                                {
                                    
									
                                    $catImg=$value['post_image'];
                                    $catTitle=strip_tags($value['title']);
                                    $catId=base64_encode($value['id']);
                                    $catDate=date("d M Y",strtotime($value['created_on']));
                                    $catAuthor=$value['author'];
                                    $videoLink=$value['video_link'];
								
										
                                     
									$pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
									
									
									if($count<=3)
									{
												
									    if(preg_match($pattern, $videoLink)) 
									    {
									
										
									      preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
									      $vidcode = $matches[1][0];
									  		
											
											echo"<li class=\"col-md-8\" id=\"$count\">
											<div class=\"post--item post--layout-1 post--type-video post--title-large\">
											<div class=\"post--img\">
											
												<iframe  id='#$catId' src=\"https://www.youtube.com/embed/$vidcode \" class=\"thumb\" height=\"400px\" width=\"750px\"><img src=\"./post_images/$catImg\"  alt=\"\"></iframe>
												
												</div>
												<hr class=\"divider hidden-md hidden-lg\"> 
											</li>";
									    }
										else{

											echo"<li class=\"col-md-8\" id=\"$count\">
											<div class=\"post--item post--layout-1 post--type-video post--title-large\">
											
												
                                            <video id='#$catId' controls poster=' ./post_images/$catImg' height=\"400px\" width=\"650px\">   
										    
                                              <source src='$videoLink' type='video/mp4' target='_blank'>
												
												
                                            </video>

                                                
												
												
												<hr class=\"divider hidden-md hidden-lg\"> 
											</li>";
											

										}
									}
										
									if($count>=1 && $count<=3)
									{
													
										$contentRight.="<li>
											<div class=\"post--item post--type-audio post--layout-3\" id=\"$countList\">
												<div class=\"post--img\" >
												<a href=\" #$count\" class=\"thumb\"><img src=\"./post_images/$catImg\"  alt=\"\" ></a>
													<div class=\"post--info\">
														<ul class=\"nav meta\">
														<li><span>$catAuthor</span></li>
														<li><span>$catDate</span></li>
														</ul>
														<div class=\"title\">
														<h3 class=\"h4\"><a href=\" #$count\" class=\"btn-link\">$catTitle.</a></h3>
														</div>
													</div>
												</div>
												</div>  
											</li>";
									}
											
									$count++;
									$countList++;
										
						        }
					        }
					    ?>

                                <li class="col-md-4">
								 <ul class="nav">

							        <?=$contentRight?>
									
						         </ul>	
						        </li>  
							
						</ul>
						<!-- <div class="preloader bg--color-0--b" data-preloader="1">
							<div class="preloader--inner"></div>
						</div> -->
					</div>
				</div>
				<div class="ad--space pd--30-0">
					<a href="#"> <img src="img/ads-img/ad-970x90.jpg" alt="" class="center-block"> </a>
				</div>
				<div class="row">
					<div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
						<div class="sticky-content-inner">
							<div class="row">
							<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[19]['name']?></h2>
										
									</div>
									<div class="post--items post--items-3" data-ajax-content="outer">
										<ul class="nav" data-ajax-content="inner">


										<?php

											$postContent=post_content($db,$categoryList[19]['id'],$offset=0,$limit=8);
											$count=1;
											
											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);

													if($count<=1)
                                                    {
													  echo "<li>
														<div class=\"post--item post--layout-1\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>  
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
														</div>
													  </li>";
													}
                                                   
													elseif($count>1 && $count<=5)
                                                    {
												
														echo "<li>
															<div class=\"post--item post--layout-3\">
																<div class=\"post--img\">
																	<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"post\"></a>
																	<div class=\"post--info\">
																		<ul class=\"nav meta\">
																			<li><a href=\"#\">$catAuthor</a></li>
																			<li><a href=\"#\">$catDate</a></li>
																		</ul>
																		<div class=\"title\">
																			<h3 class=\"h4\"><a href=\"details-$catId\"
																			class=\"btn-link\">$catTitle.</a></h3> </div>
																	</div>
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
					                     <!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
								<div class="col-md-6 ptop--30 pbottom--30">
									<div class="post--items-title" data-ajax="tab">
										<h2 class="h4"><?=$categoryList[18]['name']?></h2>
										
									</div>
									<div class="post--items post--items-2" data-ajax-content="outer">
										<ul class="nav row gutter--15" data-ajax-content="inner">
											

										<?php

											$postContent=post_content($db,$categoryList[18]['id'],$offset=0,$limit=8);
											$count=1;
											$left="";
											$right="";
											

											if(count($postContent)>0)
											{
												foreach($postContent as $key=>$value)
												{
													$catImg=$value['post_image'];
													$catTitle=strip_tags($value['title']);
													
													$catDate=date("d M Y",strtotime($value['created_on']));
													$catAuthor=$value['author'];
													$catId=base64_encode($value['id']);
													$catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);

												 if($count<=1)
                                                 {
													echo"<li class=\"col-xs-12\">
												    <div class=\"post--item post--layout-1\">
													<div class=\"post--img\">
														<a href==\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"> 
														<div class=\"post--info\">
															<ul class=\"nav meta\">
																<li><a href=\"#\">$catAuthor</a></li>
																<li><a href=\"#\">$catDate</a></li>
															</ul>
															<div class=\"title\">
																<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
														   </div>
													    </div>
												     </div>
											         </li>";
														}
														elseif($count>1 && $count<=3)
														{
														
														$left.="<li class=\"col-xs-6\">
														<div class=\"post--item post--layout-2\">
															<div class=\"post--img\">
																<a href==\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
															</div></li>
															";
														}
                                                        elseif($count>3 && $count<=5)
														{
															$right.="<li class=\"col-xs-6\">
														<div class=\"post--item post--layout-2\">
															<div class=\"post--img\">
																<a href=\"details-$catId\" class=\"thumb\"><img src=\"./post_images/$catImg\" alt=\"\"></a>
																<div class=\"post--info\">
																	<ul class=\"nav meta\">
																		<li><a href=\"#\">$catAuthor</a></li>
																		<li><a href=\"#\">$catDate</a></li>
																	</ul>
																	<div class=\"title\">
																		<h3 class=\"h4\"><a href=\"details-$catId\">$catTitle.</a></h3> </div>
																</div>
															</div>
															</div></li>
															";
														}
										                 $count++;
                                                }
                                            }

										?>
										
										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$left?>
									   

										<li class="col-xs-12">
										<hr class="divider"> </li>
										<?=$right?>
									    												
										</ul>
										<!-- <div class="preloader bg--color-0--b" data-preloader="1">
											<div class="preloader--inner"></div>
										</div> -->
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<?php include("includes/commonSidebarBottom.php");?>
				</div>
			</div>
		</div>
		<?php include("includes/commonFooter.php")?>
	</div>
	
	<div id="backToTop"> <a href="#"><i class="fa fa-angle-double-up"></i></a> </div>
	<?php include ("includes/commonJs.php");?>
	<script src="<?=$redirectPath_site?>/js/custom.js"></script>
	<amp-ad width="100vw" height="320"
     type="adsense"
     data-ad-client="ca-pub-2559414196896524"
     data-ad-slot="3893795783"
     data-auto-format="rspv"
     data-full-width="">
  <div overflow=""></div>
</amp-ad>

</body>

</html>

	

