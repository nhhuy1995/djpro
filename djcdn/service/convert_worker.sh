#! /bin/bash

python_path=/usr/bin/python2.6
worker=convert_worker.py
prog=convert_worker.sh
document_root=/home/s2.download.stream.djscdn.com/public_html/service
document_root_logs=/home/s2.download.stream.djscdn.com/public_html/
num_prog=1
date=`date +"%Y-%m-%d"`
log_file=$document_root_logs/logs/convert_audio_quality-$date.log

#Start process
start() {
	echo "Starting $prog"
    nohup  $python_path -u $document_root/$worker -v >> $log_file 2>&1 &
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