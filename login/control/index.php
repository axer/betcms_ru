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
        $password = (!empty($_POST['password'])) ? $_POST['password'] : false;
        
        $password = md5(sha1(md5($password)));
        
        #проверяем все ли данные введены корректно
        if ($login && $password) {
                      
            #обнуляем ошибки
            $error = false;
                       
            #проверяем не зарегистрирован ли пользователь с таким логином
            $query = $db -> query("SELECT * FROM users WHERE login = ?s ", $login);
            $loginInBase = $db -> numRows($query);
            
            
            
            #если пользователь с таким логином есть, выводим ошибку
            if ($loginInBase)  {
                $user = $db -> fetch($query);
                
                if ($user['password'] == $password) {
                    
                    #по умолчанию - пользователь -- не админ.
                    $_SESSION['userAdmin'] = false;
                    
                    #запоминаем ID пользователя
                    $_SESSION['userId'] = $user['id'];
                    
                    #если пользователь админ, делаем соответствующую метку
                    if ($user['admin']) $_SESSION['userAdmin'] = true;
                    
                    show('Успешная авторизация!<br /> <a href="/">Главная страница</a>');
                } else {
                        errors('Логин/Пароль не совпадают!<br />
                        <a href="">Повторить</a>');
                        $error = true;
                        }
                
           } else errors('Пользователя с такими данными не существует!<br />
                        <a href="">Повторить</a>');
           
        } else errors('Заполните все поля!<br />
                        <a href="">Повторить</a>');
        
    } else {
        errors('Каптча введена неверно!<br />
                        <a href="">Повторить</a>');
        $_SESSION['login'] = $_POST['login'];
    }
    
}
    