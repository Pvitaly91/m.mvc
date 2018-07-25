<?
if(is_array($msg_success)):?>
    <? foreach($msg_success as $msg):?>   
        <div class="alert alert-success" >
            <?=$msg;?>
        </div>
    <? endforeach;?>
<? endif;?>