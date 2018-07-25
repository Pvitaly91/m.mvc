 
<div class="container">
    <? include __DIR__ . "/includes/success.php" ?>
    <? include __DIR__ . "/includes/errors.php" ?>

    <h2>Tasks</h2>
    <div class="row">
        <div class="col-sm-2"> <a href="/task/add" class="btn btn-primary" >Add new task</a></div>
        <div class="col-sm-14"><strong>Sort by:</strong> <?= $sort ?></div>
    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>User name</th>
                <th>Email</th>
                <th>Text</th>
                <th>Image</th>
                <th>Status</th>
            </tr>
        </thead>
        <? if (is_array($items)): ?>
            <tbody>
                <? foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item["id"] ?> <?if(Classes\User::getInstance()->getid()):?> <a href="/task/edit/<?= $item["id"] ?>">Edit</a><? endif;?></td>
                        <td><?= $item["name"] ?></td>
                        <td><?= $item["email"] ?></td>
                        <td><?= $item["task_text"] ?> <a href="/task/detail/<?= $item["id"] ?>">Read more</a></td>
                        <td><img  src="<?= $item["image"] ?>" class="rounded" alt="Cinque Terre"></td>
                        <td><?=$item["status"]?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        <? endif; ?>
    </table>
    <? if (!$items): ?>
        <div class="alert alert-secondary">
            <strong>Empty!</strong> no available tasks
        </div>
    <? endif; ?>

</div>