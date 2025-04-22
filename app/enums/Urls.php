<?php
namespace App\Enums;

enum Urls:string {
    case HOST = "";
    case ASSETS = "/assets/";

    public function resolve() {
        return "http://". $_SERVER['HTTP_HOST']. $this->value;
    }
}