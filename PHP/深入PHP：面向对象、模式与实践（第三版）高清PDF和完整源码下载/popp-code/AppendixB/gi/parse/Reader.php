<?php
namespace gi\parse;

abstract class Reader {

    abstract function getChar();
    abstract function getPos();
    abstract function pushBackChar();
}
?>
