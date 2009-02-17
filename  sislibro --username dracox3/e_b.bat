set PGPASSWORD=1234
c:\Archiv~1\Postgr~1\8.2\bin\pg_dump.exe -i -h localhost -p 5432 -U postgres -F c -b -D -v -f "D:\Servidor\www\backups\back-data.backup" sislibro

set FECHA=%DATE% %TIME%
set FECHA=%FECHA:/=%
set FECHA=%FECHA::=-%
set FECHA=%FECHA:.=-%
ren D:\Servidor\www\backups\back-data.backup  "%FECHA%".backup
