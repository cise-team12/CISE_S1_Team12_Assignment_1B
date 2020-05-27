<?php

use PHPUnit\Framework\TestCase;
class tests extends TestCase
{
  public function testTrueAssetsToTrue()
  {
    $condition = true;
    $this->assertTrue($condition);
  }
}
?>
