<?php

class Feedback {
	
	public function show ($type = null, $flash = true) {
		if (!empty($_SESSION['feedback'])) {
			$return = null;
			if (is_null($type)) {							
				foreach ($_SESSION['feedback'] as $type => $feedback) {					
					foreach ($feedback as $message) {
						$return .= '<p class="alert alert-'.$type.'">'.$message.'</p>'; 
					}
				} 
				if ($flash) unset($_SESSION['feedback']);			
			} else {
				foreach ($_SESSION['feedback'][$type] as $message) {
					$return .= '<p class="alert alert-'.$type.'">'.$message.'</p>'; 
				}
				if ($flash) unset($_SESSION['feedback'][$type]);
			}
			return $return;
		}
	}
	
	public function message ($type = 'error', $message = null) {
		if (isset($type)) {
			if(!in_array($message, $_SESSION['feedback'][$type]))
				$_SESSION['feedback'][$type][] = $message;
		}
	}
	
	public function clear ($type = null) {
		if (!empty($_SESSION['feedback'])) {
			if (is_null($type)) {
				unset($_SESSION['feedback']);
			} else {
				unset($_SESSION['feedback'][$type]);
			}
		}
	}

	public function __call ($call, $args) {
		$call = strtolower($call);
		$this->message($call, $args[0]);
	}
	
	public static function __callStatic ($call, $args) {
		$call = strtolower($call);
		self::message($call, $args[0]);
	}
	
}