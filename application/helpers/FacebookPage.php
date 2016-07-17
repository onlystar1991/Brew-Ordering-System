<?php namespace application\helpers;

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/7/2016
 * Time: 12:38 PM
 */
class FacebookPage
{
    public $metaData;
    public $id;
    function __construct($id)
    {
        $this->id = $id;
    }

    public function setMetaData()
    {
        $configs = include('application\config\facebook_api.php');
        $url = $configs['facebook_graph_url'];
        $url = $url . $this->id . "";
        $nextPage = "";
        $filter = array('fields' => "hours,location,picture,cover,description,category_list,global_brand_page_name");
        $facebookResponse = FacebookGraphHelper::getResponse($url, $filter, false, $nextPage);
        $this->metaData = $facebookResponse;
        var_dump($facebookResponse);

    }
}