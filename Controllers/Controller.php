<?php
namespace Aivec\Welcart\Generic\Controllers;

/**
 * This abstract class is a general request handler for POST and AJAX requests
 * and should be extended by any controller.
 */
abstract class Controller {
   
    /**
     * This method should call any of the methods listed below,
     * but it is free to be implemented as desired.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @abstract
     * @return void
     */
    abstract public function controller();
   
    /**
     * Delegates to appropriate handler method
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param mixed  $obj  the model object
     * @param string $request  the name of the model handler method
     * @param string $type  either 'post' or 'ajax'
     * @return void
     */
    public function processRequest($obj, $request, $type) {
        if (method_exists($obj, $request)) {
            if (strtolower($type) === 'post') {
                $this->processPOST($obj, $request);
            } elseif (strtolower($type) === 'ajax') {
                $this->processAJAX($obj, $request);
            }
        }
    }
   
    /**
     * Calls model post request handler method.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param mixed  $obj  the model object
     * @param string $request  the name of the model handler method
     * @return void
     */
    protected function processPOST($obj, $request) {
        $obj->{$request}();
    }

    /**
     * Calls model ajax request handler method and then dies with the response.
     *
     * @author Evan D Shaw <evandanielshaw@gmail.com>
     * @param mixed  $obj  the model object
     * @param string $request  the name of the model handler method
     * @return void
     */
    protected function processAJAX($obj, $request) {
        $res = $obj->{$request}();
        if (empty($res)) {
            die(0);
        }
        die($res);
    }
}
