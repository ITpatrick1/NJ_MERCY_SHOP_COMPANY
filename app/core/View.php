<?php
class View {
    public static function render($file, $data=[]){
        extract($data);
        include $file;
    }
}
