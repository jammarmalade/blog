<?php

error_reporting(E_ALL);
define('BLOG', true);
define('BLOG_DEBUG', false);

set_exception_handler(array('jam', 'jamException'));//�쳣����

if(BLOG_DEBUG){
	set_error_handler(array('jam', 'jamError'));//������ (������)
	register_shutdown_function(array('jam', 'jamShutdown'));//����PHP����ִ����ɺ�ִ�еĺ���
}

if(function_exists('spl_autoload_register')) {//�Զ�������
	spl_autoload_register(array('jam', 'autoload'));
} else {
	function __autoload($class) {//�Զ������ࣨ�ϰ汾��
		return jam::autoload($class);
	}
}
class DB extends blog_database {}
class J extends jam {}
J::creatapp();

DB::init($_B['config']['db']);
//��ʼ���û�
J::app()->init_web();
class jam
{
	private static $_app;
	private static $_imports;
	private static $_tables;//���ݱ������(�Զ��������ļ������ļ�����Ҫ��������ͬ)

	public static function app() {
		return self::$_app;
	}
	//ʵ���� application
	public static function creatapp() {
		if(!is_object(self::$_app)) {
			self::$_app = jam_application::instance();
		}
		return self::$_app;
	}
	//���ݱ���
	public static function t($name) {
		$classname = 't_'.$name;
		if(!isset(self::$_tables[$classname])) {
			self::$_tables[$classname] = new $classname;
		}
		return self::$_tables[$classname];
	}
	//�Զ����쳣����
	public static function jamException($exc) {
		jam_error::exception_error($exc);
	}
	//�Զ��������
	public static function jamError($errno, $errstr, $errfile, $errline) {
		echo 'jamError';
	}
	//
	public static function jamShutdown() {
		echo 'jamShutdown';
	}

	public static function autoload($class) {
		$class = strtolower($class);
		if(strpos($class, 't_') !== false) {
			$file = 'table/'.$class;//���Ǳ�ģ����
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
	public static function import($name) {//�������ļ�
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