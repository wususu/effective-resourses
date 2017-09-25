<?php
require_once "fullshop.php";
class ReflectionUtil {
  static function getMethodSource( ReflectionMethod $method ) {
    $path = $method->getFileName();
    $lines = @file( $path );
    $from = $method->getStartLine();
    $to   = $method->getEndLine();
    $len  = $to-$from+1;
    return implode( array_slice( $lines, $from-1, $len ));
  }
}

$class = new ReflectionClass( 'CdProduct' );
$method = $class->getMethod( 'getSummaryLine' );
print ReflectionUtil::getMethodSource( $method );
?>
