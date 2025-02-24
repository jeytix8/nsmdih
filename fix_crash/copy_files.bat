@echo off
set "source=C:\xampp\mysql\backup"
set "destination=C:\xampp\mysql\data"
set "exclude=ibdata1"

echo Copying files from %source% to %destination%...

:: Loop through files in the source directory
for %%F in (%source%\*) do (
    if /I not "%%~nxF"=="%exclude%" (
        copy /Y "%%F" "%destination%"
        echo Copied: %%~nxF
    )
)

echo Copy completed!
pause
