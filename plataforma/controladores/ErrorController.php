<?php

namespace correplayas\controladores;

use correplayas\excepciones\AppException;
use Smarty;

class ErrorController {
    public static function handleException (AppException $ae, Smarty $s)
    {
        $notificaciones=[$ae->getMessage()];
        $s->assign('notificaciones',$notificaciones);
        $s->display("error.tpl");
    }
}