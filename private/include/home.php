<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
</head>
<body>

	<style type="text/css">
		*{
			font-family: tahoma;
			font-size: 14px;
		}

		.container{
			padding: 10px;
			box-shadow: 0px 0px 10px #aaa;
			margin: auto;
			margin-top: 20px;
			width: 100%;
			max-width: 800px;
			min-height: 100px;

		}

		.post{
			border-bottom: solid thin #ccc;
		}
		.text{
			padding:4px;
			background-color:#eee;
		}
		.timestamp{
			font-size: 12px; 
			color: #aaa;
			float: right;
		}

	</style>
	<center><h1>Home</h1></center>
	

	<div class="container">

		<?php include('header.php'); ?>
		
		<center><h1 style="color:#f0f;">Featured Posts</h1></center>
		<?php

			//connect to database
			

			//get posts
			$posts = new Posts();
			$result = $posts->get_home_posts();
		?>
		<?php 	if($result) : ?>
					
					<?php foreach($result as $item) : ?>

						<div class='post'>
							<div>
								<h2><?= $item['title']; ?></h2>
							</div>
							<p class='text'><?= substr($item['post'],0,200); ?></p>
							<a href='post?id=<?= $item['id'] ?>'>..read more..</a>
							<p class='timestamp'><?= date("jS M, Y",strtotime($item['date'])) ?></p>
							<br style='clear: both;'>
						</div>
				<?php endforeach; ?>
			<?php endif; ?>


	</div>
</body>
</html>