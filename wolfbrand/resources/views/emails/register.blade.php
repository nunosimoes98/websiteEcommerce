<!DOCTYPE html>
<html>
<head>
	<title>Novo Registo!</title>
</head>
<body>
	<table>
		<tr>
			<td>Dear {{ $name }}!</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Your account has been successfully created.<br>
			Your account information is below:</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Email: {{ $email }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Password: ******** (as chosen by you)</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Thanks & Regards,</td>
		</tr>
		<tr>
			<td>WolfWork Brand.</td>
		</tr>
	</table>
</body>
</html>