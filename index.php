<html>
<head>
	<title>.:Proton Engine:.</title>
	<script type="text/javascript">
		var t;
		var scores = new Array();

		function startTime(r, c)
		{
			if(t == null)
			{
				t = setInterval("changeClock()", 1000);
				for(var i = 0; i < r; ++i)
				{
					scores[i] = new Array();
					for(var j = 0; j < c; ++j)
						scores[i][j] = 0;
				}
			}
		}

		function changeClock()
		{
			var cur = document.getElementById("clock").innerHTML;
			var h = 0, m = 0;
			for(var i = 0; i < cur.length; ++i)
				if(cur[i] == ':')
				{
					for(var j = i - 1; j >= 0; --j)
						h += Math.pow(10, i - j - 1) * parseInt(cur[j]);
					for(var j = cur.length - 1; j > i; --j)
						m += Math.pow(10, cur.length - j - 1) * parseInt(cur[j]);
					break;
				}
			++m;
			if(m > 59)
			{
				++h;
				m = 0;
			}
			var ret = (h < 10 ? "0" : "") + h + ":" + (m < 10 ? "0" : "") + m;
			document.getElementById("clock").innerHTML = ret;
		}
		
		function pauseTime()
		{
			clearInterval(t);
			t = null;
		}
		
		function endTime()
		{
			clearInterval(t);
			t = null;
			document.getElementById("clock").innerHTML = "00:00";
		}
		
		function plus(r, c)
		{
			var sc = scores[r - 1][c - 1];
			var ret = "<span style='color : green; font-size : 20'>+";
			if(sc > 0)
				ret += sc;
			ret += "<br />" + document.getElementById("clock").innerHTML + "</span>";
			document.getElementById(r + "," + c).innerHTML = ret;
		}
		
		function minus(r, c)
		{
			var sc = ++scores[r - 1][c - 1];
			var ret = "<span style='color : red; font-size : 20'>-" + sc + "</span><br />";
			var but = "<input type='button' value='+' onclick='plus(" + r + ", " + c + ")' />";
			but += "<input type='button' value='-' onclick='minus(" + r + ", " + c + ")' />";
			document.getElementById(r + "," + c).innerHTML = ret + but;
		}
	</script>
	<style type="text/css">
		#main
		{
			margin-left : auto;
			margin-right : auto;
			width : 90%;
		}
		
		#data
		{
			margin-left : auto;
			margin-right : auto;
			border-color : gray;
			width : 30%;
		}
		
		#tblData
		{
			width : 100%;
		}
		
		#tblData td
		{
			padding : 5px 5px 5px 10px;
		}
		
		h2
		{
			text-align : center;
		}
		
		#ranking
		{
			border-color : gray;
		}
		
		#tblRankList
		{
			border-collapse : collapse;
			width : 100%;
		}
		
		#tblRankList td
		{
			padding : 15px 15px 15px 15px;
			border : 3px solid gray;
			text-align : center;
			width : 8%;
		}
		
		.special
		{
			width : 8%;
		}
	</style>
</head>
<body>
		<div id="main">
			<h2>.: Proton Engine :.</h2>
			<hr />
			<br />
			<?
				if(!isset($_GET['numRow']) || !isset($_GET['numCol']))
				{
			?>
					<form method="get" action="index.php">					
						<fieldset id="data">
							<legend>Contest Data</legend>
							<table id="tblData">
								<tr>
									<td>Number of Contestant(s)</td>
									<td><input type="text" name="numRow" /></td>
								</tr>
								<tr>
									<td>Number of Problem(s)</td>
									<td><input type="text" name="numCol" /></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><input type="submit" value="Submit Data" /></td>
								</tr>
							</table>
						</fieldset>
					</form>
			<?
				}
				else
				{
			?>
					<a href="index.php">Back</a> | <a href="#" onclick="location.reload()">Refresh</a>
					<br /><br />
					<fieldset id="ranking">
						<legend>Rank List</legend>
						<p>
							<input type="button" value="Start" onclick="startTime(<?= $_GET['numRow'] ?>, <?= $_GET['numCol'] ?>)" />
							<input type="button" value="Pause" onclick="pauseTime()" />
							<input type="button" value="End" onclick="endTime()" />
							<span id="clock">00:00</span>
						</p>
						<p>
							<table id="tblRankList">
								<caption><strong>Rank List Table</strong></caption>
							<?
								$r = $_GET['numRow'];
								$c = $_GET['numCol'];
								for($i = 0; $i <= $r; ++$i)
								{
							?>
									<tr>
							<?
									for($j = 0; $j <= $c; ++$j)
									{
										if($i == 0 && $j == 0)
										{
							?>
											<td>-\-</td>
							<?
										}
										else if($j == 0)
										{
							?>
											<td><?= $i ?></td>
							<?
										}
										else if($i == 0)
										{
							?>
											<td><?= $j ?></td>
							<?
										}
										else
										{
							?>
											<td class="special" id="<?= $i ?>,<?= $j ?>">
												<input type="button" value="+" onclick="plus(<?= $i ?>, <?= $j ?>)" />
												<input type="button" value="-" onclick="minus(<?= $i ?>, <?= $j ?>)" />
											</td>
							<?
										}
									}
							?>
									</tr>
							<?
								}
							?>
							</table>
						</p>
					</fieldset>
			<?
				}
			?>
		</div>
</body>
</html>
