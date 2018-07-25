<? include __DIR__ . "/includes/success.php" ?>
<? include __DIR__ . "/includes/errors.php" ?>
<form enctype="multipart/form-data" action="/task/insert" method="post" id="form_add">
    <div class="form-group">
        <label for="user_name">User name *:</label>
        <input name="name" type="text" value="<? isset($name) ? print($name) : false; ?>" class="form-control" id="user_name">
    </div>

    <div class="form-group">
        <label for="email">Email address *:</label>
        <input name="email" type="email" value="<? isset($email) ? print($email) : false; ?>" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="image">Image *:</label>
        <input name="image" type="file" class="form-control" id="image">
    </div>
    <div class="form-group">
        <label for="task_text">Text *:</label>
        <textarea name="task_text" class="form-control" rows="5" id="task_text"><? isset($task_text) ? print($task_text) : false; ?></textarea>
    </div>
    <div class="form-group">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" value="1" <? isset($status) && $status == 1 ? print("checked") : false; ?> name="status">Status
        </label>
    </div>
    <input type="submit" class="btn btn-success" value="add"> 
    <button type="button" onclick="preview()" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Preview
    </button>
</form>  

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Task Preview</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="ajax_result">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
