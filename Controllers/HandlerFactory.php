<?php
namespace Aivec\Welcart\Generic\Controllers;

/**
 * Request handler factory
 */
class HandlerFactory extends Controller {

    /**
     * AJAX request POST key that acts as a namespace for request handling
     *
     * @var string
     */
    private $ajax_namespace;

    /**
     * POST request POST key that acts as a namespace for request handling
     *
     * @var string
     */
    private $post_namespace;

    /**
     * WordPress nonce key for POST/AJAX requests
     *
     * @var string
     */
    private $nonce_key;

    /**
     * WordPress nonce name for POST/AJAX requests
     *
     * @var string
     */
    private $nonce_name;

    /**
     * Defines namespaces for requests. Defines nonce data
     *
     * @param string $ajax_namespace
     * @param string $post_namespace
     * @param string $nonce_key
     * @param string $nonce_name
     */
    public function __construct(
        $ajax_namespace,
        $post_namespace,
        $nonce_key,
        $nonce_name
    ) {
        $this->ajax_namespace = $ajax_namespace;
        $this->post_namespace = $post_namespace;
        $this->nonce_key = $nonce_key;
        $this->nonce_name = $nonce_name;
    }

    /**
     * Delegates requests to the appropriate class handler method
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param string $route
     * @param mixed  $model
     * @param string $method
     * @param array $middlewares array of middleware functions
     */
    public function add($route, $model, $method, $middlewares) {
        if (isset($_POST[$this->ajax_namespace]) && !empty($_POST[$this->ajax_namespace])) {
            if (isset($_POST['route'])) {
                if ($_POST['route'] === $route) {
                    check_ajax_referer($this->nonce_name, $this->nonce_key);
                    $middlewares($this->processRequest($model, $method, 'ajax'));
                }
            }
        }

        if (isset($_POST[$this->post_namespace]) && !empty($_POST[$this->post_namespace])) {
            if (isset($_POST['route'])) {
                if ($_POST['route'] === $route) {
                    $nonce = '';
                    if (isset($_REQUEST[$this->nonce_key])) {
                        $nonce = sanitize_text_field(wp_unslash($_REQUEST[$this->nonce_key]));
                    }
                    if (!wp_verify_nonce($nonce, $this->nonce_name)) {
                        die('Security check');
                    }
                    $this->processRequest($model, $method, 'post');
                }
            }
        }
    }

    /**
     * Unused abstract method
     *
     * @inheritDoc
     * @return void
     */
    public function controller() {
    }
}
