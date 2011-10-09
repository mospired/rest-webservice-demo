<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Add User</title>
<style>
input { display:block; }
</style>
</head>

<body>
<h1>Add User</h1>
<form name="users" method="post" action="/users/">
  <label for="name">Name: </label>
  <input type="text" name="name" id="name">
  <label for="age">Age: </label>
  <input type="text" name="age" id="age">
  <label for="house"> House: </label>
  <input type="text" name="house" id="house">
  <button type="submit"> Submit</button>
</form>
</body>
</html>
