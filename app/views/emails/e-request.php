<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head lang="sv">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Single-Column Responsive Email Template</title>
 
	<style type="text/css">
		@media only screen and (min-device-width: 541px) {
			.content {
				width: 540px !important;
			}
		}
		.header {
			padding: 40px 30px 20px;
			font-family: sans-serif;
			font-size: 33px; line-height: 38px; font-weight: bold;
			color: #B3DBFF;
		}
		.body {
			padding: 20px 10px;
			font-family: sans-serif;
		}
		.button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
	.button a {color: #ffffff; text-decoration: none;}
	</style>
</head>
<body>
<!--[if (gte mso 9)|(IE)]>
	<table width="540" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
<![endif]-->
	<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px;">
		<tr>
			<td class="header" bgcolor="#0074D9" style="padding: 40px 30px 20px;font-family: sans-serif;font-size: 33px;line-height: 38px;font-weight: bold;color: #B3DBFF;">Bokningsförfrågan</td>
		</tr>
		<tr>
			<td class="body" bgcolor="#f8f8f8" style="padding: 20px 10px;font-family: sans-serif;">
				<table align="left">
					<tr align="left">
						<td colspan="2">
							<h3 style="margin:10px 0 5px">Kontaktuppgifter</h3>
						</td>
					</tr>
					<tr align="left">
						<th>Namn</th>
						<td><?php echo $name?></td>
					</tr>
					<tr align="left">
						<th>E-post</th>
						<td><?php echo $email?></td>
					</tr>
					<tr align="left">
						<th>Telefonnummer</th>
						<td><?php echo $phone?></td>
					</tr>
					<tr align="left">
						<td colspan="2">
							<h3 style="margin:10px 0 5px">Eventinformation</h3>
						</td>
					</tr>
					<tr align="left">
						<th>Event</th>
						<td><?php echo $event?></td>
					</tr>
					<tr align="left">
						<th>Datum</th>
						<td><?php echo $date?></td>
					</tr>
					<tr align="left">
						<th>Tid</th>
						<td><?php echo $timeFrom . '-' . $timeTo?></td>
					</tr>
					<tr align="left">
						<th>Plats</th>
						<td><?php echo $place?></td>
					</tr>
					<tr align="left">
						<th>Ljud</th>
						<td><?php echo $sound?></td>
					</tr>
					<tr align="left">
						<th>Ljus</th>
						<td><?php echo $light?></td>
					</tr>
					<tr align="left">
						<th>Tidig rodd</th>
						<td><?php echo $setup?></td>
					</tr>
					<tr align="left">
						<td colspan="2">
							<h3 style="margin:10px 0 5px">Övrig information</h3>
						</td>
					</tr>
					<tr align="left">
						<th>Referens</th>
						<td><?php echo $renown?></td>
					</tr>
					<tr align="left">
						<th colspan="2">Meddelande</th>
					</tr>
					<tr>
						<td colspan="2"><?php echo nl2br($description)?></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
<!--[if (gte mso 9)|(IE)]>
			</td>
		</tr>
</table>
<![endif]-->
</body>
</html>
