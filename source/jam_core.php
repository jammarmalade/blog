<?php

error_reporting(E_ALL);
define('BLOG', true);
//是否 开启 debug，线上要为 false
define('BLOG_DEBUG', true);

set_exception_handler(array('jam', 'jamException'));//异常处理

if(BLOG_DEBUG){
	set_error_handler(array('jam', 'jamError'));//错误处理 (有问题)
	register_shutdown_function(array('jam', 'jamShutdown'));//定义PHP程序执行完成后执行的函数
}

if(function_exists('spl_autoload_register')) {//自动加载类
	spl_autoload_register(array('jam', 'autoload'));
} else {
	function __autoload($class) {//自动加载类（老版本）
		return jam::autoload($class);
	}
}
class DB extends blog_database {}
class J extends jam {}
J::creatapp();

DB::init($_B['config']['db']);
//初始化用户
J::app()->init_web();
class jam
{
	private static $_app;
	private static $_imports;
	private static $_tables;//数据表的类名(自动加载类文件，类文件名需要和类名相同)

	public static function app() {
		return self::$_app;
	}
	//实例化 application
	public static function creatapp() {
		if(!is_object(self::$_app)) {
			self::$_app = jam_application::instance();
		}
		return self::$_app;
	}
	//数据表类
	public static function t($name) {
		$classname = 't_'.$name;
		if(!isset(self::$_tables[$classname])) {
			self::$_tables[$classname] = new $classname;
		}
		return self::$_tables[$classname];
	}
	//自定义异常处理
	public static function jamException($exc) {
		jam_error::exception_error($exc);
	}
	//自定义错误处理（有问题）
	public static function jamError($errno, $errstr, $errfile, $errline) {
	//	echo 'jamError';
	}
	//自定义 程序执行完成或意外死掉导致PHP执行即将关闭时，将被调用的函数
	public static function jamShutdown() {
		//若是调试模式，程序运行完成后，打印错误信息
		if(($error = error_get_last()) && $error['type'] & BLOG_DEBUG) {
			jam_error::system_error($error['message'], $error['type'],$error['file'].' - '.$error['line']);
		}
	}

	public static function autoload($class) {
		$class = strtolower($class);
		if(strpos($class, 't_') !== false) {
			$file = 'table/'.$class;//若是表模型类
		}else{
			$file =$class;
		}

		try {
			self::import($file);
			return true;
		} catch (Exception $exc) {
			$trace = $exc->getTrace();
			foreach ($trace as $log) {
				if(empty($log['class']) && $log['function'] == 'class_exists') {
					return false;
				}
			}
			jam_error::exception_error($exc);
		}

	}
	public static function import($name) {//引入类文件
		if(!isset(self::$_imports[$name])) {
			$path=BLOG_ROOT.'/source/'.$name.'.php';
			$blog_path=BLOG_ROOT.'/source/blog_'.$name.'.php';
			$class_path='';
			list($folder,)=explode('_',$name);
			if($folder){
				$class_path=BLOG_ROOT.'/source/'.$folder.'/'.$name.'.php';
			}
			if(is_file($path)) {
				self::$_imports[$name] = true;
				return include $path;
			}elseif(is_file($blog_path)){
				self::$_imports[$name] = true;
				return include $blog_path;
			}elseif(is_file($class_path)){
				self::$_imports[$name] = true;
				return include $class_path;
			}else {
				throw new Exception('Oops! System file lost: '.$path);
			}
		}
		return true;
	}
}


?>