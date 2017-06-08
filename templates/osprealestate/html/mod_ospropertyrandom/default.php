<?php
/*------------------------------------------------------------------------
# default.php - mod_ospropertyrandom
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
if($bstyle == "white"){
	$color = "#DDD";
}else{
	$color = "#444";
}
	
//}else{
$db = JFactory::getDbo();
?>
<div class="row-fluid">
<?php 
foreach ($properties as $property) {
$itemid = modOSpropertyramdomHelper::getItemid($property->id);
if($style == 1){
	$float = "float:left;";
}else{
	$float = "";
}
?>

	<?php 
	if($style == 0){ //vertical
	?>	
		<div class="element_property" style="width:<?php echo $element_width?>px;<?php echo $float?>;height:<?php echo $element_height?>px;overflow:hidden;">
			<?php
			if($show_photo == 1){
			?>
			<div class="property-mask property-image col-xs-5 col-sm-5  col-md-5">
                   <div class="grid cs-style-3 ">
                       <figure class="pimage">
							<?php if ($property->photo != ''){?>
								<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
									<?php
									OSPHelper::showPropertyPhoto($property->photo,'thumb',$property->id,'width:'.$width.'px;','img-polaroid','');
									?>
								</a>
							<?php }else {?>
								<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
									<img width="<?php echo $width?>" alt="<?php echo $property->pro_name?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/nopropertyphoto.png" class="img-polaroid" >
								
								</a>
							<?php }?>
							
									<figcaption>
									   <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>"><i class="fa fa-link fa-lg"></i></a>
									</figcaption>
									   <h4 class="os-featured"><?php 
											if($property->isFeatured == 1){
												?>
												<?php echo JText::_('OS_FEATURED')?>
												<?php 
											}
											?>
										</h4>
									   <h4> <a rel="tag" href="#"><?php echo $property->type_name;?></a></h4>
						</figure>
                   </div>
          	</div>
			<?php
			}
			?>
			<div class="property-desc col-xs-7 col-sm-7  col-md-7">
				<h5 style="margin: 0px;">
					<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>">
						<?php
						if($property->ref != ""){
							echo $property->ref.", ";
						}
						?>
						<?php 
						$arr_title_word = explode(' ',$property->pro_name);
						if (!$limit_title_word || $limit_title_word > count($arr_title_word)){
							echo $property->pro_name;
						}else {
							$tmp_title = array();
							for ($i=0; $i < $limit_title_word;$i++){
								$tmp_title[] = $arr_title_word[$i];
								if ($i > 2*count($arr_title_word)/3 && stristr($arr_title_word[$i],'.')) break;
							}	
							echo implode(' ',$tmp_title);	
							echo "...";				
						}
						
						?>
					</a>
					
				</h5>
				<?php
				$arr_desc = array();
					if ($show_price ) {
						$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'general_currency_default'");
						$curr = $db->loadResult();
						//$price = "<font class='price_label'>".JText::_('OSPROPERTY_PRICE').": </font>";
						echo "<font class='price_label'>".$property->price_information."</font>";
						echo "<BR />";
						//$arr_desc = array_merge($arr_desc,explode(' ',strip_tags($price.'.')));
					}
					if($show_category == 1){
						$link = JRoute::_('index.php?option=com_osproperty&task=category_details&id='.$property->catid.'&Itemid='.$itemid);
						echo "<font class='category_label'>".JText::_('OSPROPERTY_CATEGORY').": </font>";
						echo "<a href='$link'>";
						echo $property->category_name;
						echo "</a>";
						echo "<BR />";
					}
					if($show_type == 1){
						$link = JRoute::_('index.php?option=com_osproperty&view=ltype&type_id='.$property->typeid.'&Itemid='.$itemid);
						echo "<font class='propertytype_label'>".JText::_('OSPROPERTY_TYPE').": </font>";
						echo "<a href='$link'>";
						echo $property->type_name;
						echo "</a>";
						echo "<BR />";
					}
					
				
					
				?>
			
			</div>	
				<div class="description_property1 col-xs-12 col-sm-12  col-md-12" style="padding: 0px;">					
					<?php
					if($property->isSold == 1){
						?>
						<strong><?php echo JText::_('OS_SOLD')?></strong> <?php echo JText::_('OS_ON');?>: <?php echo $property->soldOn;?>
						<BR />
						<?php
					}
					if ($show_address ) {
						if($property->show_address == 1){
							//$arr_desc = array_merge($arr_desc,explode(' ',strip_tags($property->address.'.')));
							echo "<span class='address_value".$bstyle."'>";
							echo OSPHelper::generateAddress($property);
							echo "</span>";
							echo "<BR>";
						}
					}	
					$addtionalArr = array();
				if($show_bedrooms == 1){
					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_BEDROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/bedroom.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->bed_room</td></tr></table>";
					//$addtionalArr[] = $temp;
					echo "<font class='bedroom_label'>".JText::_('OSPROPERTY_BEDROOMS').": </font>";
					echo $property->bed_room;

				}
				if($show_bathrooms == 1){

					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_BATHROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/bathroom.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->bath_room</td></tr></table>";
					//$addtionalArr[] = $temp;
					echo "&nbsp;<font class='bedroom_label'>".JText::_('OSPROPERTY_BATHROOMS').": </font>";
					echo OSPHelper::showBath($property->bath_room);
				
				}
				if($show_rooms  == 1){
					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_ROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/room.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->rooms</td></tr></table>";
					//$addtionalArr[] = $temp;
					echo "&nbsp;<font class='bedroom_label'>".JText::_('OSPROPERTY_ROOMS').": </font>";
					echo $property->rooms;
					echo "<BR />";
				}
					if ($show_small_desc == 1){
						//$arr_desc = array_merge($arr_desc,explode(' ',strip_tags($property->pro_small_desc)));
						$small_desc = $property->pro_small_desc;
						$small_descArr = explode(" ",$small_desc);
						$count_small_desc = count($small_descArr);
						echo "<span class='desc_module".$bstyle."'>";	
						if($count_small_desc > $limit_word){
							for($i=0;$i<$limit_word;$i++){
								echo $small_descArr[$i];
							}
							echo "...";
						}else{
							echo $small_desc;
						}
						echo "</span><BR/>";
					}
					
				?>
				</div>	
				<div class="clearfix"></div>	
			
        </div>
		<?php 	
		}else{ //horizontal
		?>
		<div class="element_property1" style="width:<?php echo $element_width?>px;<?php echo $float?>;padding:2px;margin:2px;height:<?php echo $element_height?>px;overflow:hidden;">
			<?php
			if($show_photo == 1){
			?>
			<div class="property-mask property-image">
            	 <div class="grid cs-style-3 ">
                    <figure class="pimage">
				<?php if ($property->photo != ''){?>
					<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>">
						<?php
						
							OSPHelper::showPropertyPhoto($property->photo,'medium',$property->id,'width:'.$width.'px;','property-thumb img-polaroid','');
						?>
					</a>	
				<?php }else {?>
					<img width="<?php echo $width?>" alt="<?php echo $property->pro_name?>" src="<?php echo JURI::root()?>components/com_osproperty/images/assets/nopropertyphoto.png" />
				<?php }?>
			 <figcaption>
                        <a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>" title="<?php echo JText::_('OSPROPERTY_MOREDETAILS');?>"><i class="fa fa-link fa-lg"></i></a>
                        </figcaption>
                        <h4> <a rel="tag" href="#"><?php echo $property->type_name;?></h4>
                    </figure>
               </div>
           </div>
			<?php
			}
			?>
			<div class="name_property">
				<span>
					<a href="<?php echo JRoute::_('index.php?option=com_osproperty&task=property_details&id='.$property->id.'&Itemid='.$itemid)?>">
						<?php
						if($property->ref != ""){
							echo $property->ref.", ";
						}
						?>
						<?php
						$arr_title_word = explode(' ',$property->pro_name);
						if (!$limit_title_word || $limit_title_word > count($arr_title_word)){
							echo $property->pro_name;
						}else {
							$tmp_title = array();
							for ($i=0; $i < $limit_title_word;$i++){
								$tmp_title[] = $arr_title_word[$i];
								if ($i > 2*count($arr_title_word)/3 && stristr($arr_title_word[$i],'.')) break;
							}	
							echo implode(' ',$tmp_title)."...";					
						}	
						?>
					</a>
					<?php 
					if($property->isFeatured == 1){
						?>
						<span class="label label-important randompropertyfeatured"><strong><?php echo JText::_('OS_FEATURED')?></strong></span>
						<?php 
					}
					?>
				</span>
			</div>
			
			<div class="description_property1">					
				<?php
				if($property->isSold == 1){
					?>
					<strong><?php echo JText::_('OS_SOLD')?></strong> <?php echo JText::_('OS_ON');?>: <?php echo $property->soldOn;?>
					<BR />
					<?php
				}
				$db = JFactory::getDbo();
				if($show_price == 1){
					$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'general_currency_default'");
					$curr = $db->loadResult();
					echo "<font class='price_label'>".JText::_('OSPROPERTY_PRICE').": </font>";
					echo $property->price_information;
					echo "<BR />";
				}
				$arr_desc = array();
				if($show_category == 1){
					$link = JRoute::_('index.php?option=com_osproperty&task=category_details&id='.$property->catid.'&Itemid='.$itemid);
					echo "<font class='category_label'>".JText::_('OSPROPERTY_CATEGORY').": </font>";
					echo "<a href='$link' >";
					echo $property->category_name;
					echo "</a>";
					echo "<BR />";
				}
				if($show_type == 1){
					$link = JRoute::_('index.php?option=com_osproperty&view=ltype&type_id='.$property->typeid.'&Itemid='.$itemid);
					echo "<font class='propertytype_label'>".JText::_('OSPROPERTY_TYPE').": </font>";
					echo "<a href='$link' >";
					echo $property->type_name;
					echo "</a>";
					echo "<BR />";
				}
				if ($show_address) {
					if($property->show_address == 1){
						echo "<span class='address_value".$bstyle."'>";
						echo OSPHelper::generateAddress($property);
						echo "</span>";
						echo "<BR />";
					} 
				}
				if ($show_small_desc == 1){
					//$arr_desc = array_merge($arr_desc,explode(' ',strip_tags($property->pro_small_desc)));
					$small_desc = $property->pro_small_desc;
					$small_descArr = explode(" ",$small_desc);
					$count_small_desc = count($small_descArr);
					echo "<span class='desc_module".$bstyle."'>";	
					if($count_small_desc > $limit_word){
						for($i=0;$i<$limit_word;$i++){
							echo $small_descArr[$i]." ";
						}
						echo "...";
					}else{
						echo $small_desc;
					}
					echo "</span><BR/>";
				}
				$addtionalArr = array();
				if($show_bedrooms == 1){
					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_BEDROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/bedroom.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->bed_room</td></tr></table>";
					//$addtionalArr[] = $temp;
					$temp = "<font class='bedroom_label'>".JText::_('OSPROPERTY_BEDROOMS').": </font>";
					$temp.= $property->bed_room;
					$addtionalArr[] = $temp;
				}
				if($show_bathrooms == 1){
	
					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_BATHROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/bathroom.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->bath_room</td></tr></table>";
					//$addtionalArr[] = $temp;
					$temp = "<font class='bedroom_label'>".JText::_('OSPROPERTY_BATHROOMS').": </font>";
					$temp.= OSPHelper::showBath($property->bath_room);
					$addtionalArr[] = $temp;
					//echo "<BR />";
				}
				if($show_rooms  == 1){
					//$temp  = "<table width='100%'><tr><td width='30%' valign='top'>";
					//$temp .= "<span class='hasTip' title='".JText::_('OSPROPERTY_ROOMS')."'><img src='".JURI::root()."components/com_osproperty/images/assets/room.gif' style='border:0px !important;' /></span>";
					//$temp .= "</td><td width='70%' valign='top' class='room".$bstyle."'  >$property->rooms</td></tr></table>";
					//$addtionalArr[] = $temp;
					$temp = "<font class='bedroom_label'>".JText::_('OSPROPERTY_ROOMS').": </font>";
					$temp.= $property->rooms;
					$addtionalArr[] = $temp;
					//echo "<BR />";
				}
				
				echo implode(", ",$addtionalArr);
				?>
			</div>
		</div>
		<?php	
		}
	}
	?>
</div>
