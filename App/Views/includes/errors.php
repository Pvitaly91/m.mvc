<? if(is_array($msg_errors)):?>
    <? foreach($msg_errors as $msg):?>   
        <div class="alert alert-danger" >
            <?=$msg;?>
        </div>
    <? endforeach;?>
<? endif;?>