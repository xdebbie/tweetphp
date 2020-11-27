<?php

use Twitter\Controller\HelloController;
use Twitter\Http\Request;
use PHPUnit\Framework\TestCase;

class HelloControllerTest extends TestCase {
  /**
   * @test
   */
  public function sayHello_works_well_without_a_name_param() {
    // Given a request with no param
    $request = new Request();

    // When we call sayHello
    $controller = new HelloController;
    $response = $controller->sayHello($request);

    // Then the response's content should be "Hello World"
    $this->assertEquals("Hello World", $response->getContent());
  }

  /**
   * @test
   */
  public function sayHello_works_well() {
    // Given we send name=Deborah in the URL
    // $_REQUEST['name'] = 'Deborah';
    $request = new Request([
      'name' => 'Deborah'
    ]);

    // When we run index.php
    // ob_start();
    // include __DIR__ . '/../index.php';
    // ob_end_clean();
    $controller = new HelloController;
    $response = $controller->sayHello($request);

    // Then we must have "Hello Deborah" in the content
    $this->assertEquals("Hello Deborah", $response->getContent());

    // And we must have status code 200
    // $code = http_response_code();
    $this->assertEquals(200, $response->getStatusCode());

    // And we must test headers
    $headers = $response->getHeaders();
    $this->assertArrayHasKey('Content-Type', $headers);
    $this->assertArrayHasKey('Lang', $headers);
  }
}