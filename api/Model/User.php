<?php
    /**
     * User
     * @author Moses Ngone <moses@epiclabs.com>
     * @version 0.1
     */
    class User
    {
        /**
         * Create
         *
         * HTTP GET
         * imagine retrieving data from a data source
         */
        public function read($request)
        {

            $users = array(
                    array(
                            'name' => 'Harry Potter',
                            'age' => 14,
                            'house' => 'Gryffindor'
                    ),
                    array(
                            'name' => 'Hermione Granger',
                            'age' => 14,
                            'house' => 'Gryffindor'
                    ),
                    array(
                            'name' => 'Ron Weasley',
                            'age' => 14,
                            'house' => 'Gryffindor'
                    ),
                    array(
                            'name' => 'Ginny Weasley',
                            'age' => 13,
                            'house' => 'Gryffindor'
                    ),
                    array(
                            'name' => 'Cho Chang',
                            'age' => 15,
                            'house' => 'Ravenclaw'
                    )
            );

            if (!empty($request -> resource['id']))
            {
                $user_id = $request -> resource['id'] - 1;
                if (array_key_exists($user_id, $users))
                {
                    $users = $users[$user_id];
                }
                else
                {
                    return array(
                            'status' => 404,
                            'body' => 'Sorry Not Found'
                    );
                }

            }

            return array(
                    'status' => 200,
                    'body' => $users
            );

        }

        /**
         * Create
         *
         * HTTP POST
         * imagine adding data in a data source
         */

        public function create($request)
        {
            return array(
                    'status' => 201,
                    'body' => $request -> resource['id']
            );
        }

        /**
         * Update
         *
         * HTTP PUT Method
         * imagine updating data in data source
         *
         * Note: is interchangable with post, whatever makes most sense to you.
         */
        public function update($request)
        {
            if (empty($request -> resource['id']))
            {
                return array(
                        'status' => 404,
                        'body' => 'Sorry Not Found'
                );
            }

            return array(
                    'status' => 200,
                    'body' => "{$request -> resource['id']}:Updated"
            );
        }

        /**
         * Delete
         *
         * HTTP DELETE
         *
         * imagine deleting data from a data source
         * in our minimal api here we do not allow this
         * so we just deny your request
         */
        public function delete($request)
        {
            return $this -> deny($request);
        }

        public function deny($request)
        {
            return array(
                    'status' => 405,
                    'body' => "Sorry Can't Do that"
            );
        }

    }
