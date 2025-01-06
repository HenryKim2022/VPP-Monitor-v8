@echo off
SETLOCAL

:MENU
cls
echo ================================
echo         PHP Path Manager
echo ================================
echo 1. Add PHP Path
echo 2. Remove PHP Path
echo 3. Check PHP Version
echo 4. Exit
echo ================================
set /p choice="Please select an option (1-4): "

IF "%choice%"=="1" GOTO ADD_PATH
IF "%choice%"=="2" GOTO REMOVE_PATH
IF "%choice%"=="3" GOTO CHECK_VERSION
IF "%choice%"=="4" GOTO EXIT
echo Invalid choice. Please try again.
pause
GOTO MENU

:ADD_PATH
cls
set /p PHP_PATH="Enter the full path to PHP (e.g., C:\path\to\php): "

REM Check if the PHP path is already in the system PATH
echo %PATH% | find /I "%PHP_PATH%" >nul
IF %ERRORLEVEL% EQU 0 (
    echo The PHP path is already in the system PATH.
) ELSE (
    REM Add the PHP path to the system PATH
    echo Adding %PHP_PATH% to the system PATH...
    setx PATH "%PATH%;%PHP_PATH%" /M
    echo %PHP_PATH% has been added to the system PATH.
)
pause
GOTO MENU

:REMOVE_PATH
cls
set /p PHP_PATH="Enter the full path to PHP you want to remove (e.g., C:\path\to\php): "

REM Check if the PHP path is in the system PATH
echo %PATH% | find /I "%PHP_PATH%" >nul
IF %ERRORLEVEL% NEQ 0 (
    echo The PHP path is not found in the system PATH.
) ELSE (
    REM Remove the PHP path from the system PATH
    echo Removing %PHP_PATH% from the system PATH...
    setx PATH "%PATH:;%PHP_PATH%=%" /M
    echo %PHP_PATH% has been removed from the system PATH.
)
pause
GOTO MENU

:CHECK_VERSION
cls
REM Check if PHP is in the PATH and get the version
php -v >nul 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo PHP is not installed or not found in the system PATH.
) ELSE (
    echo Checking PHP version...
    php -v
    echo.
)
pause
GOTO MENU

:EXIT
ENDLOCAL
exit