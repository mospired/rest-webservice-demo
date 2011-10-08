<?php
    /**
     * Web service
     * @author Moses Ngone <moses@epiclabs.com>
     * @version 0.3
     */
    include ('../api/Request.php');
    include ('../api/Model/User.php');
    include ('../api/Response.php');

    /**
     * autoload Zend
     */

    function autoLoadExtLibs($class_name)
    {

        $zend_path = "/usr/local/zend/share/ZendFramework/library/";
        $class_file = $zend_path . str_replace('_', '/', $class_name) . '.php';
        if (file_exists($class_file))
        {
            require $class_file;
            return;
        }
        return;
    }

    spl_autoload_register('autoLoadExtLibs', true);

    /**
     * handle the request
     */
    $request = new Request();
    /**
     * define what we are looking for
     */
    $class_name = ($request -> resource['class']);
    if ($class_name)
    {
        $action = $request -> action;
        $resource = new $class_name();
        /**
         * get the resource from the model
         */
        $payload = $resource -> $action($request);
    }
    else
    {
        $payload = array(
                'status' => 404,
                'body' => 'Not found'
        );
    }

    /**
     * handle the response
     */
    $response = new Response();
    $response -> dispatch($payload, $request);
