<?
//лимит на загрузку изображений(в килобайтах):
    $limitSize = $settingsSystem['icon_size'];

//сравниваем размер файла с разрешенным
   if ($limitSize >= $_FILES['file']['size']) {

   
 //разрешенные форматы файлов
 $allowedType = array("jpg", "gif", "bmp", "jpeg", "png");


//транслит
$newName = translit($_FILES['file']['name']);

//проверяем нет ли одноименных уже загруженных файлов, если есть, то прибавляем индекс в конец файла.
$newName = substitute($newName);
   
   $sizeWH = getimagesize($_FILES['file']['tmp_name']);
   
   if (($sizeWH[0] > $settingsSystem['icon_width']) || ($sizeWH[1] > $settingsSystem['icon_height'])) 
   fatalError('Размер (ширина, высота) изображения превышает допустимый!<br>
   <a href="#" onclick="javascript:history.go(-1);">Назад</a>');
		
	//размер файла(байты)
		$sizeOfFile = $_FILES['file']['size'];
		
	//проверяем есть ли пароль, если есть, то записываем
		$password = (!empty($_POST['password'])) ? sha1(md5($_POST['password'])) : 0;
	
		
	//расширение загружаемого файла
		$ext = strtolower(pathinfo($newName, PATHINFO_EXTENSION)); 
		
	//имя без расширения
		$nfile = strtolower(pathinfo($newName, PATHINFO_FILENAME));
   
        
        //проверяем разрешен ли данный формат
        if (in_array($ext, $allowedType)) {
    
		
		//загружаем файл
        $upload = move_uploaded_file($_FILES['file']['tmp_name'], '../../style/default/imgs/' . $newName);   
         
		 
		//в зависимости от результата загрузки выводим оповещение
        if ($upload) show('Иконка успешно обновлена!'); else fatalErrors('Ошибка загрузки.<br>
   <a href="#" onclick="javascript:history.go(-1);">Назад</a>');   
        
		//добавляем инфу о файле в БД
		$icon = $nfile.'.'.$ext;
		
		$sql = $db -> query("UPDATE modules SET icon = ?s WHERE id = ?i", $icon, $idEditIcon);
	
		
        //если формат не разрешен, выводим ошибку
        } else {
            $oldName = $_FILES['file']['name'];
           errors("Файл (<b>{$oldName}</b>) имеет недопустимое расширение".'<br>
   <a href="#" onclick="javascript:history.go(-1);">Назад</a>');
        }
     
		//если файл превышает допустимый размер
    } else errors('Размер файла больше разрешенного!<br>
   <a href="#" onclick="javascript:history.go(-1);">Назад</a>');   






//транслит имени файла
function translit($text) {
        $rus = array("а", "б", "в",
            "г", "ґ", "д", "е", "ё", "ж",
            "з", "и", "й", "к", "л", "м",
            "н", "о", "п", "р", "с", "т",
            "у", "ф", "х", "ц", "ч", "ш",
            "щ", "ы", "э", "ю", "я", "ь",
            "ъ", "і", "ї", "є", "А", "Б",
            "В", "Г", "ґ", "Д", "Е", "Ё",
            "Ж", "З", "И", "Й", "К", "Л",
            "М", "Н", "О", "П", "Р", "С",
            "Т", "У", "Ф", "Х", "Ц", "Ч",
            "Ш", "Щ", "Ы", "Э", "Ю", "Я",
            "Ь", "Ъ", "І", "Ї", "Є", " ");
        $lat = array("a", "b", "v",
            "g", "g", "d", "e", "e", "zh", "z", "i",
            "j", "k", "l", "m", "n", "o", "p", "r",
            "s", "t", "u", "f", "h", "c", "ch", "sh",
            "sh'", "y", "e", "yu", "ya", "_", "_", "i",
            "i", "e", "A", "B", "V", "G", "G", "D",
            "E", "E", "ZH", "Z", "I", "J", "K", "L",
            "M", "N", "O", "P", "R", "S", "T", "U",
            "F", "H", "C", "CH", "SH", "SH'", "Y", "E",
            "YU", "YA", "_", "_", "I", "I", "E", "_");
        $text = str_replace($rus, $lat, $text);
        return(preg_replace("#[^a-z0-9._-]#i", "", $text));
    }
    
 
 //добавление индекса в конец файла
 function substitute($name) {

        $files = scandir('../../style/default/imgs/');
        unset($files[0]);
        unset($files[1]);

        $i = 0;
        $newName = $name;

        preg_match("#([\w()-_]+)\.([\w]{1,4})#i", $name, $arrayNameFiles);
        $nameStart = $arrayNameFiles[1];
        $nameEnd = $arrayNameFiles[2];

        while (in_array($newName, $files)) {
            $newName = "{$nameStart}({$i}).{$nameEnd}";
            $i++;
        }
        return $newName;
    }    
?>