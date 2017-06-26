<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends Model {
    protected $pk = 'id';
    
    function __construct() {
        parent::__construct();
    }
    
    public function fields(){
        return [
            'id' => ['type'=>'int'],
            'name' => ['type'=>'string'],
            'picture' => ['type'=>'image'],
            'address' => ['type'=>'string'],
            'active' => ['type'=>'boolean'],
            'created_at' => ['type'=>'datetime'],
            'updated_at' => ['type'=>'datetime'],
        ];
    }
}