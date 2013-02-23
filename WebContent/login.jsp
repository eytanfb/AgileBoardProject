<%@ page language="java" contentType="text/html; charset=US-ASCII"
    pageEncoding="US-ASCII"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
<title>Insert title here</title>
</head>
<body>
<form method="post" action="login">
<br>
<br>
	<table style="margin: auto;">
	<tr>
		<td colspan="2" style="text-align: center;">Agile Board</td>
	</tr>
	<tr>
		<td>username:</td>
		<td>
		<input type="text" name="txtusername" size="20" />
		</td>
	</tr>
	<tr>
		<td>password:</td>
		<td><input type="password" name="txtpassword" /></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><input type="submit" value="Login" name="btnSubmit" /></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
		<b><% if (request.getAttribute("message") != null )
		{
		 out.print( request.getAttribute("message") );
		}
		  %></b>
		</td>
	</tr>
	</table>
</form>
</body>
</html>