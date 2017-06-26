<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Tic tac toe</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style type="text/css">
			.table-responsive{margin-top:10%;}
			.table-tic-tac{ width: 450px; height: 300px; margin: auto; padding: 0; }
			.table>tbody>tr>td{ text-align: center;font-size: 40px; margin: 20px; color: gray; vertical-align: middle; line-height: normal; width: 60px; height: 60px; border-bottom: 1px solid gray; border-right: 1px solid gray; border-top: none; }
			.table .row3 td{ border-bottom: none; }
			.table .row1 td:last-child , .row2 td:last-child,.row3 td:last-child { border-right: none; }
		</style>
	</head>
	<body>
		<div class="col-xs-12">
			<div class="table-responsive">
				<h3 class="" role="alert"></h3>
		  		<table class="table table-tic-tac">
		  			<tbody>
						<tr class="row1">
						  <td class="cell 0_0" data-x="0" data-y="0">&nbsp;</td>
						  <td class="cell 0_1" data-x="0" data-y="1">&nbsp;</td>
						  <td class="cell 0_2" data-x="0" data-y="2">&nbsp;</td>
						</tr>
						<tr class="row2">
						  <td class="cell 1_0" data-x="1" data-y="0">&nbsp;</td>
						  <td class="cell 1_1" data-x="1" data-y="1">&nbsp;</td>
						  <td class="cell 1_2" data-x="1" data-y="2">&nbsp;</td>
						</tr>
						<tr class="row3">
						  <td class="cell 2_0" data-x="2" data-y="0">&nbsp;</td>
						  <td class="cell 2_1" data-x="2" data-y="1">&nbsp;</td>
						  <td class="cell 2_2" data-x="2" data-y="2">&nbsp;</td>
						</tr>
					</tbody>
		  		</table>
			</div>
			<div class="col-xs-8 col-xs-offset-2" >
				<a class="btn btn-success btn-block start-btn">Start</a>
			</div>
		</div>


		<script src ="js/jquery-min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>
