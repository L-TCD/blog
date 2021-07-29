<?php
class CoreController
{
    protected function genererPage($data)
    {
        extract($data);
        extract($params);
        ob_start();
        require_once($view);
        $page_content = ob_get_clean();
        require_once($template);
    }

    public function pageErreur($msg)
    {
        $data_page = [
            "page_description" => "Page de gestion d'erreur",
            "page_title" => "Page d'erreur",
            "msg" => $msg,
            "view" => "views/erreur.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function page404($msg = "Cette page n'existe pas")
    {
        $data_page = [
            "page_description" => "Page de gestion d'erreur",
            "page_title" => "Page d'erreur",
            "msg" => $msg,
            "view" => "views/erreur.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
}
