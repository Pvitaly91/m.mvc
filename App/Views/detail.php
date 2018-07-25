
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <? if ($item): ?>    
                <? if (isset($item['name'])): ?>
                    <h5>User name: <?= $item['name'] ?></h5>
                <? endif; ?>  
                <? if (isset($item['email'])): ?>
                    <h5>User email: <?= $item['email'] ?></h5>
                <? endif; ?>  
                <? if (isset($item['image'])): ?>

                    <img src="<?= $item['image'] ?>" class="rounded" >
                <? endif; ?> 
                <? if (isset($item['task_text'])): ?>
                    <p><?= $item['task_text'] ?></p>
                <? endif; ?> 
                    
                <? if (isset($item['status']) && $item['status'] == 1): ?>  
                    <div class="alert alert-success">
                        <strong>Task</strong> is done
                    </div>
                <? elseif (!isset($item['status']) || $item['status'] == 0): ?>    
                    <div class="alert alert-info">
                        <strong>Task</strong> is not done
                    </div>
                <? endif; ?>     
                
                <hr class="d-sm-none">
            <? else: ?>
                <h6>Empty</h6>
            <? endif; ?>    
        </div>
    </div>
</div>

