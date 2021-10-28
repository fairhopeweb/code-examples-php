<?php

/**
 * Created by PhpStorm.
 * User: larry.kluger
 * Date: 11/22/18
 * Time: 9:32 AM
 */

namespace Example\Controllers\Examples;

use Example\Controllers\eSignBaseController;
use Example\Services\RouterService;

class Home extends eSignBaseController
{
    /** RouterService */
    protected RouterService $routerService;
    const FILE = __FILE__;
    private string $eg;  # Reference (and URL) for this example

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if ($GLOBALS['EXAMPLES_API_TYPE']['Rooms'] == true) {
            $this->eg = 'home_rooms';
        } elseif ($GLOBALS['EXAMPLES_API_TYPE']['Click'] == true) {
            $this->eg = 'home_click';
        } elseif ($GLOBALS['EXAMPLES_API_TYPE']['Monitor'] == true) {
            $this->eg = 'home_monitor';
        } elseif($GLOBALS['EXAMPLES_API_TYPE']['Admin'] == true) {
            $this->eg = 'home_admin';
        } else {
            $this->eg = 'home';
        }
        if (empty($this->routerService)) {
            $this->routerService = new RouterService();
        }
        parent::controller($this->eg);
    }

    public function createController()
    {
    }

    public function getTemplateArgs(): array
    {
        return [];
    }
}
