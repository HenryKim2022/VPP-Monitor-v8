@echo off
setlocal enabledelayedexpansion

:: Set default values
set "logPath=."
set "logFile=output.log"

:: Function to find Cronical.exe
:findCronical
set "searchDir=..\..\..\bin\cronical\"  :: Change this to the directory you want to search in
set "cronicalPath="

echo Searching for Cronical.exe in %searchDir% and its subdirectories...
for /r "%searchDir%" %%F in (Cronical.exe) do (
    set "cronicalPath=%%F"
    echo Found Cronical.exe at: !cronicalPath!
    goto :found
)

echo Cronical.exe not found in %searchDir%.
goto :menu

:found
:menu
cls
echo ================================
echo        Cronical Launcher
echo ================================
echo Current Settings:
echo Cronical Path: !cronicalPath!
echo Log Path: !logPath!
echo Log File: !logFile!
echo ================================
echo 1. Set Cronical Path Manually
echo 2. Set Log Path
echo 3. Set Log File
echo 4. Launch Cronical
echo 5. Exit
echo ================================
set /p choice="Choose an option (1-5): "

if "%choice%"=="1" (
    set /p cronicalPath="Enter the path to Cronical.exe: "
    echo Cronical path set to: !cronicalPath!
    pause
    goto menu
)

if "%choice%"=="2" (
    set /p logPath="Enter the log path: "
    echo Log path set to: !logPath!
    pause
    goto menu
)

if "%choice%"=="3" (
    set /p logFile="Enter the log file name: "
    echo Log file set to: !logFile!
    pause
    goto menu
)

if "%choice%"=="4" (
    echo Launching Cronical...
    cls
    if exist "!cronicalPath!" (
        echo Executing: "!cronicalPath!" --console --debug > "!logPath!\!logFile!" 2>&1
        "!cronicalPath!" --console --debug > "!logPath!\!logFile!" 2>&1
        echo Cronical has been launched. Check the log at "!logPath!\!logFile!"
    ) else (
        echo Error: Cronical executable not found at "!cronicalPath!".
    )
    pause
    goto menu
)

if "%choice%"=="5" (
    echo Exiting...
    exit /b
)

echo Invalid choice. Please try again.
pause
goto menu
