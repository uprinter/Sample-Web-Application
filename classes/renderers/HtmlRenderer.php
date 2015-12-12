<?php
namespace renderers;

/**
 * Class HtmlRenderer
 *
 * Implements HTML template renderer
 *
 * @package renderers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class HtmlRenderer
{
    /**
     * Renders template
     *
     * @param string $template Template name
     * @param array $params Parameters
     */
    public function render($template, $params = []) {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require __DIR__ .'/../../templates/' . $template . '.php';
        echo ob_get_clean();
    }
}