<html>
	<head>

	</head>
	<body>
		
		<div id="top">
			<div id="logo" ></div>
		
		</div>
		
		<div id="left">
		
		</div>
		
		<div id="center">
			<!--course-->
			<?php //include("/front/course.php");?>
			<p id="english_game_btn" style="cursor:pointer;width:150px">English Game</p>
		</div>
		
		<div id="right">
		
		</div>
		
		<!--english game-->
		
		<div id='timer' />
		
		<div id="sentence_dialog" style="display:none">
			<div class="loader"><img title="Loading" src="images/loader.gif"></div>
			<div class="english_game_main">
				
				<div id="englishgameimage">
					<img src="front/images/english_games/sentence/englishgameimage.png" width="290" height="178" />
				</div>
				<div id="welcomelabelbg">
					<img src="front/images/english_games/sentence/welcomelabelbg.png" width="292" height="33" />
				</div>
				<div id="welcomelabel">
					Welcome : User
				</div>
				<div id="englishgamelabel">
					English Game
				</div>
				<div class="timer">
					<div id="timelabel">
						TIME
					</div>
					<div id="timefield">
						00:00
					</div>
				</div>
				<div id="gametitle">
					Sentence Perfection
				</div>
				<div class="game_field">
					<div id="levellabel">
						Level :
					</div>
					<div id="levelfield">
						<img src="front/images/english_games/sentence/levelfield.png" width="70" height="14" />
					</div>
					<div id="levelfieldbg">
						<img src="front/images/english_games/sentence/levelfieldbg.png" width="198" height="33" />
					</div>
					<div id="levelfieldchoice">
						<img src="front/images/english_games/sentence/levelfieldchoice.png" width="19" height="15" />
					</div>
					<div id="questioncountlabel">
						How many question?
					</div>
					<div id="questioncount">
						<img src="front/images/english_games/sentence/questioncount.png" width="32" height="14" />
					</div>
					<div id="questioncountbg">
						<img src="front/images/english_games/sentence/questioncountbg.png" width="89" height="33" />
					</div>
					<div id="questioncountchoice">
						<img src="front/images/english_games/sentence/questioncountchoice.png" width="19" height="15" />
					</div>
					<div id="startlabelbg">
						<img src="front/images/english_games/sentence/startlabelbg.png" width="349" height="70" />
					</div>
					<div id="startlabel">
						<a href="javascript:CreateTimer('timefield',80)">START</a>
					</div>
				</div>
				
				
				<div id="lmscopyright">
					Learning Management System &#169; | 2012
				</div>
			</div>
		</div>
		
		<!--/english game-->


	</body>
</html>




