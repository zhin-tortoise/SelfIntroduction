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

REM 経歴のテスト
php C:/php/phpunit.phar Backend/Test/TestCareerEntity.php
php C:/php/phpunit.phar Backend/Test/TestCareerRepository.php
php C:/php/phpunit.phar Backend/Test/TestCareerApplication.php

REM 書籍のテスト
php C:/php/phpunit.phar Backend/Test/TestBookEntity.php
php C:/php/phpunit.phar Backend/Test/TestBookRepository.php
php C:/php/phpunit.phar Backend/Test/TestBookApplication.php

REM 管理者のテスト
php C:/php/phpunit.phar Backend/Test/TestAdminEntity.php
php C:/php/phpunit.phar Backend/Test/TestAdminRepository.php
php C:/php/phpunit.phar Backend/Test/TestAdminApplication.php