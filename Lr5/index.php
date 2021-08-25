<?php
require ('connect.php');

?>
<form  action="input.php" method="post">
<div class="row mb-3">
    <label for="inputlogin" class="col-sm-2 col-form-label">Логин</label>
    <div class="col-sm-10">
      <input type="login" name ="login" class="form-control" id="inputLogin">
    </div>
</div>
<div class="row mb-3">
    <label for="inputPassword" class="col-sm-2 col-form-label">Пароль</label>
 <div class="col-sm-10">
  <input type="password" name ="password" class="form-control" id="inputPassword">
 </div>
</div>
<p><input name="submit" type="submit" value="Вход"></p>
</form>

