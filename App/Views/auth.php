<? if(Classes\User::getInstance()->getid()):?>
<div class="alert alert-success">
  <strong>Success!</strong> you already authorized
</div>
<? else:?>
    <? include __DIR__ . "/includes/success.php" ?>
    <? include __DIR__ . "/includes/errors.php" ?>
    <form action="/login" method="post">
        <div class="form-group">
            <label for="login">Email address:</label>
            <input type="text" name="login" class="form-control" id="login">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" name="password" class="form-control" id="pwd">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<? endif;?>