<?php
    /**
     * Request
     * @author Moses Ngone <moses@epiclabs.com>
     * @version 0.1
     */

    class Request
    {
        protected $_properties = array(
                'path' => null,
                'action' => null,
                'params' => array(),
                'resource' => array()
        );

        public function __construct()
        {
            $reflection = new ReflectionClass('Request');
            $methods = $reflection -> getMethods();
            foreach ($methods as $method)
            {
                if (strpos($method -> name, '_init') !== false)
                {
                    $method_name = $method -> name;
                    $this -> $method_name();
                }
            }

        }

        protected function _initPaths()
        {
            $pattern = '/(.*)\/(\d+)\/?$/i';
            $replacement = '${1}/${2}';
            $request_url = preg_replace($pattern, $replacement, $_SERVER['REQUEST_URI']);
            $request = parse_url($request_url);
            $request['resource'] = $this -> getRequestedResource($request['path']);
            $request['action'] = $this -> getAction();

            if (!empty($request['query']))
            {
                $query_params = explode('&', $request['query']);
                $params = array();
                foreach ($query_params as $param)
                {

                    list($key, $value) = explode('=', $param);
                    $params[$key] = $value;
                }
                $request['params'] = $params;
            }
            $this -> setOptions($request);

        }

        protected function getRequestedResource($path)
        {
            list($separator, $base, $id) = explode('/', $path) + array(
                    null,
                    null,
                    null
            );

            $class = substr($base, 0, -1);
            $class = ucfirst($class);
            return array(
                    'class' => $class,
                    'id' => $id
            );
        }

        protected function getAction()
        {

            switch($_SERVER['REQUEST_METHOD'])
            {
                case 'GET' :
                    $action = 'read';
                    break;
                case 'POST' :
                    $action = 'create';
                    break;
                case 'PUT' :
                    $action = 'update';
                    break;
                case 'DELETE' :
                default :
                    $action = 'deny';
                    break;
            }

            return $action;
        }

        protected function setOptions($data)
        {
            foreach ($data as $key => $val)
            {
                if (array_key_exists($key, $this -> _properties))
                {
                    if (!empty($val))
                    {
                        $this -> $key = $val;
                    }
                }

            }
        }

        public function __get($key)
        {
            if (array_key_exists($key, $this -> _properties))
            {
                return $this -> _properties[$key];
            }
        }

        public function __set($key, $val)
        {
            if (array_key_exists($key, $this -> _properties))
            {
                $this -> _properties[$key] = $val;
            }
        }

    }
