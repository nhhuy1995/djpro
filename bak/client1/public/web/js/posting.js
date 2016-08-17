function select_file(){
    document.getElementById('audioFile').click();
    $('#audioFile').change(function() {
        var filename = $('#audioFile').val();
        $('#upload-tip b').html(filename);
        $('#upload-tip,#upload-btn').fadeIn(200);
    });
}

function uploadBanner(id){
    var preview = $('#preview');
	var percent = $('.percent');
    var progress = $('.progress');
	var bar = $('.bar');
    var urlAction = base_url+'upload/upload.php';
    
    $('#isEdit').val(0);
    document.getElementById('upload-form').action = urlAction+'?id='+id;
    
    $('#upload-form').ajaxForm({
		dataType:'json',
		beforeSend: function() {
			$('.status').fadeOut();
			bar.width('0%');
			percent.html('0%');
		},

		uploadProgress: function(event, position, total, percentComplete) {
			var pVel = percentComplete + '%';
			bar.width(pVel);
			percent.html(pVel);
            progress.show();
		},

		complete: function(data) {
			preview.fadeOut(800);
			$('.status p').html(data.responseJSON.status);
            if(data.responseJSON.ok==0) $('.status').removeClass('alert-info').addClass('alert-danger');
            else { $('.status').removeClass('alert-danger').addClass('alert-info'); $('#status-btn-'+id).show(); $('#upload-btn-'+id).hide(); $('#banner-name'+id).val(data.responseJSON.imageName) }
            $('.status').fadeIn();
		}

	});
}

function saveBanner(){
    if($('#isEdit').val()!=1){
        var bannerStr=''; j=0;    
        $('.banner-name').each(function(index, value) {
            if($('#chk_size_'+$(this).attr('banner-id')).is(':checked')==false){
                if($(this).val()==0) j++;
                else bannerStr+=$(this).attr('banner-id')+'-'+$(this).val()+',';
            }
        });
        if(j>0) { alert('You must upload all banner !'); return false; }
        else {
            
            if($('.checkEmbed').length>0 && $('.checkEmbed:checked').length == $('.checkEmbed').length){
                $('#submit-form').submit();
            }
            else { $('#submit-form').submit(); }
        }
    }
    else $('#submit-form').submit();
}

function showTab(id){
    $('.horizontal .tab li a').removeClass('active');
    $('#'+id+'-tab').addClass('active');
    $('.upload-method').hide();
    $('#'+id).show();    
}

function haveLink(isHave){
    $('.link-quest').css('margin-top','6px');
    if(isHave==1) { $('#link-tip').fadeIn(200); $('#upload-area').fadeOut(200); }
    else {$('#upload-area').fadeIn(200); $('#link-tip').fadeOut(200); }
}

$(document).ready(function($){
    showTab('djpro');
    
    $(".supercom-form").validationEngine({
        inlineValidation: false,
        success :  false,
        failure : function() { callFailFunction()  }
    });
});

var $filequeue,
	$filelist;

$(document).ready(function() {
	$filequeue = $(".filelist.queue");
	$filelist = $(".filelist.complete");

	$(".dropped").dropper({
		action: "/file/upload",
        label: 'Kéo thả file nhạc vào đây hoặc click để chọn !',
        maxQueue: 1,
		maxSize: 40048576
	}).on("start.dropper", onStart)
	  .on("complete.dropper", onComplete)
	  .on("fileStart.dropper", onFileStart)
	  .on("fileProgress.dropper", onFileProgress)
	  .on("fileComplete.dropper", onFileComplete)
	  .on("fileError.dropper", onFileError);

	$(window).one("pronto.load", function() {
		$(".dropped").dropper("destroy").off(".dropper");
	});
});

function onStart(e, files) {
	console.log("Start");
    $('.queue-list').show();
	var html = '';

	for (var i = 0; i < files.length; i++) {
		html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><span class="progress">Queued</span></li>';
	}

	$filequeue.append(html);
}

function onComplete(e) {
	console.log("Complete");
	// All done!
}

function onFileStart(e, file) {
	console.log("File Start");

	$filequeue.find("li[data-index=" + file.index + "]")
			  .find(".progress").text("0%");
}

function onFileProgress(e, file, percent) {
	console.log("File Progress");

	$filequeue.find("li[data-index=" + file.index + "]")
			  .find(".progress").text(percent + "%");
}

function onFileComplete(e, file, response) {
	console.log("File Complete");
    $('.complete-list').show();

	if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
		$filequeue.find("li[data-index=" + file.index + "]").addClass("error")
				  .find(".progress").text(response.trim());
	} else {
		var $target = $filequeue.find("li[data-index=" + file.index + "]");

		$target.find(".file").text(file.name);
		$target.find(".progress").remove();
		$target.appendTo($filelist);
	}
}

function onFileError(e, file, error) {
	console.log("File Error");

	$filequeue.find("li[data-index=" + file.index + "]").addClass("error")
			  .find(".progress").text("Error: " + error);
}