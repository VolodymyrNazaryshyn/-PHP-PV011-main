<div class="wrapper">
    <h2>Робота с базами данных</h2>
    <main>
        <h3>Настройка СУБД</h3>
        <p>
            При работе с БД обычно на хостинге выдается
            логин/пароль и готовая БД. Поэтому, и для локальных
            сайтов желательно создать отдельного пользователя
            и отдельную БД для каждого из сайтов.
        </p>
        <p>
            Подключаемся к СУБД:<br/>
            <b>а)</b> через консоль (терминал)<br/>
            <b>б)</b> phpmyadmin (http://localhost/phpmyadmin)<br/>
            <b>в)</b> стороннее ПО для БД: MySQL Workbench, DBeaver, ...<br/>
            <br/>
            (дальше на примере терминала)
            <br/>
            <pre>
            Запускаем терминал (кнопкой Shell на панели XAMPP / cmd)
            Переходим в папку 
            > cd mysql/bin
            Запускаем консоль БД
            > mysql -u root         (если нет пароля - новая установка)
            > mysql -u root -p      (если пароль установлен)
            -- попадаем в СУБД-клиент (консоль)
            Создаем БД для сайта (pv011)
            >> CREATE DATABASE pv011;
            Создаем пользователя и даем ему доступ к новой БД
            (логин - pv011_user, пароль - pv011_pass)
            >> GRANT ALL PRIVILEGES ON pv011.* 
               TO pv011_user@localhost 
               IDENTIFIED BY 'pv011_pass';
            Проверяем: выходим из консоли
            >> exit
            Опять Запускаем консоль, только от имени нового пользователя
            > mysql -u pv011_user -p
            password: (вводим) pv011_pass
            Если вход успешный - пользователь создан, пароль корректный
            Проверяем видимость БД
            >> SHOW DATABASES;
            +--------------------+
            | Database           |
            +--------------------+
            | information_schema |
            | pv011              | (признак видимости БД)
            | test               |
            +--------------------+
            </pre>
        </p>
        <h3>Подключение к БД из PHP</h3>
        <p>
            Для работы с БД в PHP есть несколько вариантов:<br/>
            -- набор команд для конкретной БД (mysql_... ib_...)<br/>
            -- или более современный инструмент - PDO (аналог ADO .NET)<br/>
        </p>
        <p>Подключение:
        <?php 
        try {
            $connection = new PDO( 
                "mysql:host=localhost;port=3306;dbname=pv011;charset=utf8",
                "pv011_user", "pv011_pass", [
                   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                   PDO::ATTR_PERSISTENT => true
                ] ) ;
            echo "Connection OK" ;
        } 
        catch( PDOException $ex ) {
           echo $ex->getMessage() ;
        }
        ?>
        </p>
        <p>
            Выполнение запросов. DDL.
            Data Definition Language - язык "разметки" данных, создание баз,
            таблиц и т.п.
            <pre>
            <b>Особенности MySQL:</b>
             💠 нет отдельного типа для UUID, (но есть функции-генераторы)
              используем CHAR(36)
             💠 нет N-типов (Юникод), кодировка текстовых полей задается
              CHARSET-ом для таблицы в целом (либо для каждого поля отдельно)
             💠 есть несколько "движков" в рамках MySQL (MyISAM, InnoDB, ...)
             наличие условий IF EXISTS / IF NOT EXISTS позволяющих
             выполнять команду условно
            </pre>
            Результат запроса:
            <?php
            $sql = <<<SQL
                CREATE TABLE IF NOT EXISTS  demo (
                    id      CHAR(36)   NOT NULL   PRIMARY KEY,
                    var_int INT,
                    val_str VARCHAR(128)
                ) Engine = InnoDB, DEFAULT CHARSET = utf8
            SQL;
            try {
                $connection->query( $sql ) ;
                echo "Table 'demo' OK" ;
            }
            catch( PDOException $ex ) {
                echo $ex->getMessage() ;
            }
            ?>
        </p>
        <p>
            DML - язык манипулирования данными
            <?php
            $x = random_int(1000, 10000) ; 
            $s = bin2hex( random_bytes(8) ) ;
            $sql = "INSERT INTO demo VALUES( UUID(), $x, '$s' ) " ;
            try {
                $connection->query( $sql ) ;
                echo "INSERT OK" ;
            }
            catch( PDOException $ex ) {
                echo $ex->getMessage() ;
            }
            ?>
        </p>
        <p>
            DML. SELECT<br/>
            <?php
            $sql = "SELECT * FROM `demo` " ; // ``(MySQL) - аналог [] (MS SQL)
            try {
                $res = $connection->query( $sql ) ; // ~table (таблица рез-тов)
                while( $row = $res->fetch( PDO::FETCH_ASSOC ) ) { // строка таблицы
                    // print_r( $row ); // данные дублируются - по индексу и по имени
                    echo "{$row['id']} {$row['val_str']} <br/>" ;
                } // PDO::FETCH_ASSOC - только с именами, 
                  // PDO::FETCH_NUM - только с индексами,
                  // PDO::FETCH_BOTH - дублирование (по умолчанию)
            }
            catch( PDOException $ex ) {
                echo $ex->getMessage() ;
            }
            ?>
        </p>
        
        <!-- 
        Д.З. Реализовать запрос к БД на выдачу данных
        отобразить данные в виде таблицы (HTML)
        ** предполагать, что количество и названия полей заранее не известны
        +--------------------------------------+---------+------------------+
        | id                                   | var_int | val_str          |
        +--------------------------------------+---------+------------------+
        | 4100e2d4-676d-11ed-9c3a-3c7c3fbb1a48 |    6546 | d73cabc610249b7f |
        | 50fe5bf3-676d-11ed-9c3a-3c7c3fbb1a48 |    6505 | 665b32b2398e36aa |
        | 51bdd02d-676d-11ed-9c3a-3c7c3fbb1a48 |    4214 | e774c1969553c5ff |
        +--------------------------------------+---------+------------------+ 
        -->

    </main>
</div>
