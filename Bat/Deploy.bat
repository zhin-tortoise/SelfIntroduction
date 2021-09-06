REM 実行環境へのデプロイを行うバッチ。

set PICTURE_PATH=D:\Apache24\htdocs\selfIntroduction\Picture
if not exist %PICTURE_PATH% mkdir %PICTURE_PATH%
copy .\Picture\* %PICTURE_PATH%

set API_PATH=D:\Apache24\htdocs\selfIntroduction\Backend\Api
if not exist %API_PATH% mkdir %API_PATH%
copy .\Backend\Api\* %API_PATH%

set APPLICATION_PATH=D:\Apache24\htdocs\selfIntroduction\Backend\Application
if not exist %APPLICATION_PATH% mkdir %APPLICATION_PATH%
copy .\Backend\Application\* %APPLICATION_PATH%

set DOMAIN_PATH=D:\Apache24\htdocs\selfIntroduction\Backend\Domain
if not exist %DOMAIN_PATH% mkdir %DOMAIN_PATH%
copy .\Backend\Domain\* %DOMAIN_PATH%

set REPOSITORY_PATH=D:\Apache24\htdocs\selfIntroduction\Backend\Repository
if not exist %REPOSITORY_PATH% mkdir %REPOSITORY_PATH%
copy .\Backend\Repository\* %REPOSITORY_PATH%

set JS_LIBRARY_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\Library
if not exist %JS_LIBRARY_PATH% mkdir %JS_LIBRARY_PATH%
copy .\Frontend\Library\* %JS_LIBRARY_PATH%

set SELFINTRODUCTION_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\SelfIntroduction
if not exist %SELFINTRODUCTION_PATH% mkdir %SELFINTRODUCTION_PATH%
copy .\Frontend\SelfIntroduction\* %SELFINTRODUCTION_PATH%

set SELFINTRODUCTION_CSS_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\SelfIntroduction\Css
if not exist %SELFINTRODUCTION_CSS_PATH% mkdir %SELFINTRODUCTION_CSS_PATH%
copy .\Frontend\SelfIntroduction\Css\* %SELFINTRODUCTION_CSS_PATH%

set SELFINTRODUCTION_JS_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\SelfIntroduction\Js
if not exist %SELFINTRODUCTION_JS_PATH% mkdir %SELFINTRODUCTION_JS_PATH%
copy .\Frontend\SelfIntroduction\Js\* %SELFINTRODUCTION_JS_PATH%

set MANAGEMENT_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\Management
if not exist %MANAGEMENT_PATH% mkdir %MANAGEMENT_PATH%
copy .\Frontend\Management\* %MANAGEMENT_PATH%

set MANAGEMENT_CSS_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\Management\Css
if not exist %MANAGEMENT_CSS_PATH% mkdir %MANAGEMENT_CSS_PATH%
copy .\Frontend\Management\Css\* %MANAGEMENT_CSS_PATH%

set MANAGEMENT_JS_PATH=D:\Apache24\htdocs\selfIntroduction\Frontend\Management\JS
if not exist %MANAGEMENT_JS_PATH% mkdir %MANAGEMENT_JS_PATH%
copy .\Frontend\Management\Js\* %MANAGEMENT_JS_PATH%