<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Ads;
use App\Libraries\Utils;


abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public $data = [];

    public function __construct()
    {

        $this->ads = Ads::get();
        \View::share('ads', $this->ads);

        $this->data['settings_custom_css'] = Utils::getSettings("custom_css");
        $this->data['settings_custom_js'] = Utils::getSettings("custom_js");
        $this->data['settings_social'] = Utils::getSettings("social");
        $this->data['settings_comments'] = Utils::getSettings("comments");
        $this->data['settings_seo'] = Utils::getSettings("seo");
        $this->data['settings_general'] = Utils::getSettings("general");
    }
}
