<?php
namespace woo\base;

require_once( "woo/controller/AppController.php");

abstract class Registry {
    protected function __construct() {}
    abstract protected function get( $key );
    abstract protected function set( $key, $val );
}

class RequestRegistry extends Registry {
    private $values = array();
    private static $instance;

    static function instance() {
        if ( ! isset(self::$instance) ) { self::$instance = new self(); }
        return self::$instance;
    }

    protected function get( $key ) {
        if ( isset( $this->values[$key] ) ) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set( $key, $val ) {
        $this->values[$key] = $val;
    }

    static function getRequest() {
        return self::instance()->get('request');
    }

    static function setRequest( \woo\controller\Request $request ) {
        return self::instance()->set('request', $request );
    }

}

class SessionRegistry extends Registry {
    private static $instance;
    protected function __construct() {
        session_start();
    }

    static function instance() {
        if ( ! isset(self::$instance) ) { self::$instance = new self(); }
        return self::$instance;
    }

    protected function get( $key ) {
        if ( isset( $_SESSION[__CLASS__][$key] ) ) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }

    protected function set( $key, $val ) {
        $_SESSION[__CLASS__][$key] = $val;
    }

    function setComplex( Complex $complex ) {
        self::instance()->set('complex', $complex);
    }

    function getComplex( ) {
        return self::instance()->get('complex');
    }
}

class ApplicationRegistry extends Registry {
    private static $instance;
    private $freezedir = "/tmp/data";
    private $values = array();
    private $mtimes = array();

    static function instance() {
        if ( ! isset(self::$instance) ) { self::$instance = new self(); }
        return self::$instance;
    }

    protected function get( $key ) {
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        if ( file_exists( $path ) ) {
            clearstatcache();
            $mtime=filemtime( $path );
            if ( ! isset($this->mtimes[$key] ) ) { $this->mtimes[$key]=0; }
            if ( $mtime > $this->mtimes[$key] ) {
                $data = file_get_contents( $path );
                $this->mtimes[$key]=$mtime;
                return ($this->values[$key]=unserialize( $data ));
            }
        }
        if ( isset( $this->values[$key] ) ) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set( $key, $val ) {
        $this->values[$key] = $val;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        file_put_contents( $path, serialize( $val ) );
        $this->mtimes[$key]=time();
    }

    static function getDSN() {
        return self::instance()->get('dsn');
    }

    static function setDSN( $dsn ) {
        return self::instance()->set('dsn', $dsn);
    }

    static function setControllerMap( \woo\controller\ControllerMap $map  ) {
        self::instance()->set( 'cmap', $map );
    }

    static function getControllerMap() {
        return self::instance()->get( 'cmap' );
    }

    static function appController() {
        $obj = self::instance();
        if ( ! isset( $obj->appController ) ) {
            $cmap = $obj->getControllerMap();
            $obj->appController = new \woo\controller\AppController( $cmap );
        }
        return $obj->appController;
    }
}

class MemApplicationRegistry extends Registry {
    private static $instance;
    private $values=array();
    private $id;
    const DSN=1;

    protected function __construct() {
        $this->id = @shm_attach(55, 10000, 0600);
        if ( ! $this->id ) {
            throw new Exception("could not access shared memory");
        }
    }

    static function instance() {
        if ( ! isset(self::$instance) ) { self::$instance = new self(); }
        return self::$instance;
    }

    protected function get( $key ) {
        return shm_get_var( $this->id, $key );
    }

    protected function set( $key, $val ) {
        return shm_put_var( $this->id, $key, $val );
    }

    static function getDSN() {
        return self::instance()->get(self::DSN);
    }

    static function setDSN( $dsn ) {
        return self::instance()->set(self::DSN, $dsn);
    }

}
?>
