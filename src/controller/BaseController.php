<?php
class BaseController
{
  protected function redirect(string $action): void
  {
    header("Location: index.php?action=$action");
    exit;
  }
}