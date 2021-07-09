REM 実行環境へのデプロイを行うバッチ。

set PICTURE_PATH=D:\Apache24\htdocs\Picture
if not exist %PICTURE_PATH% mkdir %PICTURE_PATH%
copy .\Picture\* %PICTURE_PATH%

set API_PATH=D:\Apache24\htdocs\Backend\Api
if not exist %API_PATH% mkdir %API_PATH%
copy .\Backend\Api\* %API_PATH%

set APPLICATION_PATH=D:\Apache24\htdocs\Backend\Application
if not exist %APPLICATION_PATH% mkdir %APPLICATION_PATH%
copy .\Backend\Application\* %APPLICATION_PATH%

set DOMAIN_PATH=D:\Apache24\htdocs\Backend\Domain
if not exist %DOMAIN_PATH% mkdir %DOMAIN_PATH%
copy .\Backend\Domain\* %DOMAIN_PATH%

set REPOSITORY_PATH=D:\Apache24\htdocs\Backend\Repository
if not exist %REPOSITORY_PATH% mkdir %REPOSITORY_PATH%
copy .\Backend\Repository\* %REPOSITORY_PATH%

set JS_LIBRARY_PATH=D:\Apache24\htdocs\Frontend\Library
if not exist %JS_LIBRARY_PATH% mkdir %JS_LIBRARY_PATH%
copy .\Frontend\Library\* %JS_LIBRARY_PATH%

set SELFINTRODUCTION_PATH=D:\Apache24\htdocs\Frontend\SelfIntroduction
if not exist %SELFINTRODUCTION_PATH% mkdir %SELFINTRODUCTION_PATH%
copy .\Frontend\SelfIntroduction\* %SELFINTRODUCTION_PATH%

set SELFINTRODUCTION_CSS_PATH=D:\Apache24\htdocs\Frontend\SelfIntroduction\Css
if not exist %SELFINTRODUCTION_CSS_PATH% mkdir %SELFINTRODUCTION_CSS_PATH%
copy .\Frontend\SelfIntroduction\Css\* %SELFINTRODUCTION_CSS_PATH%

set SELFINTRODUCTION_JS_PATH=D:\Apache24\htdocs\Frontend\SelfIntroduction\Js
if not exist %SELFINTRODUCTION_JS_PATH% mkdir %SELFINTRODUCTION_JS_PATH%
copy .\Frontend\SelfIntroduction\Js\* %SELFINTRODUCTION_JS_PATH%