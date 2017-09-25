<?php
require_once "fullshop.php";
require_once "business/ShopProduct3.php";

class ReflectionUtil {
  static function getClassSource( ReflectionClass $class ) {
    $path = $class->getFileName();
    $lines = @file( $path );
    $from = $class->getStartLine();
    $to   = $class->getEndLine();
    $len  = $to-$from+1;
    return implode( array_slice( $lines, $from-1, $len ));
  }
}

print ReflectionUtil::getClassSource(
  new ReflectionClass( 'CdProduct' ) );
print ReflectionUtil::getClassSource(
  new ReflectionClass( 'business\ShopProduct3' ) );
?>
