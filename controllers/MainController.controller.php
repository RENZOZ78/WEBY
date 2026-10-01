<?php

require_once("controllers/Toolbox.class.php");

  Abstract class MainController{

    protected function genererPage($data){
      extract($data);//creer la variable directement
      ob_start();
      require_once($view);
      $page_content = ob_get_clean();
      require_once($template);
    }

    protected function pageErreur($msg, $code = 404){
      http_response_code($code);
      $data_page = [
        "view" => "./views/error.view.php",
        "custom_css" => [],
        "H1" => "Oups !",
        "uvp"=> "Erreur",
        "hero_compact" => true,
        "msg" => $msg,
        "page_description" => "Page d'erreur",
        "page_title"=> "WebyCloudy | Page erreur ",
        "template" => "views/common/template.php"
      ];
      $this->genererPage($data_page);
    }
  }
 ?>
