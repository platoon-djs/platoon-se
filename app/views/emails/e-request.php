<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
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
			<td class="header" bgcolor="#0074D9" style="padding: 40px 30px 20px;font-family: sans-serif;font-size: 33px;line-height: 38px;font-weight: bold;color: #B3DBFF;">Booking Request</td>
		</tr>
		<tr>
			<td class="body" bgcolor="#f8f8f8" style="padding: 20px 10px;font-family: sans-serif;">
				<table align="left">
					<tr align="left">
						<th>Event</th>
						<td><?php echo $event?></td>
					</tr>
					<tr align="left">
						<th>Name</th>
						<td><?php echo $name?></td>
					</tr>
					<tr align="left">
						<th>Email</th>
						<td><?php echo $email?></td>
					</tr>
					<tr align="left">
						<th>Date</th>
						<td><?php echo $date?></td>
					</tr>
					<tr align="left">
						<th>Place</th>
						<td><?php echo $place?></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr align="left">
						<th colspan="2">Message</th>
					</tr>
					<tr>
						<td colspan="2"><?php echo nl2br($description)?></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td>
							<table class="buttonwrapper" bgcolor="#2ECC40" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="button" height="45" style="text-align: center;font-size: 18px;font-family: sans-serif;font-weight: bold;padding: 0 30px 0 30px;">
										<a href="mailto:<?php echo $email?>" style="color: #ffffff;text-decoration: none;">Answer Customer</a>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table class="buttonwrapper" bgcolor="#FF851B" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="button" height="45" style="text-align: center;font-size: 18px;font-family: sans-serif;font-weight: bold;padding: 0 30px 0 30px;">
										<a href="" title="WIP" style="color: #ffffff;text-decoration: none;">View in Admin</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
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