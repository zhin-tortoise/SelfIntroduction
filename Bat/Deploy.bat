REM 実行環境へのデプロイを行うバッチ。

set APPLICATION_PATH=D:\Apache24\htdocs\Backend\Application
if not exist %APPLICATION_PATH% mkdir %APPLICATION_PATH%
copy .\Backend\Application\* %APPLICATION_PATH%

set DOMAIN_PATH=D:\Apache24\htdocs\Backend\Domain
if not exist %DOMAIN_PATH% mkdir %DOMAIN_PATH%
copy .\Backend\Domain\* %DOMAIN_PATH%

set REPOSITORY_PATH=D:\Apache24\htdocs\Backend\Repository
if not exist %REPOSITORY_PATH% mkdir %REPOSITORY_PATH%
copy .\Backend\Repository\* %REPOSITORY_PATH%