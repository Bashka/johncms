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

$textl = 'Чат';
$headmod = "chat";
require ("../incfiles/db.php");
require ("../incfiles/func.php");
require ("../incfiles/data.php");
require ("../incfiles/char.php");
require ("../incfiles/stat.php");

// Определяем и проверяем переменные
$id = isset($_GET['id']) ? intval($_GET['id']) : ''; // Идентификатор комнаты

if (!empty($_SESSION['pid']))
{
    // Проверяем, забанен ли пользователь
    $tti = round(($datauser['chtime'] - $realtime) / 60);
    if ($datauser['chban'] == "1" && $tti > 0)
    {
        require ("../incfiles/head.php");
        require ("../incfiles/inc.php");
        echo "Вас пнули из чата<br/>Кто: <font color='" . $cdinf . "'>$datauser[chwho]</font><br/>";
        if ($datauser[chwhy] == "")
        {
            echo "<div>Причина не указана</div>";
        } else
        {
            echo "Причина:<font color='" . $cdinf . "'> $datauser[chwhy]</font><br/>";
        }
        echo "Время до окончания: $tti минут<br/>";
        require ("../incfiles/end.php");
        exit;
    }

    // Определяем местонахождение пользователя
    $where = !empty($id) ? "chat,$id" : 'chat';
    mysql_query("insert into `count` values(0,'" . $ipp . "','" . $agn . "','" . $realtime . "','" . $where . "','" . $login . "','0');");

    if (!empty($_GET['act']))
    {
        $act = check($_GET['act']);
    }
    switch ($act)
    {
            /* Удаление одного поста
            case "delpost":
            if ($dostcmod == 1)
            {
            if (empty($_GET['id']))
            {
            require ("../incfiles/head.php");
            require ("../incfiles/inc.php");
            echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
            require ("../incfiles/end.php");
            exit;
            }
            $typ = mysql_query("select * from `chat` where id='" . $id . "';");
            $ms = mysql_fetch_array($typ);
            if ($ms[type] != "m")
            {
            require ("../incfiles/head.php");
            require ("../incfiles/inc.php");
            echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
            require ("../incfiles/end.php");
            exit;
            }
            if (isset($_GET['yes']))
            {

            mysql_query("delete from `chat` where `id`='" . $id . "';");
            header("Location: $home/chat/index.php?id=$ms[refid]");
            } else
            {
            require ("../incfiles/head.php");
            require ("../incfiles/inc.php");
            echo "Вы действительно хотите удалить пост?<br/>";
            echo "<a href='index.php?act=delpost&amp;id=" . $id . "&amp;yes'>Удалить</a>|<a href='index.php?id=" . $ms[refid] . "'>Отмена</a><br/>";
            }
            } else
            {
            echo "Доступ закрыт!!!<br/>";
            }
            break;
            */
        case "room":
            if ($dostcmod == 1)
            {
                if (empty($id))
                {
                    require ("../incfiles/head.php");
                    require ("../incfiles/inc.php");
                    echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
                    require ("../incfiles/end.php");
                    exit;
                }
                $typ = mysql_query("select * from `chat` where id='" . $id . "';");
                $ms = mysql_fetch_array($typ);
                if ($ms[type] != "r")
                {
                    require ("../incfiles/head.php");
                    require ("../incfiles/inc.php");
                    echo "Ошибка!<br/><a href='index.php?'>В чат</a><br/>";
                    require ("../incfiles/end.php");
                    exit;
                }
                if (isset($_GET['yes']))
                {

                    $mes = mysql_query("select * from `chat` where refid='" . $id . "';");
                    while ($mes1 = mysql_fetch_array($mes))
                    {

                        mysql_query("delete from `chat` where `id`='" . $mes1[id] . "';");
                    }
                    header("Location: $home/chat/index.php?id=$id");
                } else
                {
                    require ("../incfiles/head.php");
                    require ("../incfiles/inc.php");
                    echo "Вы действительно хотите очистить комнату?<br/>";
                    echo "<a href='index.php?act=room&amp;id=" . $id . "&amp;yes'>Да</a>|<a href='index.php?id=" . $id . "'>Нет</a><br/>";
                }
            } else
            {
                echo "Доступ закрыт!!!<br/>";
            }
            require_once ("../incfiles/end.php");
            break;

        case "moders":
            require ("../incfiles/head.php");
            require ("../incfiles/inc.php");
            echo "<b>Модераторы чата</b><br/>";
            $mod = mysql_query("select * from `users` where rights='2';");
            $mod2 = mysql_num_rows($mod);
            if ($mod2 != 0)
            {
                while ($mod1 = mysql_fetch_array($mod))
                {
                    if ($login != $mod1[name])
                    {
                        echo "<a href='../str/anketa.php?user=" . $mod1[id] . "'><font color='" . $conik . "'>$mod1[name]</font></a>";
                    } else
                    {
                        echo "<font color='" . $csnik . "'>$mod1[name]</font>";
                    }
                    $ontime = $mod1[lastdate];
                    $ontime2 = $ontime + 300;
                    if ($realtime > $ontime2)
                    {
                        echo "<font color='" . $coffs . "'> [Off]</font><br/>";
                    } else
                    {
                        echo "<font color='" . $cons . "'> [ON]</font><br/>";
                    }
                }
            } else
            {
                echo "Не назначены<br/>";
            }
            echo "<a href='index.php?id=" . $id . "'>Назад</a><br/>";
            require_once ("../incfiles/end.php");
            break;

        case "trans":
            require ("../incfiles/head.php");
            require ("../incfiles/inc.php");
            include ("../pages/trans.$ras_pages");
            echo '<br/><br/><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">Назад</a><br/>';
            require_once ("../incfiles/end.php");
            break;

        case "say":
            if (getenv("HTTP_CLIENT_IP"))
                $ipp = getenv("HTTP_CLIENT_IP");
            else
                if (getenv("REMOTE_ADDR"))
                    $ipp = getenv("REMOTE_ADDR");
                else
                    if (getenv("HTTP_X_FORWARDED_FOR"))
                        $ipp = getenv("HTTP_X_FORWARDED_FOR");
                    else
                    {
                        $ipp = "not detected";
                    }
                    $ipp = check($ipp);
            $agn = check(getenv(HTTP_USER_AGENT));
            $agn = strtok($agn, ' ');
            if (empty($id))
            {
                require ("../incfiles/head.php");
                require ("../incfiles/inc.php");
                echo "Ошибка!<br/><a href='?'>В чат</a><br/>";
                require ("../incfiles/end.php");
                exit;
            }
            if (empty($_SESSION['pid']))
            {
                require ("../incfiles/head.php");
                require ("../incfiles/inc.php");
                echo "Вы не авторизованы!<br/>";
                require ("../incfiles/end.php");
                exit;
            }
            $type = mysql_query("select * from `chat` where id= '" . $id . "';");
            $type1 = mysql_fetch_array($type);
            $tip = $type1[type];
            switch ($tip)
            {
                case "r":
                    if (isset($_POST['submit']))
                    {
                        $flt = $realtime - 10;
                        $af = mysql_query("select * from `chat` where type='m' and time >='" . $flt . "' and `from` = '" . trim($login) . "';");
                        $af1 = mysql_num_rows($af);
                        if ($af1 > 0)
                        {
                            require ("../incfiles/head.php");
                            require ("../incfiles/inc.php");
                            echo "Антифлуд!Вы не можете так часто добавлять сообщения<br/>Порог 10 секунд<br/><a href='index.php?id=" . $id . "'>Назад</a><br/>";
                            require ("../incfiles/end.php");
                            exit;
                        }
                        if (empty($_POST['msg']))
                        {
                            require ("../incfiles/head.php");
                            require ("../incfiles/inc.php");
                            echo "Вы не ввели сообщение!<br/><a href='index.php?act=say&amp;id=" . $id . "'>Повторить</a><br/>";
                            require ("../incfiles/end.php");
                            exit;
                        }

                        // Принимаем сообщение и записываем в базу
                        $msg = check(trim($_POST['msg']));
                        $msg = mb_substr($msg, 0, 500);
                        if ($_POST[msgtrans] == 1)
                        {
                            $msg = trans($msg);
                        }

                        mysql_query("insert into `chat` values(0,'" . $id . "','','m','" . $realtime . "','" . $login . "','','0','" . $msg . "','" . $ipp . "','" . $agn . "','','');");
                        if (empty($datauser[postchat]))
                        {
                            $fpst = 1;
                        } else
                        {
                            $fpst = $datauser[postchat] + 1;
                        }
                        mysql_query("update `users` set  postchat='" . $fpst . "' where id='" . intval($_SESSION['pid']) . "';");
                        if ($type1[dpar] == "vik")
                        {
                            $protv = mysql_query("select * from `chat` where dpar='vop' and type='m' order by time desc;");
                            while ($protv2 = mysql_fetch_array($protv))
                            {
                                $prr[] = $protv2[id];
                            }
                            $pro = mysql_query("select * from `chat` where dpar='vop' and type='m' and id='" . $prr[0] . "';");
                            $protv1 = mysql_fetch_array($pro);
                            $prr = array();

                            $ans = $protv1[realid];
                            $vopr = mysql_query("select * from `vik` where id='" . $ans . "';");
                            $vopr1 = mysql_fetch_array($vopr);
                            $answer = $vopr1[otvet];
                            if (!empty($msg) && !empty($answer) && $protv1[otv] != 1)
                            {
                                if (preg_match("/$answer/i", "$msg"))
                                {
                                    $itg = $datauser[otvetov] + 1;
                                    switch ($protv1[otv])
                                    {
                                        case "2":
                                            $pods = ", не используя подсказок";
                                            $bls = 5;
                                            break;
                                        case "3":
                                            $pods = ", используя одну подсказку";
                                            $bls = 3;
                                            break;
                                        case "4":
                                            $pods = ", используя две подсказки";
                                            $bls = 2;
                                            break;
                                    }
                                    $balans = $datauser[balans] + $bls;
                                    $otvtime = $realtime - $protv1[time];
                                    if ($datauser[sex] == "m")
                                    {
                                        $tx = "молодец! Ты угадал правильный ответ:  $answer за $otvtime секунд $pods ,и заработал $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                    } else
                                    {
                                        $tx = "молодец! Ты угадала правильный ответ:  $answer за $otvtime секунд $pods ,и заработала $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                    }
                                    $mtim = $realtime + 1;
                                    mysql_query("INSERT INTO `chat` VALUES(
'0','" . $id . "','','m','" . $mtim . "','Умник','" . $login . "','', '" . $tx . "', '127.0.0.1', 'Nokia3310', '','');");
                                    mysql_query("update `chat` set otv='1' where id='" . $protv1[id] . "';");
                                    mysql_query("update `users` set otvetov='" . $itg . "',balans='" . $balans . "' where id='" . intval($_SESSION['pid']) . "';");
                                }
                            }
                        }

                        header("location: $home/chat/index.php?id=$id");
                    } else
                    {
                        require_once ("../incfiles/inc.php");
                        require_once ("chat_header.php");
                        echo 'Добавление сообщения<br />(max. 500)';
                        echo '<div class="title1">'.$type1[text].'</div>';
                        echo "<form action='index.php?act=say&amp;id=" . $id . "' method='post'><textarea cols='40' rows='3' title='Введите текст сообщения' name='msg'></textarea><br/>";
                        if ($offtr != 1)
                        {
                            echo "<input type='checkbox' name='msgtrans' value='1' /> Транслит сообщения<br/>";
                        }
                        echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/></form>";
                        echo "<div class='title2'><a href='index.php?act=trans'>Транслит</a> | <a href='../str/smile.php'>Смайлы</a><br/>";
                        echo "</div><br />[0] <a href='index.php?id=" . $id . "' accesskey='0'>Назад</a>";
                    }
                    break;

                case "m":
                    $th = $type1[refid];
                    $th2 = mysql_query("select * from `chat` where id= '" . $th . "';");
                    $th1 = mysql_fetch_array($th2);
                    if (isset($_POST['submit']))
                    {
                        $flt = $realtime - 10;
                        $af = mysql_query("select * from `chat` where type='m' and time>'" . $flt . "' and `from`= '" . $login . "';");
                        $af1 = mysql_num_rows($af);
                        if ($af1 != 0)
                        {
                            require ("../incfiles/head.php");
                            require ("../incfiles/inc.php");
                            echo "Антифлуд!Вы не можете так часто добавлять сообщения<br/>Порог 10 секунд<br/><a href='index.php?id=" . $th . "'>Назад</a><br/>";
                            require ("../incfiles/end.php");
                            exit;
                        }
                        if (empty($_POST['msg']))
                        {
                            require ("../incfiles/head.php");
                            require ("../incfiles/inc.php");
                            echo "Вы не ввели сообщение!<br/><a href='index.php?act=say&amp;id=" . $id . "'>Повторить</a><br/>";
                            require ("../incfiles/end.php");
                            exit;
                        }
                        $to = $type1[from];
                        $priv = intval($_POST['priv']);
                        $nas = check($_POST['nas']);
                        $msg = check(trim($_POST['msg']));

                        $msg = mb_substr($msg, 0, 500);
                        if ($_POST[msgtrans] == 1)
                        {
                            $msg = trans($msg);
                        }

                        mysql_query("insert into `chat` values(0,'" . $th . "','','m','" . $realtime . "','" . $login . "','" . $to . "','" . $priv . "','" . $msg . "','" . $ipp . "','" . $agn . "','" . $nas . "','');");
                        if (empty($datauser[postchat]))
                        {
                            $fpst = 1;
                        } else
                        {
                            $fpst = $datauser[postchat] + 1;
                        }
                        mysql_query("update `users` set  postchat='" . $fpst . "' where id='" . intval($_SESSION['pid']) . "';");
                        if ($th1[dpar] == "vik")
                        {
                            $protv = mysql_query("select * from `chat` where dpar='vop' and type='m' order by time desc;");
                            while ($protv2 = mysql_fetch_array($protv))
                            {
                                $prr[] = $protv2[id];
                            }
                            $pro = mysql_query("select * from `chat` where dpar='vop' and type='m' and id='" . $prr[0] . "';");
                            $protv1 = mysql_fetch_array($pro);
                            $prr = array();
                            $ans = $protv1[realid];
                            $vopr = mysql_query("select * from `vik` where id='" . $ans . "';");
                            $vopr1 = mysql_fetch_array($vopr);
                            $answer = $vopr1[otvet];
                            if (!empty($msg) && !empty($answer) && $protv1[otv] != 1)
                            {
                                if (preg_match("/$answer/i", "$msg"))
                                {
                                    $itg = $datauser[otvetov] + 1;
                                    switch ($protv1[otv])
                                    {
                                        case "2":
                                            $pods = ", не используя подсказок";
                                            $bls = 5;
                                            break;
                                        case "3":
                                            $pods = ", используя одну подсказку";
                                            $bls = 3;
                                            break;
                                        case "4":
                                            $pods = ", используя две подсказки";
                                            $bls = 2;
                                            break;
                                    }
                                    $balans = $datauser[balans] + $bls;
                                    $otvtime = $realtime - $protv1[time];
                                    if ($datauser[sex] == "m")
                                    {
                                        $tx = "молодец! Ты угадал правильный ответ:  $answer за $otvtime секунд $pods ,и заработал $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                    } else
                                    {
                                        $tx = "молодец! Ты угадала правильный ответ:  $answer за $otvtime секунд $pods ,и заработала $bls баллов. Всего правильных ответов:<b>$itg</b>, твой игровой баланс $balans баллов.";
                                    }
                                    $mtim = $realtime + 1;
                                    mysql_query("INSERT INTO `chat` VALUES(
'0','" . $th . "','','m','" . $mtim . "','Умник','" . $login . "','', '" . $tx . "', '127.0.0.1', 'Nokia3310', '','');");
                                    mysql_query("update `chat` set otv='1' where id='" . $protv1[id] . "';");
                                    mysql_query("update `users` set otvetov='" . $itg . "',balans='" . $balans . "' where id='" . intval($_SESSION['pid']) . "';");
                                }
                            }
                        }

                        header("location: $home/chat/index.php?id=$th");
                    } else
                    {

                        require ("../incfiles/head.php");
                        require ("../incfiles/inc.php");
                        $user = mysql_query("select * from `users` where name='" . $type1[from] . "';");
                        $ruz = mysql_num_rows($user);
                        if ($ruz != 0)
                        {
                            $udat = mysql_fetch_array($user);
                            echo "<b><font color='" . $conik . "'>$type1[from]</font></b>";
                            echo " (id: $udat[id])";
                            $ontime = $udat[lastdate];
                            $ontime2 = $ontime + 300;
                            if ($realtime > $ontime2)
                            {
                                echo "<font color='" . $coffs . "'> [Off]</font><br/>";
                            } else
                            {
                                echo "<font color='" . $cons . "'> [ON]</font><br/>";
                            }
                            if ($udat[dayb] == $day && $udat[monthb] == $mon)
                            {
                                echo "<font color='" . $cdinf . "'>ИМЕНИННИК!!!</font><br/>";
                            }
                            switch ($udat[rights])
                            {
                                case 7:
                                    echo ' Админ ';
                                    break;
                                case 6:
                                    echo ' Супермодер ';
                                    break;
                                case 5:
                                    echo ' Зам. админа по библиотеке ';
                                    break;
                                case 4:
                                    echo ' Зам. админа по загрузкам ';
                                    break;
                                case 3:
                                    echo ' Модер форума ';
                                    break;
                                case 2:
                                    echo ' Модер чата ';
                                    break;
                                case 1:
                                    echo ' Киллер ';
                                    break;
                                default:
                                    echo ' юзер ';
                                    break;
                            }
                            echo "<br/>";
                            if (!empty($udat[status]))
                            {
                                $stats = $udat[status];
                                $stats = smiles($stats);
                                $stats = smilescat($stats);

                                $stats = smilesadm($stats);
                                echo "<font color='" . $cdinf . "'>$stats</font><br/>";
                            }

                            if ($udat['sex'] == "m")
                            {
                                echo "Парень<br/>";
                            }
                            if ($udat['sex'] == "zh")
                            {
                                echo "Девушка<br/>";
                            }
                            if (!empty($udat[balans]))
                            {
                                echo "Игровой баланс: $udat[balans] баллов<br/>";
                            }
                            if ($udat['ban'] == "1" && $udat['bantime'] > $realtime || $udat['ban'] == "2")
                            {
                                echo "<font color='" . $cdinf . "'>Бан!</font><br/>";
                            }
                            if (empty($udat[nastroy]))
                            {
                                $nstr = "без настроения";
                            } else
                            {
                                $nstr = $udat[nastroy];
                            }
                            echo "Настроение: $udat[nastroy]<br/>";
                        }
                        echo "Добавление сообщения в комнату <font color='" . $cntem . "'>$th1[text]</font> для <font color='" . $conik . "'>$type1[from]</font>(max. 500):<br/><form action='index.php?act=say&amp;id=" . $id . "' method='post'>";
                        echo "<textarea cols='40' rows='3' title='Введите ответ' name='msg'></textarea><br/>";
                        if ($offtr != 1)
                        {
                            echo "<input type='checkbox' name='msgtrans' value='1' /> Транслит сообщения
      <br/>";
                        }
                        echo "<select name='priv'>";
                        echo "<option value='0'>Всем</option>";
                        echo "<option value='1'>Приватно</option>";
                        echo "</select><br/>";
                        echo "Эмоции:<br/><select name='nas'>
<option value=''>Бeз эмoций</option>
<option value='[Paдocтнo] '>Paдocтнo</option>
<option value='[Пeчaльнo] '>Пeчaльнo</option>
<option value='[Удивлённo] '>Удивлённo</option>
<option value='[Лacкoвo] '>Лacкoвo</option>
<option value='[Смyщённo] '>Cмyщённo</option>
<option value='[Koкeтливo] '>Koкeтливo</option>
<option value='[Oбижeннo] '>Oбижeннo</option>
<option value='[Нacтoйчивo] '>Нacтойчивo</option>
<option value='[Шёпoтoм] '>Шёпoтoм</option>
<option value='[Агрессивно] '>Агрессивно</option>
<option value='[Шокированно] '>Шокированно</option>
<option value='[Огорченно] '>Огорченно</option>
<option value='[Издевательски] '>Издевательски</option>
<option value='[Испацтула] '>Испацтула</option>
<option value='[Нагло] '>Нагло</option>
<option value='[Испуганно] '>Испуганно</option>
<option value='[Злобно] '>Злобно</option>
<option value='[Улыбаясь] '>Улыбаясь</option>
<option value='[Подмигивая] '>Подмигивая</option>
<option value='[Удрученно] '>Удрученно</option>
<option value='[Устало] '>Устало</option>
<option value='[Задумчиво] '>Задумчиво</option>
<option value='[Откровенно] '>Откровенно</option>
</select><br/>";
                        echo "<input type='submit' title='Нажмите для отправки' name='submit' value='Отправить'/><br/></form>";
                        echo "<a href='index.php?act=trans'>Транслит</a><br/><a href='../str/smile.php'>Смайлы</a><br/>";
                        if ($ruz != 0)
                        {
                            echo "<br/><a href='../str/pradd.php?act=write&amp;adr=" . $udat[id] . "'>Написать в приват</a><br/>";

                            $nmen = array(1 => "Имя", "Город", "Инфа", "ICQ", "E-mail", "Мобила", "Дата рождения", "Сайт");
                            $nmen1 = array(1 => "imname", "live", "about", "icq", "mail", "mibila", "Дата рождения ", "www");
                            if (!empty($nmenu))
                            {
                                $nmenu1 = explode(",", $nmenu);
                                foreach ($nmenu1 as $v)
                                {

                                    if ($v != 7 && $v != 5 && $v != 8)
                                    {
                                        $dus = $nmen1[$v];
                                        if (!empty($udat[$dus]))
                                        {
                                            echo "$nmen[$v]: $udat[$dus]<br/>";
                                        }
                                    }

                                    if ($v == 5)
                                    {
                                        if (!empty($udat[mail]))
                                        {
                                            echo "$nmen[$v]: ";
                                            if ($udat[mailvis] == 1)
                                            {
                                                echo "$udat[mail]<br/>";
                                            } else
                                            {
                                                echo "скрыт<br/>";
                                            }
                                        }
                                    }
                                    if ($v == 8)
                                    {
                                        if (!empty($udat[www]))
                                        {
                                            $sit = str_replace("http://", "", $udat[www]);
                                            echo "$nmen[$v]: <a href='$udat[www]'>$sit</a><br/>";
                                        }
                                    }
                                    if ($v == 7)
                                    {
                                        if ((!empty($udat[dayb])) && (!empty($udat[monthb])))
                                        {
                                            $mnt = $udat[monthb];
                                            echo "$nmen[$v]: $udat[dayb] $mesyac[$mnt]<br/>";
                                        }
                                    }
                                }
                            }

                            echo "<a href='../str/anketa.php?user=" . $udat[id] . "'>Подробнее...</a><br/>";
                            if ($dostkmod == 1)
                            {
                                echo "<a href='../" . $admp . "/zaban.php?user=" . $udat[id] . "&amp;chat&amp;id=" . $id . "'>Банить</a><br/>";
                            } elseif ($dostcmod == 1)
                            {
                                echo "<a href='../" . $admp . "/zaban.php?user=" . $udat[id] . "&amp;chat&amp;id=" . $id . "'>Пнуть</a><br/>";
                            }

                            $contacts = mysql_query("select * from `privat` where me='" . $login . "' and cont='" . $udat[name] . "';");
                            $conts = mysql_num_rows($contacts);
                            if ($conts == 0)
                            {
                                echo "<a href='../str/cont.php?act=edit&amp;nik=" . $udat[name] . "&amp;add=1'>Добавить в контакты</a><br/>";
                            } else
                            {
                                echo "<a href='../str/cont.php?act=edit&amp;nik=" . $udat[name] . "'>Удалить из контактов</a><br/>";
                            }
                            $igns = mysql_query("select * from `privat` where me='" . $login . "' and ignor='" . $udat[name] . "';");
                            $ignss = mysql_num_rows($igns);
                            if ($ignss == 0)
                            {
                                echo "<a href='../str/ignor.php?act=edit&amp;nik=" . $udat[name] . "&amp;add=1'>Добавить в игнор</a><br/>";
                            } else
                            {
                                echo "<a href='../str/ignor.php?act=edit&amp;nik=" . $udat[name] . "'>Удалить из игнора</a><br/>";
                            }
                        }
                        echo "<a href='index.php?id=" . $type1[refid] . "'>Назад</a><br/>";
                    }
                    break;

                default:
                    require ("../incfiles/head.php");
                    require ("../incfiles/inc.php");
                    echo "Ошибка!<br/>&#187;<a href='?'>В чат</a><br/>";
                    break;
            }
            require ('chat_footer.php');
            break;

        case "chpas":
            $_SESSION['intim'] = "";
            header("location: $home/chat/index.php?id=$id");
            break;

        case "pass":
            $parol = check($_POST['parol']);
            $_SESSION['intim'] = $parol;
            mysql_query("update `users` set alls='" . $parol . "' where id='" . intval($_SESSION['pid']) . "';");
            header("location: $home/chat/index.php?id=$id");
            break;

        default:
            if (!empty($id))
            {
                // Отображаем комнату Чата
                require_once ('room.php');
            } else
            {
                // Отображаем прихожую Чата
                require_once ('hall.php');
            }
    }
} else
{
    require_once ("../incfiles/head.php");
    require_once ("../incfiles/inc.php");
    echo "Вы не авторизованы!<br/><a href='../in.php'>Вход</a><br/>";
    require_once ("../incfiles/end.php");
}

?>


