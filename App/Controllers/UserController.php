<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserController {
    
    public function index($id) {
        $user = new User();
        $response = [];
        $result = $user->selectById($id)->getResult();
        if($result===false){
            $response['success'] = false;
            if(!$user->getErrors()){
                $response['errors'] = 'User not found.';
            }else{
                $response['errors'] = $user->getErrors();
            }
        }else{
            if($result['active']){
                $response['success'] = TRUE;
                $response['data'] = $result;
            }else{
                $response['success'] = FALSE;
                $response['errors'] = 'User not found.';
            }
        }
        $this->response($response);
    }
    
    public function update() {
        $response = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $params = [];
            if(isset($_POST['name']) && !empty($_POST['name'])){
                $params['name'] = (isset($_POST['name']) && !empty($_POST['name']))?$_POST['name']:null;
            }
            if(isset($_POST['address']) && !empty($_POST['address'])){
                $params['address'] = (isset($_POST['address']) && !empty($_POST['address']))?$_POST['address']:null;
            }
            if(isset($_POST['picture']) && !empty($_POST['picture'])){
                $params['picture'] = (isset($_POST['picture']) && !empty($_POST['picture']))?$_POST['picture']:null;
            }
            if(!empty($params)){
                $user = new User();
                if( $user->selectById($_POST['id'])->getResult() ) {
                    if($user->update($_POST['id'], $params)){
                        $response['success'] = true;
                    }else{
                        $response['success'] = false;
                        $response['errors'] = $user->getErrors();
                    }
                }else{
                    $response['success'] = false;
                    $response['errors'] = 'Unknow user';
                }
            }else{
                $response['success'] = false;
                $response['errors'] = 'Empty update data';
            }
        }else{
            $response['success'] = false;
            $response['errors'] = 'Incorrect parameters';
        }
        $this->response($response);
        
    }
    
    public function delete() {
        $response = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $params = [
                'active' => 0
            ];
            $user = new User();
            if( $user->selectById($_POST['id'])->getResult() ) {
                if($user->update($_POST['id'], $params)){
                    $response['success'] = true;
                }else{
                    $response['success'] = false;
                    $response['errors'] = $user->getErrors();
                }
            }else{
                $response['success'] = false;
                $response['errors'] = 'User not found.';
            }
        }else{
            $response['success'] = false;
            $response['errors'] = 'Incorrect parameters';
        }
        $this->response($response);
    }
    
    protected function response($data){
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}