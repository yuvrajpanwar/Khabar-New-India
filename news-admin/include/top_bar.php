			 <?php
				
				$count_Com_Un = 0;
				
		   ?>
		   <div class='quick-area'>
                <div class='pull-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="sidebar-toggle-wrap">
                            <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
						<?php 
						//$user_type=$_SESSION['loginType'];
						if($_SESSION['loginType']=="administrator")
						{	
						?>
                        <li class="message-toggle-wrapper">
                            
                            <ul class="dropdown-menu messages animated fadeIn">

                                <li class="list">
									
                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
											<?php
											if($count_Com_Un)
											{
												while($fetch_Com_Un=$sel_Com_Un->fetch(PDO::FETCH_ASSOC))
												{
													$user_name=ucfirst($fetch_Com_Un['name']);
													$image_name=$fetch_Com_Un['image'];
													$post_id_un=$fetch_Com_Un['post_id'];
													$enc_un_id=base64_encode($post_id_un);
													$image_path="../user-profile/".$image_name;
													$image_url="";
													if($image_name)
													{$image_url=$image_path;}
													else
													{$image_url="../user-profile/user.png";}
												
													echo" <li class='unread status-available'>
															<a href='post_details.php?tid=$enc_un_id'>
																<div class='user-img'>
																	<img src='$image_url' style='width:25px; height:25px;' alt='user-image' class='img-circle img-inline'>
																</div>
																<div>
																	<span class='name'>
																		<strong>$user_name</strong>
																		<span class='profile-status available pull-right'></span>
																	</span>
																	<span class='desc small'>
																		Comment on a Post.
																	</span>
																</div>
															</a>
														</li>";
												}	
											}											
											
										?>

                                    </ul>

                                </li>

                                <li class="external" style='background-color: #9972B5;'>
                                    <a href="http://khabarnewindia.com/" target="_blank">
									 khabarnewindia News
                                    </a>
                                </li>
                            </ul>

                        </li>
						<?php }?>
						<li class="external site_visit ">
                                    <a href="http://khabarnewindia.com/" class="site_name" target="_blank" style='font-size: 25px;text-decoration: none;'>
									<b>Khabar New India - सोच ईमानदार, खबर दमदार </b>
                                    </a>
							<ul class="dropdown-menu profile animated fadeIn">
                               
                                <li>
                                    <a href="chnage_password.php">
                                        <i class="fa fa-info"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li class="last">
                                    <a href="logout.php">
                                        <i class="fa fa-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
						</li>
                        
                    </ul>
                </div>		
                <div class='pull-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile" style='margin-right: 59px;'>
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <!--<img src="data/profile/profile.png" alt="user-image" class="img-circle img-inline">-->
                                <span>Admin <i class="fa fa-angle-down"></i></span>
                            </a>
						
                            <ul class="dropdown-menu profile animated fadeIn">
                                	<?php 
								//$user_type=$_SESSION['loginType'];
								if($_SESSION['loginType']=="administrator")
								{	
								?>
                                <li>
                                    <a href="chnage_password.php">
                                        <i class="fa fa-info"></i>
                                        Change Password
                                    </a>
                                </li>
								<?php }?>
                                <li class="last">
                                    <a href="logout.php">
                                        <i class="fa fa-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
						
                        </li>
                        <li class="chat-toggle-wrapper">
                            <a href="#" data-toggle="chatbar" class="toggle_chat">
                                <!--<i class="fa fa-comments"></i>
                                <span class="badge badge-warning">9</span>
                                <i class="fa fa-times"></i>-->
                            </a>
                        </li>
                    </ul>			
                </div>		
            </div>