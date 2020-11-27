<?php

namespace Twitter\Http;

class Request {
  protected array $data = [];

  public function __construct(array $data = []){
    $this->data = $data;
  }

  public function getParam(string $name, $default = null) {
      return $this->data[$name] ?? $default;
  }
}