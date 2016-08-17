#! /bin/bash

php_path=/usr/bin/php
pnp_ini_path=/etc/php.ini
worker=ConvertWorker.php
prog=convert_worker.sh
document_root=/home/cms/public_html/app/service/
num_prog=1
date=`date +"%Y-%m-%d"`
log_file=$document_root/logs/convert_audio_quality-$date.log

#Start process
start() {
	echo "Starting $prog"
    nohup  $php_path -c $pnp_ini_path  $document_root/$worker -v >> $log_file 2>&1 &
}

# Stop all process
stop() {
	echo "Stopping $prog"
	ps -ef | grep "$document_root/$worker" | grep -v grep | awk '{print$2}' | xargs kill -9
}
# Detect process
detect() {
	current_num_prog=`ps -ef | grep -v grep | grep -c "$document_root/$worker"`
	if [ "$current_num_prog" -lt "$num_prog" ]; then
		let new_prog=$num_prog-$current_num_prog
		i=1
		while [ $i -le $new_prog ]; do
			start
			let i++
		done
	fi
}
case "$1" in
	"start" )
           start
           ;;
	"stop" )
	   stop
           ;;
	"restart" )
	   stop
	   detect
           ;;
	"detect" )
           detect
           ;;
     	* )
           echo "Usage: $prog {start|stop|restart|detect)"
           exit 1
esac
#usleep 500
ps -ef | grep -v grep | grep "$document_root/$worker"
exit 0
