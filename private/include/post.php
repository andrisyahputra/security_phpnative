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
	<center><h1>Posts</h1></center>

	<?php include('header.php'); ?>

	<div class="container">

		<center><h1 style="color:#f0f;">Single Posts</h1></center>
			<?php
				//get posts
				//get posts
				$posts = new Posts();
                if(isset($_GET['id'])) :
				$result = $posts->get_one_posts($_GET['id']);
			?>
                    <?php 	if($result) : ?>
						
						<?php foreach($result as $item) : ?>
							<div class='post'>
								<div>
									<h2><?= $item['title']; ?></h2>
								</div>
								<p class='text'><?= $item['post']; ?></p>
								<p class='timestamp'><?= date("jS M, Y",strtotime($item['date'])); ?></p>
								<br style='clear: both;'>
							</div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <p>Maaf tidak ada konten</p>
                    <?php endif; ?>
	</div>
</body>
</html>