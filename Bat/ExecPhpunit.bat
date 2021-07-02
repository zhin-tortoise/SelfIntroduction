REM mysqlのテスト
php C:/php/phpunit.phar Backend/Test/TestMysqlRepository.php

REM ユーザーのテスト
php C:/php/phpunit.phar Backend/Test/TestUserEntity.php
php C:/php/phpunit.phar Backend/Test/TestUserRepository.php
php C:/php/phpunit.phar Backend/Test/TestUserApplication.php

REM 転職事由のテスト
php C:/php/phpunit.phar Backend/Test/TestJobChangeEntity.php
php C:/php/phpunit.phar Backend/Test/TestJobChangeRepository.php
php C:/php/phpunit.phar Backend/Test/TestJobChangeApplication.php