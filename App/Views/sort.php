<? if(isset($sort) && is_array($sort)):?>
    <? foreach($sort as $item):?>
        <a href="<?=$item["link"]?>" class="btn <?if($item["active"]): echo "btn-success"; endif;?>" ><?=$item["label"]?></a>
    <? endforeach;?>
<? endif;?>