<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    function get_method () {
        return $_SERVER['REQUEST_METHOD'];
    }

    function get_request_data () {
        return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
    }

    function send_response ($response, $code = 200) {
        http_response_code($code);
        die(json_encode($response));
    }

    function is_not_ajax () {
		return empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest';
	}

    
    function CreateApiFunction() {

        if (is_not_ajax()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }
    
       
        $method = get_method();
    
        $data = get_request_data();
    
    
        // GET request
       
        if ($method === 'GET') {

             // respond 
            send_response([
                'status' => 'success',
                'message' => 'You did it, dude!',
            ]);
    
        }

        if ($method === 'POST') {

          
            if (empty($data['favorite'])) {
                send_response([
                    'status' => 'failed',
                    'message' => 'Please provide a favorite movie.',
                ], 400);
            }
    
            
            // respond with a success
            send_response([
                'status' => 'success',
                'message' => 'This movie was saved to your favorites!',
            ]);
    
        }

        send_response(array(
            'code' => 405,
            'status' => 'failed',
            'message' => 'Method not allowed'
        ), 405);

        
    }
}
