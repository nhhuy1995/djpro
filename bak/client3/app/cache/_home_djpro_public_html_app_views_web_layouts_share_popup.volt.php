<!-- form-chia-se-popup -->	
<div class="modal fade" id="embed-share-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-link"></i> Chia sẻ link</h4>
          </div>
          <div class="modal-body">
           
				<form class="cd-form"> 

					<p class="fieldset">
						<i class="fa fa-link"></i>
						<input class="full-width has-padding has-border" type="text"  value="<?php echo $currentLink; ?>" id='share-popup-full'>  
					</p>
					
					<?php if (empty($not_link_embed)) { ?>
					<p class="fieldset">
                        <i class="fa fa-file-code-o"></i>
						<input class="full-width has-padding has-border" type="text" id='share-popup-iframe' value="<iframe src=&quot;<?php echo $iframe_share_link; ?>&quot; width=&quot;316&quot; height=&quot;587&quot; frameborder=&quot;0&quot; allowfullscreen></iframe>">
					</p>
					<?php } ?>
          
					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Chia sẻ">
					</p>
				</form>

          </div>
      </div>
   </div>
</div>
<script type="text/javascript">
	$(function() {
		$('#share-popup-full, #share-popup-iframe').on('click', function(){
			$(this).select();
		})
	});
</script>
