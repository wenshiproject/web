<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 综合业务数据后台日志模块基类
 */
class Sylogbase {

	#final protected function __construct(){}
	final protected function __clone(){}

//	/**
//	 * 给子类设置日志定义
//	 *
//	 * @param array $logDefinition
//	 */
//	protected function setLogDefinition($logDefinition)
//	{
//		self::$_logDefinition = $logDefinition;
//	}
	public $logDir = ''; //日志目录
	public $logName = ''; //日志名称
	public $phpTypeLogArray = array('');  //需要使用php切割日志的日志名数组,不在这数组里的就是默认用shell方式切割
	public $intvalMin=5;//使用php切割日志时创建文件频率，单位分钟

	/**
	 *
	 * @param string $tableName 对应日志表名
	 */
	public function __construct($logName,$write_type='sh',$intvalMin=5)
	{
		$logConfig = include dirname(__FILE__).'/../config/datapark_config.php';
		$this->logDir = $logConfig['log_dir'];
		$this->logName = $logName;
	}

	/**
	 * 写日志
	 *
	 * @param array $logData
	 */
	public function write($aLogData)
	{
		self::validate($aLogData); // 进行基础验证，不满足直接抛异常，中断程序
		if (in_array($this->logName,$this->phpTypeLogArray))
	  	{
	  		$this->logName = $this->php_cut_log($this->logName,$this->intvalMin);
	  	}
		$exists = file_exists($this->logDir.$this->logName);
		if (false === $exists ) {//如果是新的日志文件，则加上表头
			$field_arr=$this->getDefinition();
			$field_str = implode('|',$field_arr); // 组合成日志要的字符串格式
			$field_str .= "\n";
			file_put_contents($this->logDir.$this->logName, $field_str.self::content_format($aLogData),FILE_APPEND | LOCK_EX);
		}else{
			file_put_contents($this->logDir.$this->logName, self::content_format($aLogData),FILE_APPEND | LOCK_EX);
		}
	}

	/**
	 * 给子类设置日志定义
	 * @return array 日志定义
	 */
	public function getDefinition()
	{
		throw new Exception("You must overwrite the getDefinition method in subclass"); //必须在子类覆盖该方法
	}

    private function validate($logData)
    {
    	// 验证数组数量是否正确
    	$expectCount = count($this->getDefinition());
    	$realCount = count($logData);
    	if ($expectCount != $realCount)
    	{
    		throw new Exception("Data Park's Log Validate error: expect column count is $expectCount, but $realCount");
    	}

    	// 逐一验证字段顺序与拼写是否有错
    	$tlogDataKeys = array_keys($logData);
    	$i = 0;
    	foreach ($this->getDefinition() as $columnName) {
    		if ($tlogDataKeys[$i] != $columnName){
    			$position = $i+1; // 组合成自然序号,以便于人类阅读理解
    			throw new Exception("Data Park's Log Validate error: column \"$columnName\" is not in right position($position)! Please check the spell or position.");
    		}
    		$i++;
    	}
    }

	/**
	 * 参数格式化成符合日志格式的字符串
	 *
	 * @param array $sBuff 参数数组
	 * @return string 符合日志格式的字符串
	 */
	private function content_format($aLogData)
	{
		$aLogDataOkArr = array();
		foreach ($aLogData as $value) {
			$aLogDataOkArr[] = str_replace('|','',$value); // 过滤掉日志分隔符
		}
		$sLogDataOKString = implode('|',$aLogDataOkArr); // 组合成日志要的字符串格式
		$sLogDataOKString = str_replace("\n",' ',$sLogDataOKString);
		return $sLogDataOKString."\n";
	}
	
	public function php_cut_log($logName,$intvalMin)
	{
		$time = time();
		$m = date('i',$time);
		$m = $m - $m % $intvalMin;
		$m = $m < 10 ? '0'.$m : $m;
		$prefix = date('YmdH',$time).$m.'00';
		$new_log_name = $prefix.'_'.$logName;
		return $new_log_name;
	}
}