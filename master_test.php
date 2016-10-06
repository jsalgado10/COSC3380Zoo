<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
$user_id = $_SESSION['user_session'];
$result = $DB_con->prepare("SELECT customerEmail as UserName FROM customer WHERE customerID=:user_id union select staffEmail as UserName from Staff where staffID=:user_id");
$result->execute(array(":user_id"=>$user_id));
$userRow=$result->fetchObject();
?>
<html>
	<head>
		<style>
		#content{
	background-color: #fff3e6;
	width: 960px;
	margin: 0 auto;
	overflow: hidden;
	height: auto;
	padding-bottom: 30px;
}
		
		
		#content div#featured{
	background:url(../images/interface.gif) no-repeat;
	height: 191px;
	padding: 0;
	float: none;
	margin-top: 7px;
	clear: both;
}
#content #featured h2{
	color: #8E0519;
    font-family: arial;
    margin: 0;
    padding: 20px 0 0 30px;
    text-shadow: 0 1px 1px #FFFFFF;
	font-size: 29px;
}
#content #featured ul{
	margin: 0;
	padding: 5px 0 0 30px;
	list-style: none;
	height: auto;
	overflow: hidden;
	float: left;
	width: auto;
}
#content #featured ul li.first{
	margin-left: 0;
}
#content #featured ul li{
	float:left;
	text-align: center;
	margin-left: 15px;
	border: 0;
}
#content #featured ul li.last a img{
	border: 0!important;
}
#content #featured ul li a{
	border: 0 none;
    color: #271500;
    display: block;
    float: none;
    font-family: arial;
    font-size: 14px;
    margin: 0;
    text-decoration: none;
	text-indent: 0;
	background: none;
	width: auto;
	height: auto;
}
#content #featured ul li a:hover{
	background: none;
}
#content #featured ul li a img{
	border: 1px solid #f4e5cd !important;
	float: none;
}
#content #featured ul li a img:hover{
	filter:alpha(opacity=80);
	opacity:0.8;
}
#content #featured  a img{
	border: 0!important;
	margin-right: 0;
	float: none;
}
#content div.featured{
	background:url(../images/interface.gif) no-repeat -3px 0;
	height: 191px;
	padding: 0;
	float: none;
	margin-top: 7px;
	clear: both;
}
#content .featured h2{
	color: #8E0519;
    font-family: arial;
    margin: 0;
    padding: 20px 0 0 30px;
    text-shadow: 0 1px 1px #FFFFFF;
	font-size: 29px;
}
#content .featured ul{
	margin: 0;
	padding: 5px 0 0 30px;
	list-style: none;
	height: auto;
	overflow: hidden;
	float: left;
	width: auto;
}
#content .featured ul li.first{
	margin-left: 0;
}
#content .featured ul li{
	float:left;
	text-align: center;
	margin-left: 19px;
	border: 0;
}
#content .featured ul li a{
	border: 0 none;
    color: #271500;
    display: block;
    float: none;
    font-family: arial;
    font-size: 14px;
    margin: 0;
    text-decoration: none;
	text-indent: 0;
	background: none;
	width: auto;
	height: auto;
}
#content .featured ul li a:hover{
	background: none;
}
#content .featured ul li a img{
	border: 1px solid #f4e5cd !important;
	float: none;
}
#content .featured ul li.last a{
    color: #ab9675;
	font-weight:bold;
	text-shadow: 0 1px 0 #f4e5cd;
}
#content .featured ul li.last a img{
	border: 0!important;
	padding:0 0 11px 0;
}
#content .featured ul li a img:hover{
	filter:alpha(opacity=80);
	opacity:0.8;
}
#content .featured  a{
	float: left;
	margin: 18px 0 0 13px;
	text-decoration: none;
	padding: 0;
	border: 0;
	background: url(../images/button.gif) no-repeat;
	width: 78px;
	height: 78px;
	text-indent: -99999px;
}


#calendar h2{
	color: #8E0519;
    font-family: arial;
    margin: 0;
    padding: 20px 0 0 30px;
    text-shadow: 0 1px 1px #FFFFFF;
	font-size: 29px;
}
		
		</style>
	</head>
	<body>
		
	<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Home";
	include("master.php");
	?>

	
	<div id="content">
				<div id="featured">
					<h2>Meet our Animals</h2>
					<ul>
						<li class="first">
							<a href="gallery.php"><img src="images/animals/penguin.jpg" alt=""/></a>
							<a href="gallery.php">Duis laoreet</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/elephant.jpg" alt=""/></a>
							<a href="gallery.php">Curabitur</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/owl.jpg" alt=""/></a>
							<a href="gallery.php">Adipiscing</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/butterfly.jpg" alt=""/></a>
							<a href="gallery.php">Sed Volutpat</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/turtle.jpg" alt=""/></a>
							<a href="gallery.php">Nulla lobortis</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/snake.jpg" alt=""/></a>
							<a href="gallery.php">Suspendisse</a>
						</li>
						<li>
							<a href="gallery.php"><img src="images/animals/gorilla.jpg" alt=""/></a>
							<a href="gallery.php">Tincidunt</a>
						</li>
						<li class="last">
							<a href="gallery.php"><img src="images/animals/button-view-gallery.jpg" alt=""/></a>
							<a href="gallery.php">Gallery</a>
						</li>
					</ul>
				</div>
			
				
				<div id="calendar">
					<h2>Events</h2>
					<iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=m7qh7dkup0ivaquo2mmi0d7jns%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=America%2FChicago" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
					
				</div>
	</body>
</html>
