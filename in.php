<?php
/*
////////////////////////////////////////////////////////////////////////////////
// JohnCMS v.1.0.0 RC2                                                        //
// Дата релиза: 08.02.2008                                                    //
// Авторский сайт: http://gazenwagen.com                                      //
////////////////////////////////////////////////////////////////////////////////
// Оригинальная идея и код: Евгений Рябинин aka JOHN77                        //
// E-mail: 
// Модификация, оптимизация и дизайн: Олег Касьянов aka AlkatraZ              //
// E-mail: alkatraz@batumi.biz                                                //
// Плагиат и удаление копирайтов заруганы на ближайших родственников!!!       //
////////////////////////////////////////////////////////////////////////////////
// Внимание!                                                                  //
// Авторские версии данных скриптов публикуются ИСКЛЮЧИТЕЛЬНО на сайте        //
// http://gazenwagen.com                                                      //
// Если Вы скачали данный скрипт с другого сайта, то его работа не            //
// гарантируется и поддержка не оказывается.                                  //
////////////////////////////////////////////////////////////////////////////////
*/

define('_IN_PUSTO', 1);

$textl = 'Вход';
require ("incfiles/db.php");
require ("incfiles/func.php");
require ("incfiles/data.php");
require ("incfiles/head.php");
require ("incfiles/inc.php");

if ($_GET['err'] == 1)
{
    echo "Ошибка авторизации!";
}
echo "<div class = 'e' ><form action='auto.php' method='get'>
Имя:<br/>
<input type='text' name='n' maxlength='20'/><br/>
Пароль:<br/>
<input type='password' name='p' maxlength='20'/><br/>
<input type='checkbox' name='mem' value='1'/>Запомнить меня<br/>
<input type='submit' value='Вход'/>
</form></div>";
echo "<a href='str/skl.php?continue'>Продолжить восстановление пароля</a><br/>";
require ("incfiles/end.php");

?>