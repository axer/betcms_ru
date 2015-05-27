<?php
if (isset($_POST['captcha'])) {
    $errorCaptcha = false;
    
    #принимаем и обрабатываем каптчу
    $captcha = trim(strtolower($_POST['captcha']));
      
    #если каптча введена неверно, добавляем ошибку
        if ($captcha != $_SESSION['captcha']) $errorCaptcha = true;
    
    #если каптча введена верно   
    if  (!$errorCaptcha) {
        
        #очищаем данные
        foreach($_POST as $key=>$value){
            $_POST[$key] = XSS($value);
        }

        
        #проверяем и записываем данные
        $login = (is_string($_POST['login'])) ? $_POST['login'] : false;
        $pas1 = (!empty($_POST['pas1'])) ? $_POST['pas1'] : false;
        $pas2 = (!empty($_POST['pas2'])) ? $_POST['pas2'] : false;
        $email = (preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['email'])) ? $_POST['email'] : false;
        
        #проверяем все ли данные введены корректно
        if ($login && $pas1 && $pas2 && $email) {
            
            #если пароли совпадают
            if ($pas1 == $pas2) {
            
            #обнуляем ошибки
            $error = false;
                       
            #проверяем не зарегистрирован ли пользователь с таким логином
            $query = $db -> query("SELECT * FROM users WHERE login = ?s ", $login);
            $loginInBase = $db -> numRows($query);
            
            #если пользователь с таким логином есть, выводим ошибку
            if ($loginInBase)  {
                                   errors('Пользователь с таким логином уже зарегистрирован!');
                                   $error = true;
                                }
            
            #проверяем не зарегистрирован ли пользователь с таким email
            if (!CheckEmail($email)) {
                                        errors('Пользователь с таким Email уже зарегистрирован!');
                                        $error = true;
                                     }
            
            #если не возникло никаких ошибок
            if (!$error) {
                
            #запоминаем пароль
            $password = md5(sha1(md5($pas1)));
            
			#проверяем наличие бонуса при регистрации
			$bonus_reg = ($settingsSystem['bonus_reg']) ? $settingsSystem['bonus_reg'] : 0;
			
            #добавляем пользователя в БД
            $query = $db -> query("INSERT INTO users (login, password, email, balance) VALUES (?s, ?s, ?s, ?i)", $login, $password, $email, $bonus_reg);
            
            #если пользователь добавлен в базу
            if ($query) {
                        show('Успешная регистрация! Теперь вы можете авторизоваться в системе.');
                        $_SESSION['login'] = '';
                        $_SESSION['email'] = '';
                        }
                else    
                        {
                        #если не удалось записать пользователя в БД, выдаем ошибку
                        errors('Ошибка записи пользователя в БД.');
                        }
                        
            #если возникали ошибка, выводи соответствующее сообщение           
            } else errors('Ошибка регистрации. Повторите снова.');
            
            
            #если пароли не совпали, выдаем ошибку            
            } else errors('Пароли не совпадают!');
        
        #если какие-либо данные не заполнены, или введены не корректно, выдаем ошибку    
        } else errors('Заполните корректно все поля!');
        
        
              
    } else  {
            #выводим сообщение о том, что каптча введена неверно
            echo errors('Каптча введена неверно!');
            
            #запомним данные, которые вводил пользователь
            $_SESSION['login'] = XSS($_POST['login']);
            $_SESSION['email'] = XSS($_POST['email']);
            
            }
}