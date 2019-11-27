<?php
session_start();
require 'config.php';
require 'db.class.php';

if ( !isset($_SESSION['user_id']) ) {
    $_SESSION['user_id'] = 0;
}

$username = '';
$db = MySqlii::getInstance();
if ( isset($_SESSION['user_id']) && intval($_SESSION['user_id'])>0 ) {
    $sql_ = 'SELECT username FROM ' . DB_PREFIX . 'user WHERE id=' . $_SESSION['user_id'];
    $query_ = $db->query($sql_);
    $row_ = $db->fetch_array($query_);
    $username = $row_['username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>idoc - A simple and effective ebook creator</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="idoc, technical team api document, development api document, api document, personal writing tool, make ebook, pubish electronic book" />
<script type="application/x-javascript">
	addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
	function hideURLbar(){ window.scrollTo(0,1); }
</script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="css/style2.css" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/google-latin-ext.css" rel="stylesheet">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script async defer src="js/github-buttons.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<script src="js/modernizr.js"></script>
</head> 
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
	<!-- banner -->
	<div id="home" class="w3ls-banner"> 
		<!-- header -->
		<div class="header-w3layouts">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header page-scroll">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">travel</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
						<h2><a class="navbar-brand" href="/"><i class="fa fa-angle-double-right w3-logo" aria-hidden="true"></i>Idoc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></h2>
						<P>enjoy writing</P>
					</div>
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="hidden"><a class="page-scroll" href="#page-top"></a>	</li>
							<li><a class="page-scroll scroll" href="#home">首页</a></li>
							<li><a class="page-scroll scroll" href="#about">关于</a></li>
                            <li><a href="/book.php?id=14" target="_blank">示例</a></li>
                            <li><a class="page-scroll scroll" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">联系</a></li>
                            <li style="padding-top:10px;"><a class="github-button" href="https://github.com/coderzheng/idoc/fork" data-icon="octicon-repo-forked" data-size="large" aria-label="Fork coderzheng/idoc on GitHub">Fork</a></li>
                            <?php
                            if ( !empty($username) ) {
                                echo '<li><a href="projects.php">我的项目</a></li>';
                            }
                            ?>
                            <?php
                            if ( empty($username) ) {
                            ?>
                                <li id="last">
                                    <a href="admin/login.php" id="last_a">登录/注册</a>
                                </li>
                            <?php } else {?>
                                <li id="last">
                                    <a href="admin/index.php" id="last_a"><?php echo $username;?></a>
                                    <ul class="child-nav">
                                        <li><a href="admin/index.php">去后台</a>&nbsp;|&nbsp;<a href="./logout.php">退出</a></li>
                                    </ul>
                                </li>
                            <?php }?>

						</ul>
					</div>
				</div>
			</nav>  
		</div>	
        <div class="banner-top">
            <div class="slider">
                <div class="callbacks_container">
                    <ul class="rslides callbacks callbacks1" id="slider4">
                        <li>
                            <div class="w3layouts-banner-top">
                                <div class="container">
                                    <div class="agileits-banner-info jarallax">
                                        <h3 class="agile-title">可用于制作电子书</h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts-banner-top w3layouts-banner-top2">
                                <div class="container">
                                    <div class="agileits-banner-info2 jarallax">
                                        <h3 class="agile-title">非常适合用来编写接口文档</h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts-banner-top w3layouts-banner-top3">
                                <div class="container">
                                    <div class="agileits-banner-info3 jarallax">
                                        <h3 class="agile-title">基于markdown编辑器</h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
                <script src="js/responsiveslides.min.js"></script>
                <script type="text/javascript">
                            // You can also use "$(window).load(function() {"
                            $(function () {
                              // Slideshow 4
                              $("#slider4").responsiveSlides({
                                auto: true,
                                pager:true,
                                nav:false,
                                speed: 500,
                                namespace: "callbacks",
                                before: function () {
                                  $('.events').append("<li>before event fired.</li>");
                                },
                                after: function () {
                                  $('.events').append("<li>after event fired.</li>");
                                }
                              });

                            });
                </script>
                <!--banner Slider starts Here-->
            </div>
        </div>
        <!-- about -->
        <div class="w3layouts-about" id="about">
            <div class="container">
                <div class="w3-about-grids">
                    <div class="col-md-6 w3-about-left">
                          <section class="slider">
                            <div id="slider" class="flexslider">
                              <ul class="slides">
                                  <li>
                                      <img src="images/6.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/7.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/8.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/9.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/6.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/7.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/8.jpg" alt="" />
                                  </li>
                                  <li>
                                      <img src="images/9.jpg" alt="" />
                                  </li>
                              </ul>
                            </div>
                            <div id="carousel" class="flexslider">
                              <ul class="slides">
                                <li>
                                    <img src="images/6.jpg" alt="" />
                                </li>
                                <li>
                                    <img src="images/7.jpg" alt="" />
                                </li>
                                <li>
                                    <img src="images/8.jpg" alt="" />
                                </li>
                                <li>
                                    <img src="images/9.jpg" alt="" />
                                </li>
                                <li>
                                  <img src="images/6.jpg" alt="" />
                                </li>
                                <li>
                                  <img src="images/7.jpg" alt="" />
                                </li>
                                <li>
                                  <img src="images/8.jpg" alt="" />
                                </li>
                                <li>
                                  <img src="images/9.jpg" alt="" />
                                </li>
                              </ul>
                            </div>
                          </section>
                    </div>
                    <div class="col-md-6 w3-about-left">
                        <h1>idoc是什么？</h1>
                        <h5>电子书编辑器/API文档编辑器/企业内部wiki</h5>
                        <p><span>idoc自诞生之日起就有非常精准的定位：<br />
                            1) <del>不依赖于任何框架, 只要支持PHP环境就能使用</del><br />
                            2) 同时支持多种数据库<del>mysql</del>/access/sqlite3<br />
                            3) 所有项目均支持导出, 同时可选多种导出格式<br />
                            4) 方便快捷的成员权限管理<br />
                            5) 集成授权功能(创作者可以设置将内容仅授权给付费用户)<br />
                            6) <del>程序内嵌了防XSRF攻击的代码, 有效保护您的页面不被非法分子利用</del><br />
                            7) 支持文章内容防采集功能<br />
                            8) <del>程序内部采用了一种松散的耦合结构, 非常方便开发者进行二次扩展</del><br />
                            9) 程序采用主题方式来渲染页面, 用户可以自己创作主题来显示页面<br />
                        </span></p>
                        <div class="w3l-button">
                                <p>下载地址：<a class="github-button" href="https://github.com/coderzheng/idoc/archive/master.zip" data-size="large" aria-label="Download coderzheng/idoc on GitHub">Download</a></p>
                                <p>安装方法：下载后阅读README.md即可</p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <!-- modal -->
	<div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						<h4 class="modal-title">感谢您的建议</h4>
				</div> 
				<div class="modal-body">
					<div class="agileits-w3layouts-info" style="font-size:18px;">
						<p>对idoc的任何疑问或者建议, 都可发送至coderzheng@foxmail.com, ^^</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="js/owl.carousel.js"></script>  
	<script>
		$(document).ready(function() { 
			$("#owl-demo").owlCarousel({
			  autoPlay: true, //Set AutoPlay to 3 seconds
			  items :3,
			  itemsDesktop : [640,2],
			  itemsDesktopSmall : [414,1],
			  navigation : true,
			  // THIS IS THE NEW PART
				afterAction: function(el){
					//remove class active
					this
					.$owlItems
					.removeClass('active')
					//add class active
					this
					.$owlItems //owl internal $ object containing items
					.eq(this.currentItem + 1)
					.addClass('active')
					}
			// END NEW PART
			});

			$('li#last').hover(function(){
			    $(this).children('ul.child-nav').show();
            }, function(){
                $(this).children('ul.child-nav').hide();
            });
			
		}); 
	</script>
<!-- copyright -->
<div class="copyright">
		<p>© 2019 idoc. All Rights Reserved | Design by <a href="http://idoc.codespeaking.com/" target="=_blank"> idoc </a></p>
</div>
<!-- //copyright -->
<!--//footer -->				
<!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>
	<script type="text/javascript">
    $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: true,
        slideshow: false,
        itemWidth: 102,
        itemMargin: 5,
        asNavFor: '#slider'
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: true,
        slideshow: true,
        sync: "#carousel",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
<!-- //FlexSlider -->
<!-- Tour-Locations-JavaScript -->
			<script src="js/classie.js"></script>
			<script src="js/helper.js"></script>
			<script src="js/grid3d.js"></script>
			<script>
				//new grid3D( document.getElementById( 'grid3d' ) );
			</script>
<!-- //Tour-Locations-JavaScript -->
<script src="js/jarallax.js"></script>
<script type="text/javascript">
	/* init Jarallax */
	$('.jarallax').jarallax({
		speed: 0.5,
		imgWidth: 1366,
		imgHeight: 768
	})
</script><!-- //js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- here starts scrolling icon -->
		<script type="text/javascript">
			$(document).ready(function() {
				/*
					var defaults = {
					containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
					};
				*/
										
				$().UItoTop({ easingType: 'easeOutQuart' });
									
				});
		</script>

<!-- start-smoth-scrolling -->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
		<!-- /ends-smoth-scrolling -->
	<!-- //here ends scrolling icon -->
</body>	
</html>

