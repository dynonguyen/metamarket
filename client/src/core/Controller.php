<?php
class Controller
{
    protected $data = [];

    function __construct()
    {
        $this->data['cssLinks'] = [];
        $this->data['jsLinks'] = [];
        $this->data['pageTitle'] = 'MetaMarket';
        $this->data['passedVariables'] = [];
        $this->data['viewPath'] = '';
        $this->data['viewContent'] = [];
    }

    public function render(string $view = '', array $data = [])
    {
        // Transform array keys to variables
        if (empty($data) || sizeof($data) === 0) {
            $data = $this->data;
        }
        extract($data);

        $viewFilePath = _DIR_ROOT . '/app/views/' . $view . '.php';
        if (file_exists($viewFilePath)) {
            require_once $viewFilePath;
        }
    }

    public function appendCssLink(string | array $cssFileName)
    {
        if (is_array($cssFileName)) {
            $this->data['cssLinks'] = array_merge($this->data['cssLinks'], $cssFileName);
        } else {
            array_push($this->data['cssLinks'], $cssFileName);
        }
    }

    public function appendJSLink(string | array $jsFileName)
    {
        if (is_array($jsFileName)) {
            $this->data['jsLinks'] = array_merge($this->data['jsLinks'], $jsFileName);
        } else {
            array_push($this->data['jsLinks'], $jsFileName);
        }
    }

    public function setPassedVariables(array $variables)
    {
        $this->data['passedVariables'] = array_merge($this->data['passedVariables'], $variables);
    }

    public function setPageTitle(string $pageTitle = '')
    {
        if (!empty($pageTitle)) {
            $this->data['pageTitle'] = $pageTitle . ' | MetaMarket';
        }
    }

    public function setContentViewPath(string $viewPath)
    {
        $this->data['viewPath'] = $viewPath;
    }

    public function setViewContent(string $key, $value)
    {
        $this->data['viewContent'][$key] = $value;
    }

    public static function redirect(string $url = '', int $statusCode = 301)
    {
        header('Location:' . $url, true, $statusCode);
        exit(0);
    }

    public static function renderErrorPage(string $errorCode = '404')
    {
        require_once _DIR_ROOT . '/app/errors/' . $errorCode . '.php';
        exit(0);
    }
}
