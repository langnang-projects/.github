<?php

namespace App\Traits\Controller;

trait HasModule
{
    /**
     * @var string $module
     */
    protected $module;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'CheatSheet';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'cheatsheet';


    public function set_module($module)
    {
        $this->module = $module;
    }

    public function get_module()
    {
        return $this->module;
    }

    public function get_module_config()
    {
        return \Module::getCurrentConfig();
    }
}
