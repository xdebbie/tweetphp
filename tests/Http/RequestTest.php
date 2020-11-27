<?php

require __DIR__ . '/../../src/Http/Request.php';

use Twitter\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
  /**
   * @test
   */
  public function Param_test() {
    // Given
    $data = ['name' => 'Deborah'];

    // When
    // always provide an array to a Request
    $request = new Request($data);
    $result = $request->getParam('name');

    // Then
    $this->assertEquals('Deborah', $result);
  }

  /**
   * @test
   */
  public function getParam_will_return_null_if_param_doesnt_exist() {
    // Given there is nothing in $_GET
    $data = [];

    // When I use Request::getParam
    $request = new Request($data);
    $result = $request->getParam('name');

    // Then it should return null
    $this->assertEquals(null, $result);
  }

  /**
   * @test
   */
  public function getParam_will_return_default_valuue_if_param_doesnt_exist() {
    // Given there is nothing in $_GET
    $data = [];

    // When I use Request::getParam
    $request = new Request($data);
    $result = $request->getParam('name');

    // Then it should return the default value
    $this->assertEquals(null, $result);
  }
}