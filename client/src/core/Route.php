<?php
class Route
{
    public function handleRoute($url = '')
    {
        global $routes;
        $url = trim($url, '/');

        $handleUrl = $url;
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match('~' . $key . '~is', $url)) {
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);
                }
            }
        }

        return $handleUrl;
    }
}
