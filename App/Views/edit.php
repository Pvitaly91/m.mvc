<form enctype="multipart/form-data" action="/task/update/<?=$item["id"]?>" method="post">
  
    <div class="form-group">
        <label for="task_text">Text:</label>
        <textarea name="task_text" class="form-control" rows="5" id="task_text"><?=$item["task_text"]?></textarea>
    </div>
    <div class="form-group">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" value="1" <?if($item["status"]):?>checked<? endif?> name="status">Status
        </label>
    </div>
    <input type="submit" class="btn btn-primary" value="Save">
</form> 