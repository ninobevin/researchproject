@echo off
echo Backing up database..
echo mysqldump -u root mergesms > %date:~0,2%%date:~3,2%%date:~7,4%%time:~0,2%%time:~3,2%%time:~6,2%%time:~9,2%-sm.sql
echo mysqldump -u root mergeloadwallet> %date:~0,2%%date:~3,2%%date:~7,4%%time:~0,2%%time:~3,2%%time:~6,2%%time:~9,2%-load.sql
Done!!!
pause