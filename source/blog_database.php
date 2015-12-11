<?php


if(!defined('BLOG')) {
	exit('Access Denied');
}
class blog_database {

	public static $config=array();
	public static $curlink;
	public static $version='';
	public static $link = array();

	public static function init($config) {
		self::$config=$config;
		self::connect();
	}
	
	//连接数据库
	public static function connect($serverid = 1) {
		if(empty(self::$config) || empty(self::$config[$serverid])) {
			self::halt('config db not found');
		}

		if(self::$config[$serverid]['pconnect']) {
			$link = @mysql_pconnect(self::$config[$serverid]['host'], self::$config[$serverid]['user'], self::$config[$serverid]['pw'], MYSQL_CLIENT_COMPRESS);
		} else {
			$link = @mysql_connect(self::$config[$serverid]['host'], self::$config[$serverid]['user'], self::$config[$serverid]['pw'], 1, MYSQL_CLIENT_COMPRESS);//1 如果用同样的参数第二次调用 mysql_connect()，将不会建立新连接 MYSQL_CLIENT_COMPRESS 使用压缩协议 
		}
		if(!$link) {
			$error=mysql_error();
			self::halt($error, self::errno());
		} else {
			self::$link[$serverid] = self::$curlink = $link;
			if(self::version() > '4.1') {
				$dbcharset = self::$config[$serverid]['charset'];
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= self::version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $link);
			}
			@mysql_select_db(self::$config[$serverid]['dbname'], $link);
		}
	}
	//获取mysql版本
	public static function version() {
		if(empty(self::$version)) {
			self::$version = mysql_get_server_info(self::$curlink);
		}
		return self::$version;
	}
	//错误信息
	public static function errno() {
		return intval((self::$curlink) ? mysql_errno(self::$curlink) : mysql_errno());
	}
	public static function error() {
		return ((self::$curlink) ? mysql_error(self::$curlink) : mysql_error());
	}
	//db 错误
	public static function halt($message = '', $code = 0, $sql = '') {
		throw new DbException($message, $code, $sql);
	}

	public static function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	//返回单条数据
	public static function fetch_first($sql, $arg = array()) {
		$res = self::query($sql, $arg, false);
		$ret = self::fetch_array($res);
		self::free_result($res);
		return $ret ? $ret : array();
	}
	//返回单个字段
	public static function result_first($sql, $arg = array()) {
		$res = self::query($sql, $arg, false);
		$ret = self::result($res, 0);
		self::free_result($res);
		return $ret;
	}
	public static function result($query, $row = 0) {
		$query = @mysql_result($query, $row);
		return $query;
	}
	//返回查询所得的所有数据
	public static function fetch_all($sql, $arg = array(), $keyfield = '') {
		$data = array();
		$query = self::query($sql, $arg, false);
		while ($row = self::fetch_array($query)) {
			if ($keyfield && isset($row[$keyfield])) {
				$data[$row[$keyfield]] = $row;
			} else {
				$data[] = $row;
			}
		}
		self::free_result($query);
		return $data;
	}
	//insert 插入
	public static function insert($table, $data, $return_insert_id = false, $replace = false) {
		$sql = self::implode($data);
		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$table = self::table($table);
		return self::query("$cmd $table SET $sql", null, !$return_insert_id);
	}
	//update 更新
	public static function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
		$sql = self::implode($data);
		if(empty($sql)) {
			return false;
		}
		$cmd = "UPDATE " . ($low_priority ? 'LOW_PRIORITY' : '');
		$table = self::table($table);
		$where = '';
		if (empty($condition)) {
			$where = '1';
		} elseif (is_array($condition)) {
			$where = self::implode($condition, ' AND ');
		} else {
			$where = $condition;
		}
		$res = self::query("$cmd $table SET $sql WHERE $where", $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}
	//删除
	public static function delete($table, $condition, $limit = 0, $unbuffered = true) {
		if (empty($condition)) {
			return false;
		} elseif (is_array($condition)) {
			if (count($condition) == 2 && isset($condition['where']) && isset($condition['arg'])) {
				$where = self::format($condition['where'], $condition['arg']);
			} else {
				$where = self::implode($condition, ' AND ');
			}
		} else {
			$where = $condition;
		}
		$limit = intval($limit);
		$sql = "DELETE FROM " . self::table($table) . " WHERE $where " . ($limit > 0 ? "LIMIT $limit" : '');
		return self::query($sql, ($unbuffered ? 'UNBUFFERED' : ''));
	}
	//query 查询
	public static function query($sql, $arg = array(), $unbuffered = false) {
		if (!empty($arg)) {
			if (is_array($arg)) {
				$sql = self::format($sql, $arg);
			}elseif ($arg === 'UNBUFFERED') {
				$unbuffered = true;
			}
		}
		self::checkquery($sql);
		$func = $unbuffered ? 'mysql_unbuffered_query' : 'mysql_query';

		if(!($query = $func($sql, self::$curlink))) {
			if(in_array(self::errno(), array(2006, 2013))) {//2006数据库链接断开，2013偶尔的登录失败
				self::connect();
				if(!($query = $func($sql, self::$curlink))) {
					self::halt(self::error(), self::errno(), $sql);
				}
			}else{
				self::halt(self::error(), self::errno(), $sql);
			}
		}

		if (!$unbuffered && $query) {
			$cmd = trim(strtoupper(substr($sql, 0, strpos($sql, ' '))));
			if ($cmd === 'SELECT') {

			} elseif ($cmd === 'UPDATE' || $cmd === 'DELETE') {
				$query = self::affected_rows();
			} elseif ($cmd === 'INSERT') {
				$query = self::insert_id();
			}
		}
		return $query;
	}

	//分页处理
	public static function limit($start, $limit = 0) {
		$limit = intval($limit > 0 ? $limit : 0);
		$start = intval($start > 0 ? $start : 0);
		if ($start > 0 && $limit > 0) {
			return " LIMIT $start, $limit";
		} elseif ($limit) {
			return " LIMIT $limit";
		} elseif ($start) {
			return " LIMIT $start";
		} else {
			return '';
		}
	}
	//组织数据
	public static function implode($array, $glue = ',') {
		$sql = $comma = '';
		$glue = ' ' . trim($glue) . ' ';
		foreach ($array as $k => $v) {
			$sql .= $comma . self::quote_field($k) . '=' . self::quote($v);
			$comma = $glue;
		}
		return $sql;
	}
	public static function quote_field($field) {
		if (is_array($field)) {
			foreach ($field as $k => $v) {
				$field[$k] = self::quote_field($v);
			}
		} else {
			if (strpos($field, '`') !== false)
				$field = str_replace('`', '', $field);
			$field = '`' . $field . '`';
		}
		return $field;
	}
	//sql注入检测
	public static function checkquery($sql) {
		return blog_database_safecheck::checkquery($sql);
	}
	//受影响的行数
	public static function affected_rows() {
		return mysql_affected_rows(self::$curlink);
	}
	//插入的id
	public static function insert_id() {
		return ($id = mysql_insert_id(self::$curlink)) >= 0 ? $id : self::result(self::query("SELECT last_insert_id()"), 0);
	}
	//数据表名称
	public static function table($tablename) {
		return self::$config['1']['tablepre'].$tablename;
	}
	//格式化sql
	public static function format($sql, $arg) {
		$count = substr_count($sql, '%');
		if (!$count) {
			return $sql;
		} elseif ($count > count($arg)) {
			throw new DbException('SQL string format error! This SQL need "' . $count . '" vars to replace into.', 0, $sql);
		}

		$len = strlen($sql);
		$i = $find = 0;
		$ret = '';
		while ($i <= $len && $find < $count) {
			if ($sql{$i} == '%') {
				$next = $sql{$i + 1};
				if ($next == 't') {//表名
					$ret .= self::table($arg[$find]);
				} elseif ($next == 's') {//addslashes 转义
					$ret .= self::quote(is_array($arg[$find]) ? serialize($arg[$find]) : (string) $arg[$find]);
				} elseif ($next == 'f') {//前导零
					$ret .= sprintf('%F', $arg[$find]);
				} elseif ($next == 'd') {//数字
					$ret .= intval($arg[$find]);
				} elseif ($next == 'i') {//不处理
					$ret .= $arg[$find];
				} elseif ($next == 'n') {//如 uid IN (1,2,3)
					if (!empty($arg[$find])) {
						$ret .= is_array($arg[$find]) ? implode(',', self::quote($arg[$find])) : self::quote($arg[$find]);
					} else {
						$ret .= '0';
					}
				} else {
					$ret .= self::quote($arg[$find]);
				}
				$i++;
				$find++;
			} else {
				$ret .= $sql{$i};
			}
			$i++;
		}
		if ($i < $len) {
			$ret .= substr($sql, $i);
		}
		return $ret;
	}
	public static function quote($str, $noarray = false) {
		if (is_string($str))
			return '\'' . addcslashes($str, "\n\r\\'\"\032") . '\'';

		if (is_int($str) or is_float($str))
			return '\'' . $str . '\'';

		if (is_array($str)) {
			if($noarray === false) {
				foreach ($str as &$v) {
					$v = self::quote($v, true);
				}
				return $str;
			} else {
				return '\'\'';
			}
		}

		if (is_bool($str))
			return $str ? '1' : '0';

		return '\'\'';
	}
	//释放资源
	public static function free_result($query) {
		return mysql_free_result($query);
	}
}

class blog_database_safecheck {

	protected static $checkcmd = array('SELECT', 'UPDATE', 'INSERT', 'REPLACE', 'DELETE');
	protected static $config;

	public static function checkquery($sql) {
		if (self::$config === null) {
			self::$config = array(
				'dfunction'=>array('load_file','hex','substring','if','ord','char'),
				'daction'=>array('@','intooutfile','intodumpfile','unionselect','(select','unionall','uniondistinct'),
				'dnote'=>array('/*','*/','#','--','"'),
				'dlikehex'=>1,
				'afullnote'=>0	
			);
		}
		$cmd = trim(strtoupper(substr($sql, 0, strpos($sql, ' '))));
		if (in_array($cmd, self::$checkcmd)) {
			$test = self::_do_query_safe($sql);
			if ($test < 1) {
				throw new DbException('It is not safe to do this query', 0, $sql);
			}
		}
		return true;
	}

	private static function _do_query_safe($sql) {
		$sql = str_replace(array('\\\\', '\\\'', '\\"', '\'\''), '', $sql);
		$mark = $clean = '';
		if (strpos($sql, '/') === false && strpos($sql, '#') === false && strpos($sql, '-- ') === false && strpos($sql, '@') === false && strpos($sql, '`') === false) {
			$clean = preg_replace("/'(.+?)'/s", '', $sql);
		} else {
			$len = strlen($sql);
			$mark = $clean = '';
			for ($i = 0; $i < $len; $i++) {
				$str = $sql[$i];
				switch ($str) {
					case '`':
						if(!$mark) {
							$mark = '`';
							$clean .= $str;
						} elseif ($mark == '`') {
							$mark = '';
						}
						break;
					case '\'':
						if (!$mark) {
							$mark = '\'';
							$clean .= $str;
						} elseif ($mark == '\'') {
							$mark = '';
						}
						break;
					case '/':
						if (empty($mark) && $sql[$i + 1] == '*') {
							$mark = '/*';
							$clean .= $mark;
							$i++;
						} elseif ($mark == '/*' && $sql[$i - 1] == '*') {
							$mark = '';
							$clean .= '*';
						}
						break;
					case '#':
						if (empty($mark)) {
							$mark = $str;
							$clean .= $str;
						}
						break;
					case "\n":
						if ($mark == '#' || $mark == '--') {
							$mark = '';
						}
						break;
					case '-':
						if (empty($mark) && substr($sql, $i, 3) == '-- ') {
							$mark = '-- ';
							$clean .= $mark;
						}
						break;

					default:

						break;
				}
				$clean .= $mark ? '' : $str;
			}
		}

		if(strpos($clean, '@') !== false) {
			return '-3';
		}
		
		$clean = preg_replace("/[^a-z0-9_\-\(\)#\*\/\"]+/is", "", strtolower($clean));

		if (self::$config['afullnote']) {
			$clean = str_replace('/**/', '', $clean);
		}

		if (is_array(self::$config['dfunction'])) {
			foreach (self::$config['dfunction'] as $fun) {
				if (strpos($clean, $fun . '(') !== false)
					return '-1';
			}
		}

		if (is_array(self::$config['daction'])) {
			foreach (self::$config['daction'] as $action) {
				if (strpos($clean, $action) !== false)
					return '-3';
			}
		}

		if (self::$config['dlikehex'] && strpos($clean, 'like0x')) {
			return '-2';
		}

		if (is_array(self::$config['dnote'])) {
			foreach (self::$config['dnote'] as $note) {
				if (strpos($clean, $note) !== false)
					return '-4';
			}
		}

		return 1;
	}

}
?>