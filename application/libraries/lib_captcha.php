<? // Библиотека капчи

class lib_captcha {

    // Случайная строка
    var $session_key = "capcode_iuhOYujkLKJubjHB";
   
    function old_generate_code ($charlen) { 
       
        // Алгоритм выдачи случайного кода
        $possible = "23456789bcdfghjkmnpqrstvwxyz";
        $code = ""; $i = 0;
        
        while ($i < $charlen) {
            $code .= substr ($possible, mt_rand (0, strlen ($possible) - 1), 1);
            $i++;
        }         
        return $code;
    }
    
    // Проверка кода для сессии
    function check ($code) {             
        $CI = &get_instance (); 
        return ($CI->session->userdata ($this->session_key) == $code)? TRUE : FALSE;
    }
    
    // Генерация изображения
    function image () {
 
        $CI = &get_instance (); 
        $captcha = unserialize ($CI->config->item ('captcha_info'));
        
        // Кол-во символов на капче
        $charlen = $captcha ['symbols'];
        
        // Ширина и высота картинки с капчей
        $width = 100; // $captcha ['width']; 
        $height = 35; // $captcha ['height'];
        
	    $im1 = imagecreatetruecolor ($width, $height) or die ('Невозможно инициализировать поток в GD image!');
        
        // Цвет фона на картинке
        $bg = imagecolorallocate ($im1, 66, 189, 194);

        // Прозрачность фона (?)
        imagecolortransparent ($im1, $bg); 

        // Обводка
        imagefilledrectangle ($im1, 0, 0, $width, $height, $bg);

        $char = $this->old_generate_code ($charlen);

	    $CI->session->set_userdata ($this->session_key, $char);

        // Цвет надписи
        switch ($captcha ['color']) {
            case 'green' : $color = imagecolorallocate ($im1, 0, 150, 0); break;
            case 'red' : $color = imagecolorallocate ($im1, 255, 0, 0); break;
            case 'blue' : $color = imagecolorallocate ($im1, 67, 105, 159); break;
            case 'black' : $color = imagecolorallocate ($im1, 0, 0, 0); break;
            case 'white' : $color = imagecolorallocate ($im1, 255, 255, 255); break;    
        } 

        for ($i = 0; $i < strlen ($char); $i++) {
            $x = 16 + $i * 9;
            $y = 4;
            imagechar ($im1, 4, $x, $y, $char [$i], $color);
        }       

        $im2 = $this->mv ($im1, $width, $height);
        //$im2 = $im1;
        
        // Цвет обводки
        // imagerectangle ($im2, 0, 0, $width-1, $height-1, imagecolorallocate ($im2, 66, 189, 194));

        if (function_exists ('imagejpeg')) { 
            header ('Content-type: image/jpg');
            imagejpeg ($im2); 
              
        } elseif (function_exists ('imagepng')) {
            header ('Content-type: image/png'); 
            imagepng ($im2);
             
		} elseif (function_exists ('imagegif')) {
            header ('Content-type: image/gif'); 
            imagegif ($im2);
            
		} else {
		   die ('PHP сервер не поддерживает ни один из типов изображений (jpg,png,gif)!');
		}

        // Удаляем все картинки
		imagedestroy ($im1);
		imagedestroy ($im2);
    }

    // Искажение изображения
    function mv ($im, $width, $height) {
        
        $im2 = imagecreatetruecolor ($width, $height)
        or die ('Невозможно инициализировать поток в GD image!'); 
        
        // Цвет подложки (вне искаженного изображения)
        $bg = imagecolorallocate ($im2, 255, 255, 255);
        
        imagefilledrectangle ($im2, 0, 0, $width, $height, $bg);
        
        // Параметры искажения:
        // частоты
        $rand1 = mt_rand (700000, 1000000) / 15000000;
        $rand2 = mt_rand (700000, 1000000) / 15000000;
        $rand3 = mt_rand (700000, 1000000) / 15000000;
        $rand4 = mt_rand (700000, 1000000) / 15000000;
        
        // фазы
        $rand5 = mt_rand(0, 3141592) / 1000000;
        $rand6 = mt_rand(0, 3141592) / 1000000;
        $rand7 = mt_rand(0, 3141592) / 1000000;
        $rand8 = mt_rand(0, 3141592) / 1000000;
        
        // амплитуды
        //$rand9 = mt_rand (400, 600) / 100;
        //$rand10 = mt_rand (400, 600) / 100;
        $rand9 = 0;
        $rand10 = 0;

        for ($x = 0; $x < $width; $x++) {
                
            for ($y = 0; $y < $height; $y++) {
                $sx = ($x + (sin ($x * $rand1 + $rand5) + sin ($y * $rand3 + $rand6) ) * $rand9) / 1.5;
                $sy = ($y + (sin ($x * $rand2 + $rand7) + sin ($y * $rand4 + $rand8) ) * $rand10) / 1.5;

                if ($sx < 0 || $sy < 0 || $sx >= $width - 1 || $sy >= $height - 1) {
                    continue;
                } else { 
                    $color = imagecolorsforindex ($im, imagecolorat ($im, $sx, $sy));
                    $color_x = imagecolorsforindex ($im, imagecolorat ($im, $sx + 1, $sy));
                    $color_y = imagecolorsforindex ($im, imagecolorat ($im, $sx, $sy + 1));
                    $color_xy = imagecolorsforindex ($im, imagecolorat ($im, $sx + 1, $sy + 1));
                }
    
                $frsx = $sx - floor ($sx);
                $frsy = $sy - floor ($sy);
                $frsx1 = 1 - $frsx;
                $frsy1 = 1 - $frsy;          
    
                $red   = floor ($color ['red']      * $frsx1 * $frsy1 +
                                $color_x ['red']    * $frsx  * $frsy1 +
                                $color_y ['red']    * $frsx1 * $frsy  +
                                $color_xy ['red']   * $frsx  * $frsy );
    
                $green = floor ($color ['green']    * $frsx1 * $frsy1 +
                                $color_x ['green']  * $frsx  * $frsy1 +
                                $color_y ['green']  * $frsx1 * $frsy  +
                                $color_xy ['green'] * $frsx  * $frsy );
    
                $blue  = floor ($color ['blue']     * $frsx1 * $frsy1 +
                                $color_x ['blue']   * $frsx  * $frsy1 +
                                $color_y ['blue']   * $frsx1 * $frsy  +
                                $color_xy ['blue']  * $frsx  * $frsy );
    
                $newcolor = imagecolorallocate ($im2, $red, $green, $blue);
                imagesetpixel ($im2, $x, $y, $newcolor);
            }
        }       
        return $im2;
    }
}