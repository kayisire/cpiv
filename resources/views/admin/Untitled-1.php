<div class="wrapper create-pizza">
<h1>create a new type of User</h1>
<form action="{{ name('createTypes) }}" method="POST">
@csrf
<label for="name">Type of User:</label>
<input type="text" id="name" name="name">

<label for="desc">Description:</label>
<input type="text" id="desc" name="desc">


<input type="submit" value="Register type">
</form>
</div>