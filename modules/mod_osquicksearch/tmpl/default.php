<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if($module_position == 0){
	?>
	<style>
	.os_search{
		left:0px;
		right:0px;
	}
	</style>
	<?php
}elseif($module_position == 1){
	?>
	<style>
	.os_search{
		left:<?php echo $distance;?>px;
	}
	</style>
<?php
}elseif($module_position == 2){
	?>
	<style>
	.os_search{
		right:<?php echo $distance;?>px;
	}
	</style>
	<?php
}
$property_type = JRequest::getVar('property_types');
if(count($property_type) > 0){
	$selected_type = $property_type[0];
}
?>
<div class="os_search">
    <div class="os_search_inner">
        <div id="os_search_title">
            <span class="s1"><?php echo Jtext::_('OS_STOP_LOOKING');?>,</span> <span class="s2"><?php echo Jtext::_('OS_START_FINDING');?>.<sup>&reg;</sup></span>
        </div>
        <div class="os_search_main row-fluid">
            <!-- end left col 3 btn -->
            <div class="tabbable tabs-left">
            	<ul class="nav nav-tabs">
				<?php
				for($i=0;$i<count($types);$i++){
					if($selected_type > 0)
					{
						if($types[$i]->id == $selected_type)
						{
							$class = "active";
						}else{
							$class = "";
						}
					}
					elseif($i == 0)
					{
						$class = "active";
					}else{
						$class = "";
					}
					?>
					<li class="<?php echo $class;?>">
						<a href="#propertytype<?php echo $types[$i]->id;?>" data-toggle="tab">
							<?php echo OSPHelper::getLanguageFieldValue($types[$i],'type_name'); ?>
						</a>
					</li>
				
				<?php } ?></ul>
				<div class="tab-content">
					<?php
					$need = array();
					$need[] = "property_advsearch";
					$need[] = "ladvsearch";
					$itemid = OSPRoute::getItemid($need);
					for($i=0;$i<count($types);$i++){
						$type = $types[$i];
						if($selected_type > 0)
						{
							if($type->id == $selected_type)
							{
								$class = " active in";
							}else{
								$class = "";
							}
						}
						elseif($i == 0)
						{
							$class = " active in";
						}else{
							$class = "";
						}
						?>
		                <div class="tab-pane fade<?php echo $class; ?>" id="propertytype<?php echo $types[$i]->id;?>">
		                	<form action="<?php echo JRoute::_('index.php?option=com_osproperty&view=ladvsearch&Itemid='.$itemid);?>" method="post">
			              	     <div id="neighborhoodWrapper row-fluid">
			                         <div class="input-group">
			                             <div class="input-group-btn">
			                          	  	 <input type="text" name="keyword" id="keyword" placeholder="<?php echo Jtext::_('OS_LOCATION');?>" class="form-control" value="<?php echo JRequest::getVar('keyword','');?>" />
			                        	 </div><!-- /btn-group -->
			     					 </div>
								 </div>
				                 <div class="row-fluid">
				                      <div class="os_search_PropertyType input-group-btn span6">
				                      		<?php echo $lists['nroom'];?>
				                      </div>
				                      <div class="os_search_Beds input-group-btn span6">
				                      		<?php echo $lists['nbed'];?>
				                      		<?php echo $lists['nbath'];?>
				                      </div>
				                 </div>
				                 <div class="row-fluid" style="color:white;">
				                 	<div class="span8" style="text-align:left;">
				                 		<?php echo Jtext::_('OS_PRICE_RANGE');?>:
					                  	<div class="clearfix"></div> 
					                  	<?php
										OSPHelper::showPriceFilter($price,JRequest::getVar('min_price',0),JRequest::getVar('max_price',0),$type->id,'input-medium',"adv".$types[$i]->id);
										?>
				                 	</div>
				                  	<div class="span4 submit_button">
				                  		<input type="submit" class="btn btn-inverse" value="Search" />
				                  		<input type="reset" class="btn" value="Reset" />
				                  	</div>
			                 	 </div>
			                 	 <input type="hidden" name="option" value="com_osproperty" />
			                 	 <input type="hidden" name="task" value="property_advsearch" />
			                 	 <input type="hidden" name="property_types[]" value="<?php echo $type->id;?>" />
			                 	 <input type="hidden" name="adv_type" id="adv_type" value="<?php echo $type->id;?>" />
			                 	 </form>
			                </div>
			         <?php } ?>
	            </div>
            </div>
        </div>
    </div>
</div>
