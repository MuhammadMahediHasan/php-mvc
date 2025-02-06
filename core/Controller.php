<?php

namespace Core;

class Controller
{
    public function loadView($name = '', $arg = array()): void
    {
        $path = view($name);

        //        $data = array_map(function ($value) {
        //            return $value;
        //        }, $arg);

        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }
}
