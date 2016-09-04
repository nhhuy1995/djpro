#! /bin/bash
python_path=/usr/local/bin/python2.7
worker=upload_worker.py
prog=upload_worker.sh
document_root=/home/djcdn/public_html/service/Worker
document_root_logs=/home/djcdn/public_html
num_prog=1
date=`date +"%Y-%m-%d"`
log_file=$document_root_logs/logs/upload_worker-$date.log

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
	# echo "Current $num_prog"
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