<?php

namespace daweb\crud;

/**
 * This is a facade whole scaffolding generator
 *
 * @author daweb
 */
class Scaffolding {

    public $helper;
    public $config;
    public $command;
    public $template;

    public function __construct() {

        $this->helper = new ScaffoldingHelper;
        $this->config = new ScaffoldingConfig;
        $this->command = new ScaffoldingCommand($this);
    }

    /**
     * check whether scaffolding template is changed - if so use him
     * @throws ScaffoldingException
     */
    public function prepareTemplate() {

        $templateClass = $this->config->get('template_class');

        if (class_exists($templateClass))
            $this->template = new $templateClass();
        else
            throw new \Exception('template class ' . $templateClass . ' not exists');

        if (!$this->template instanceof ScaffoldingTemplate)
            throw new \Exception('template class ' . $templateClass . ' must be instanceof ScaffoldingTemplate');

        return $this->template;
    }

    public function init() {

        DB::initConnection($this->config->get('db'));
    }

}
