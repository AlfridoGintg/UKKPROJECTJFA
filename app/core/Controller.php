<?php

class Controller {

    protected function view($path, $data = [])
    {
        extract($data);
        require "../views/$path.php";
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
