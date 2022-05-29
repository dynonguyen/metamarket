<?php
class Controller
{
    protected $data = [];

    function __construct()
    {
        $this->data['cssLinks'] = [];
        $this->data['jsLinks'] = [];
        $this->data['cssCDN'] = [];
        $this->data['jsCDN'] = [];
        $this->data['pageTitle'] = 'MetaMarket';
        $this->data['passedVariables'] = [];
        $this->data['viewPath'] = '';
        $this->data['viewContent'] = [];
    }

    protected function render(string $view = '', array $data = [])
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

    protected function appendCssLink(string | array $cssFileName)
    {
        if (is_array($cssFileName)) {
            $this->data['cssLinks'] = array_merge($this->data['cssLinks'], $cssFileName);
        } else {
            array_push($this->data['cssLinks'], $cssFileName);
        }
    }

    protected function appendJSLink(string | array $jsFileName)
    {
        if (is_array($jsFileName)) {
            $this->data['jsLinks'] = array_merge($this->data['jsLinks'], $jsFileName);
        } else {
            array_push($this->data['jsLinks'], $jsFileName);
        }
    }

    protected function appendJsCDN(string | array $cdn)
    {
        if (is_array($cdn)) {
            $this->data['jsCDN'] = array_merge($this->data['jsCDN'], $cdn);
        } else {
            array_push($this->data['jsCDN'], $cdn);
        }
    }

    protected function appendCssCDN(string | array $cdn)
    {
        if (is_array($cdn)) {
            $this->data['cssCDN'] = array_merge($this->data['cssCDN'], $cdn);
        } else {
            array_push($this->data['cssCDN'], $cdn);
        }
    }

    protected function setPassedVariables(array $variables)
    {
        $this->data['passedVariables'] = array_merge($this->data['passedVariables'], $variables);
    }

    protected function setPageTitle(string $pageTitle = '')
    {
        if (!empty($pageTitle)) {
            $this->data['pageTitle'] = $pageTitle . ' | MetaMarket';
        }
    }

    protected function setContentViewPath(string $viewPath)
    {
        $this->data['viewPath'] = $viewPath;
    }

    protected function setViewContent(string $key, $value)
    {
        $this->data['viewContent'][$key] = $value;
    }

    protected static function redirect(string $url = '', int $statusCode = 301)
    {
        header('Location:' . $url, true, $statusCode);
        exit(0);
    }

    protected static function renderErrorPage(string $errorCode = '404')
    {
        require_once _DIR_ROOT . '/app/errors/' . $errorCode . '.php';
        exit(0);
    }

    protected static function setSessionMessage($message = '', $isError = false)
    {
        $_SESSION['message'] = $message;
        $_SESSION['isError'] = $isError;
    }

    protected function showSessionMessage($autoDestroySession = true)
    {
        if (!empty($_SESSION['message'])) {
            require_once _DIR_ROOT . '/app/views/mixins/toast.php';
            $this->appendJSLink('utils/toast.js');
            renderToast($_SESSION['message'], true, true, isset($_SESSION['isError']) ? $_SESSION['isError'] : false);

            // Destroy it to prevent it from showing up again
            if ($autoDestroySession) {
                $_SESSION['message'] = null;
                $_SESSION['isError'] = null;
            }
        }
    }
}
