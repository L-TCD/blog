<?php
class PostController extends CoreController
{
    public function show($params = [])
    {
        $data_page = [
            "page_description" => "Description de la page " . $params['postId'],
            "page_title" => "Titre de la page " . $params['postId'],
            "view" => "views/post.view.php",
            "template" => "views/common/template.php",
            "params" => $params
        ];
        $this->genererPage($data_page);
    }
}
