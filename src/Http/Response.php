<?php

namespace Twitter\Http;

class Response
{
  protected int $statusCode;
  protected array $headers;
  protected string $content;

  public function send()
  {
    // 1. Send the code
    http_response_code($this->statusCode);

    // 2. Send the headers
    // header("Content-Type: text/html");
    /** 
     * [
     *  'Content-Type' => 'text/html',
     *  'Lang' => 'en-EN'
     * ]
     */
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }

    // 3. Send the content
    echo $this->content;
  }

  public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
  {
    $this->content = $content;
    $this->statusCode = $statusCode;
    $this->headers = $headers;
  }

  public function getStatusCode(): int
  {
    return $this->statusCode;
  }

  public function setStatusCode(int $statusCode)
  {
    $this->statusCode = $statusCode;
    return $this;
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function setHeaders(array $headers)
  {
    $this->headers = $headers;
    return $this;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function setContent(string $content)
  {
    $this->content =  $content;
    return $this;
  }

  public function getHeader(string $name)
  {
    return $this->headers[$name] ?? null;
  }
}
