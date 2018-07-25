<? if(isset($pager) && $pager->elements > $pager->elements_on_page): ?>
<ul class="pagination">
    <? if ($pager->prev_url): ?>
        <li class="page-item"><a class="page-link" href="<?= $pager->first_url ?>">First</a></li>
        <li class="page-item"><a class="page-link" href="<?= $pager->prev_url ?>"><?= $pager->prev_page ?></a></li>
    <? endif; ?>    
    <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?= $pager->cur_page ?></a></li>
    <? if ($pager->next_url): ?>  
        <li class="page-item"><a class="page-link" href="<?= $pager->next_url ?>"><?= $pager->next_page ?></a></li>
        <li class="page-item"><a class="page-link" href="<?= $pager->last_url ?>">Last</a></li>
    <? endif; ?>      
</ul>
<? endif; ?> 
