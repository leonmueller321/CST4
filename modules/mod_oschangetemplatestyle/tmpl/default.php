<div style="direction: ltr; right: -331px;" id="cpanel_wrapper">
	<form action="<?php echo JFactory::getURI()->toString()?>" method="post">
		<div class="cpanel-head">Template Settings</div>
	    <div class="cpanel-theme-color">
	    	<span class="theme-color-heading">Select color sample for all params</span>
	        <div class="inner clearfix">
	        	<?php 
	        		foreach ($ThemOSptravel->getTheme() as $theme) {
	        			echo '<span class="theme-color '.$theme.'" title="'.$theme.'">'.$theme.'</span>';
	        		}
	        	?>
	        </div>
	        <span class="theme-color-heading">Select Layout</span>
	        <div>
	        	<?php $ThemOSptravel->getMainlayout();?>
	        </div>
	    </div>
	    
	    <!-- Action button -->
	    <div class="action">
	    	<input id="yt_button_cpanel" class="btn btn-info" type="button" onclick="javascript: this.form.submit();" value="Apply" class="button" />
	    	<a href="<?php echo JFactory::getURI()->toString()?>" class="btn btn-info reset">Reset</a>
	    </div>
	    <input type="hidden" name="theme" id="os_theme" value="">
    </form>
    <div class="normal" id="cpanel_btn">
        <i class="icon-hand-left"></i>
    </div>
</div>