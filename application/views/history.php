<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>History</title>
        <style>
			body{
				font-family:Tahoma, Geneva, sans-serif;	
			}
            ul {
				width:100%;
				margin:0;
				padding:0;
				max-width:1000px;
				margin:auto;
			}
			li {
				width:100%;
				float:left;
				list-style-type: none;
				display:inline-block;
				font-size:18px;
				border-bottom:1px solid #000;
			}
			li:hover{ background-color:#E9E9E9; }
			a, a:hover{ color:#000; text-decoration:none; padding:15px; display:block; }
        </style>
    </head>
    <body>
    	<ul>
        	<li><a href="index.php">&lt;&lt; Back</a></li>
        <?php
			foreach($keyword_list as $item){
		?>
        	<li><a href="index.php?address=<?= $item->keyword; ?>"><?= $item->keyword; ?></a></li>
        <?php
			}
		?>
        </ul>
    </body>
</html>
