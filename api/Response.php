<?php
    /**
     * Response
     * @author Moses Ngone <moses@epiclabs.com>
     * @version 0.1
     */
    class Response
    {
        public function dispatch($payload, $request)
        {
            $header = (!empty($_SERVER['HTTP_ACCEPT'])) ? $_SERVER['HTTP_ACCEPT'] : 'text/html';

            $accept = $this -> parseAccept($header);
            header("HTTP/1.1 {$payload['status']}");

            if (in_array('text/xml', $accept))
            {
                // return xml
                $simplexml = simplexml_load_string("<?xml version=\"1.0\" ?><user />");
                if (!empty($request -> resource['id']))
                {
                    foreach ($payload['body'] as $key => $value)
                    {
                        $simplexml -> addChild($key, $value);
                    }
                }
                else
                {
                    foreach ($payload['body'] as $key => $users)
                    {
                        foreach ($users as $user => $value)
                        {
                            $simplexml -> addChild($user, $value);
                        }
                    }
                }

                header('Content-Type: text/xml');
                echo $simplexml -> asXML();
                return;
            }

            else
            {
                // return json
                header('content-type: application/json; charset=utf-8');
                $body = json_encode($payload['body']);
                if (isset($_GET['callback']))
                {
                    echo $_GET['callback'] . "({$body})";
                    return;
                }

                echo $body;
                return;

            }
        }

        /**
         * parse Accept
         *
         * use the accept headers to determine data format
         * thanks to Lorna Jane <lornajane.net>
         */
        protected function parseAccept($header)
        {

            if (!preg_match_all('(
                (?P<value>[a-z*][a-z0-9_/*+.-]*)
                    (?:;q=(?P<priority>[0-9.]+))?
             \\s*(?:,|$))ix', $header, $matches, PREG_SET_ORDER))
            {
                return false;
            }

            $accept = array();
            foreach ($matches as $values)
            {
                if (!isset($values['priority']) || (isset($values['priority']) && $values['priority'] == 1))
                {
                    $accept[] = isset($values['value']) ? strtolower($values['value']) : null;
                }
            }

            return $accept;
        }

    }
