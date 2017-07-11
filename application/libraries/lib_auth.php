<? // Библиотека авторизации

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Lib_auth {
	
	// Выполняем проверку логина и пароля. В случае удачи - авторизируем
	function do_login ($login, $pass) {    
            
		$CI = &get_instance ();		
		// Правильные данные
		$right_login = $CI->config->item ('admin_login');
		$right_pass = strval ($CI->config->item ('admin_pass'));
        $user_ip = $_SERVER ['REMOTE_ADDR'];
        
		// Проверка на соответствие
		if (($right_login === $login) && ($right_pass === $pass)) { 
                     
			//Если правильно - записываем сессию
			$ses = array (
                'admin_logged' => 'ok',
                'admin_hash' => $this->the_hash ()
            );
            			
			$CI->session->set_userdata ($ses);           
            log_message ("error", "Успешный вход в админку с логином \"$login\", IP: $user_ip");
			redirect ('admin');	            		
		} else {       
            $mes ['count'] = 1;
            $mes [] = 'Неверный логин или пароль!';
            $CI->session->set_flashdata ($mes);
            log_message ("error", "Вход в админку с логином \"$login\" и паролем \"$pass\" завершился ошибкой, IP: $user_ip");
			redirect ('admin/login');
		}		
	}
	
	// Формируем дополнительный хэш проверки 
	function the_hash () {	   	
		$CI = &get_instance ();     		
		// Формируем хеш: пароль + IP + доп.слово
		$hash = md5 ($CI->config->item ('pass').$_SERVER ['REMOTE_ADDR'].'CICMS');		
		return $hash;		
	}
	
	// Проверка авторизации в админке
	function check_admin () {	    	
		$CI = &get_instance ();	             	
		if (($CI->session->userdata ('admin_logged') == 'ok') && ($CI->session->userdata ('admin_hash') == $this->the_hash ())) {					
				return TRUE;					
		} else {
			redirect ('admin/login');
		}               
	}
	
	// Логаут - очистка сессии
	function logout () {    		
		$CI = &get_instance ();               
		/*$ses = array ('admin_logged' => '', 'admin_hash' => '');	        		
		$CI->session->unset_userdata ($ses);*/        
        $CI->session->sess_destroy ();	 /* 24.07.2014 19:22 */	
		redirect ('admin/login');		
	}		
}
