<?php
/*------------------------------------------------------------------------
# configuration.php - Ossolution Property
# ------------------------------------------------------------------------
# author    Dang Thuc Dam
# copyright Copyright (C) 2010 joomdonation.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomdonation.com
# Technical Support:  Forum - http://www.joomdonation.com/forum.html
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JTextOs{
	function _($string){
		if ($string != ''){
			$string = str_replace(",","",$string);
			$string = str_replace(".","",$string);
			$string = str_replace("'","",$string);
			
			$string = str_replace(" - ","_",$string);
			$string = str_replace("-","_",$string);
			$string = str_replace(" ","_",$string);
			
			$string = str_replace("?","",$string);
			$string = str_replace("/","",$string);
			$string = str_replace("(","",$string);
			$string = str_replace(")","",$string);
			$string = strtoupper('OS_'.$string);
			
		}
		return JText::_($string);
	}
}


class OspropertyConfiguration{
	/**
	 * default function 
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	function display($option,$task){
		global $mainframe;
		switch ($task){
			case "configuration_list":
				OspropertyConfiguration::configuration_list($option);
			break;
			case 'configuration_cancel':
				$mainframe->redirect("index.php?option=$option");
			break;	
			case "configuration_save":
				OspropertyConfiguration::configuration_save($option,$task);
			break;
			case "configuration_apply":
				OspropertyConfiguration::configuration_save($option,$task);
			break;
            case "configuration_help":
                OspropertyConfiguration::helpLayout($option,$task);
            break;
            case "configuration_connectfb":
                OspropertyConfiguration::connectFb($option);
            break;
		}
	}
	
	/**
	 * configuration list
	 *
	 * @param unknown_type $option
	 */
	function configuration_list($option){
		global $mainframe;
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM #__osrs_configuration ');
		$configs = array();
		foreach ($db->loadObjectList() as $config) {
			$configs[$config->fieldname] = $config->fieldvalue;
		}
		HTML_OspropertyConfiguration::configurationHTML($option,$configs);
	}
	
	/**
	 * save configuation
	 *
	 * @param unknown_type $option
	 * @param unknown_type $task
	 */
	function configuration_save($option,$task){
		global $mainframe,$languages;
		$db = JFactory::getDbo();
		
		$agentArr = array();
		$db->setQuery("Select user_id from #__osrs_agents");
		$agents = $db->loadOBjectList();
		if(count($agents) > 0){
			for($i=0;$i<count($agents);$i++){
				$agentArr[] = $agents[$i]->user_id;
			}
		}
		
		$configuration = JRequest::getVar('configuration',array(),'post','array');
		
		$agent_joomla_group_id = $configuration['agent_joomla_group_id'];
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'agent_joomla_group_id'");
		$old_agent_joomla_group_id = $db->loadResult();
		if($old_agent_joomla_group_id != ""){
			if($old_agent_joomla_group_id != $agent_joomla_group_id){
				if(count($agentArr) > 0){
					$db->setQuery("Delete from #__user_usergroup_map where user_id in (".implode(",",$agentArr).") and group_id = '$old_agent_joomla_group_id'");
					$db->query();
				}
			}
		}
		if($agent_joomla_group_id != ""){
			for($i=0;$i<count($agentArr);$i++){
				$agent_id = $agentArr[$i];
				$db->setQuery("Select count(user_id) from #__user_usergroup_map where user_id = '$agent_id' and group_id = '$agent_joomla_group_id'");
				$count = $db->loadResult();
				if($count == 0){
					$db->setQuery("Insert into #__user_usergroup_map (user_id,group_id) values ('$agent_id','$agent_joomla_group_id')");
					$db->query();
				}
			}
		}
		
		$companyArr = array();
		$db->setQuery("Select user_id from #__osrs_companies");
		$companies = $db->loadOBjectList();
		if(count($companies) > 0){
			for($i=0;$i<count($companies);$i++){
				$companyArr[] = $companies[$i]->user_id;
			}
		}
		
		
		$company_joomla_group_id = $configuration['company_joomla_group_id'];
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'company_joomla_group_id'");
		$old_company_joomla_group_id = $db->loadResult();
		if($old_company_joomla_group_id != ""){
			if($old_company_joomla_group_id != $company_joomla_group_id){
				if(count($companyArr) > 0){
					$db->setQuery("Delete from #__user_usergroup_map where user_id in (".implode(",",$companyArr).") and group_id = '$old_company_joomla_group_id'");
					$db->query();
				}
			}
		}
		if($company_joomla_group_id != ""){
			for($i=0;$i<count($companyArr);$i++){
				$company_id = $companyArr[$i];
				$db->setQuery("Select count(user_id) from #__user_usergroup_map where user_id = '$company_id' and group_id = '$company_joomla_group_id'");
				$count = $db->loadResult();
				if($count == 0){
					$db->setQuery("Insert into #__user_usergroup_map (user_id,group_id) values ('$company_id','$company_joomla_group_id')");
					$db->query();
				}
			}
		}

        $db->setQuery("Select * from #__osrs_types order by ordering");
        $property_types = $db->loadObjectList();
        for($i=0;$i<count($property_types);$i++) {
            $property_type = $property_types[$i];
            $type = JRequest::getInt('type'.$property_type->id,0);
            if($type == 1){
                $configuration['type'.$property_type->id] = 1;
            }else{
                $valueTemp = array();
                $valueTemp[] = 0;
                $min = JRequest::getVar('min'.$property_type->id,0);
                $max = JRequest::getVar('max'.$property_type->id,0);
                $step = JRequest::getVar('step'.$property_type->id,0);
                $valueTemp[] = $min;
                $valueTemp[] = $max;
                $valueTemp[] = $step;
                $value = implode("|",$valueTemp);
                $configuration['type'.$property_type->id] = $value;
            }
        }
		
		foreach ($configuration as $fieldname => $fieldvalue) {
			if (is_array($fieldvalue)) $fieldvalue = implode(',',$fieldvalue);
			$fieldvalue = addslashes($fieldvalue);
			$db->setQuery("SELECT count(id) FROM #__osrs_configuration WHERE `fieldname` = '$fieldname'");
			if ($db->loadResult()){
				$db->setQuery("UPDATE #__osrs_configuration SET `fieldvalue` = '$fieldvalue' WHERE `fieldname` = '$fieldname'");
				$db->query();
			}else{
				$db->setQuery("INSERT INTO #__osrs_configuration VALUES ('NULL','$fieldname','$fieldvalue')");
				$db->query();
			}
		}
		
		$show_top_menus_in = JRequest::getVar('show_top_menus_in');
	//	if(count($show_top_menus_in) > 0){
		$show_top_menus_in = implode("|",$show_top_menus_in);
		$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$show_top_menus_in' WHERE fieldname like 'show_top_menus_in'");
		$db->query();
		//}
		
		$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'general_unpublished_days'");
		$default_currency = $db->loadResult();
		if(intval($default_currency) > 0){
			$db->setQuery("Update #__osrs_properties set curr = '$default_currency' where curr = '0'");
			$db->query();
		}
		
		//Upload watermark
		$remove_watermark_photo = Jrequest::getVar('remove_watermark_photo',0);
		if(is_uploaded_file($_FILES['watermark_photo']['tmp_name'])){
			$filename    = $_FILES['watermark_photo']['name'];
			$filenameArr = explode(".",$filename);
			$ext         = $filenameArr[count($filenameArr)-1];
			$filename    = "ospwatermark.".$ext;
			move_uploaded_file($_FILES['watermark_photo']['tmp_name'],JPATH_ROOT.DS."images".DS.$filename);
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$filename' WHERE fieldname like 'watermark_photo'");
			$db->query();
		}elseif($remove_watermark_photo == 1){
			$filename 	 =  "";
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$filename' WHERE fieldname like 'watermark_photo'");
			$db->query();
		}
		
		$adv_type_ids = JRequest::getVar('adv_type_ids');
		if(count($adv_type_ids) > 0){
			if(in_array(0,$adv_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'adv_type_ids'");
				$db->query();
			}else{
				$adv_type_ids1 = array();
				for($i=0;$i<count($adv_type_ids);$i++){
					if($adv_type_ids[$i] != 0){
						$adv_type_ids1[count($adv_type_ids1)] = $adv_type_ids[$i];
					}
				}
				$adv_type_ids = implode("|",$adv_type_ids1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$adv_type_ids' WHERE fieldname LIKE 'adv_type_ids'");
				$db->query();
			}
		}
		
		$locator_type_ids = JRequest::getVar('locator_type_ids');
        //print_r($locator_type_ids);die();
		if(count($locator_type_ids) > 0){
			if(in_array(0,$locator_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'locator_type_ids'");
				$db->query();
			}else{
				$locator_type_ids1 = array();
				for($i=0;$i<count($locator_type_ids);$i++){
					if($locator_type_ids[$i] != 0){
						$locator_type_ids1[count($locator_type_ids1)] = $locator_type_ids[$i];
					}
				}
				$locator_type_ids = implode("|",$locator_type_ids1);
                //echo $locator_type_ids;die();
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$locator_type_ids' WHERE fieldname LIKE 'locator_type_ids'");
				$db->query();
			}
		}
		
		
		$show_date_search_in = JRequest::getVar('show_date_search_in');
		if(count($show_date_search_in) > 0){
			if(in_array(0,$show_date_search_in)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'show_date_search_in'");
				$db->query();
			}else{
				$show_date_search_in1 = array();
				for($i=0;$i<count($show_date_search_in);$i++){
					if($show_date_search_in[$i] != 0){
						$show_date_search_in1[count($show_date_search_in1)] = $show_date_search_in[$i];
					}
				}
				$show_date_search_in = implode("|",$show_date_search_in1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$show_date_search_in' WHERE fieldname LIKE 'show_date_search_in'");
				$db->query();
			}
		}
		
		$db->setQuery("Select count(id) from #__osrs_configuration where fieldname like 'sold_property_types'");
		$count_sold = $db->loadResult();
		if($count_sold == 0){
			$db->setQuery("Insert into #__osrs_configuration (id,fieldname) values (NULL,'sold_property_types');");
			$db->query();
		}
		$adv_type_ids = JRequest::getVar('sold_property_types');
		if(count($adv_type_ids) > 0){
			if(in_array(0,$adv_type_ids)){
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '0' WHERE fieldname LIKE 'sold_property_types'");
				$db->query();
			}else{
				$adv_type_ids1 = array();
				for($i=0;$i<count($adv_type_ids);$i++){
					if($adv_type_ids[$i] != 0){
						$adv_type_ids1[count($adv_type_ids1)] = $adv_type_ids[$i];
					}
				}
				$adv_type_ids = implode("|",$adv_type_ids1);
				$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$adv_type_ids' WHERE fieldname LIKE 'sold_property_types'");
				$db->query();
			}
		}else{
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '' WHERE fieldname LIKE 'sold_property_types'");
			$db->query();
		}
		
		$image_code = JRequest::getVar('image_code');
		if($image_code != ""){
			$db->setQuery("UPDATE #__osrs_configuration SET fieldvalue = '$image_code' WHERE fieldname LIKE 'image_background_color'");
			$db->query();
		}

		
		$msg = JText::_("OS_CONFIGURE_OPTION_HAVE_BEEN_SAVED");
		if ($task == 'configuration_save'){
			$mainframe->redirect("index.php?option=$option",$msg);
		}else{
			$mainframe->redirect("index.php?option=$option&task=configuration_list",$msg);
		}
	}

    /**
     * Return the configuration field checkboxes
     * @param $fieldname
     * @param $fieldvalue
     */
    public static function showCheckboxfield($fieldname,$fieldvalue,$option1='',$option2=''){
        if($option1 == ""){
            $option1 = JText::_('OS_YES');
        }
        if($option2 == ""){
            $option2 = JText::_('OS_NO');
        }
        if (version_compare(JVERSION, '3.0', 'lt')) {
            $optionArr = array();
            $optionArr[] = JHTML::_('select.option',1,$option1);
            $optionArr[] = JHTML::_('select.option',0,$option2);
            echo JHTML::_('select.genericlist',$optionArr,'configuration['.$fieldname.']','class="input-mini"','value','text',$fieldvalue);
        }else{
            $name = $fieldname;
            if(intval($fieldvalue) == 0){
                $checked2 = 'checked="checked"';
                $checked1 = "";
            }else{
                $checked1 = 'checked="checked"';
                $checked2 = "";
            }
            ?>
            <fieldset id="jform_params_<?php echo $name;?>" class="radio btn-group">
                <input type="radio" id="jform_params_<?php echo $name;?>0" name="configuration[<?php echo $name; ?>]" value="1" <?php echO $checked1;?>/>
                <label for="jform_params_<?php echo $name;?>0"><?php echo $option1;?></label>
                <input type="radio" id="jform_params_<?php echo $name;?>1" name="configuration[<?php echo $name; ?>]" value="0" <?php echO $checked2;?>/>
                <label for="jform_params_<?php echo $name;?>1"><?php echo $option2;?></label>
            </fieldset>
        <?php
        }
    }

    static function helpLayout($option,$task){
        JToolBarHelper::title(JText::_('JTOOLBAR_HELP'),"help");
        ?>
        <div class="row-fluid">
            <div class="span12" style="border:1px solid #DDD;padding:15px;border-radius:10px;-webkit-box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);-moz-box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);box-shadow: 6px 15px 26px -5px rgba(0,0,0,0.61);">
                OS Property official page: <a title="OS Property official page" href="http://joomdonation.com/joomla-extensions/os-property-joomla-real-estate.html" target="_blank">http://joomdonation.com/joomla-extensions/os-property-joomla-real-estate.html</a>
                <BR /><BR />
                Demo site: <a title="Demo site" href="http://osproperty.ext4joomla.com" target="_blank">http://osproperty.ext4joomla.com</a>
                <BR /><BR />
                Documentation: <a title="Documentation" href="http://osproperty.ext4joomla.com/OS_Property_Instructions.pdf" target="_blank">http://osproperty.ext4joomla.com/OS_Property_Instructions.pdf</a>
                <BR /><BR />
                If you have any questions regarding the OS Property, you can choose one of following ways to get the best supports:
                <BR />
                <ol>
                    <li>
                        Login to your account and
                        <a target="new" href="http://joomdonation.com/support-tickets.html">Submit a Support Ticket</a>
                    </li>
                    <li>
                        Leave questions on
                        <a target="new" href="http://joomdonation.com/forum/os-property.html">Forum</a>
                    </li>
                    <li>
                        Drop me an email to
                        <a href="mailto:damdt@joomservices.com">damdt@joomservices.com</a>
                    </li>
                    <li>
                        Contact me via Skype, YM or Gtalk for instant chat. You can find my contact information below:
                        <ul>
                            <li>Skype: thucdam84</li>
                            <li>YM: thucdam84@yahoo.com</li>
                            <li>Gtalk: thucdam84@gmail.com</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <BR /><BR />
    <?php
    }

    public function connectFb($option){
        $input = JFactory::getApplication()->input;
        $app_id = $input->get('app_id','','string');
        $app_secret = $input->get('app_secret','','string');
        ?>
        <script src="<?php echo JUri::root()?>components/com_osproperty/js/all.js" type="text/javascript"></script>
        <script type="text/javascript">
			var $JVSP = jQuery.noConflict();
            $JVSP(function($){
				function returnOption(name, value){
				    var opt = document.createElement('option');
					opt.name = name;
					opt.value = value;
					return opt;
				}
				function returnOptionGroup(label, children){
					var optgroup = document.createElement('optgroup');
					optgroup.label = label;
					optgroup.appendChild(children);
					return optgroup;
				}
                function getQueryVariable(query, variable)
                {
                    var vars = query.split("&");
                    for (var i=0;i<vars.length;i++) {
                        var pair = vars[i].split("=");
                        if(pair[0] == variable){return pair[1];}
                    }
                    return(false);
                }

                function checkTokenPermission(token){
                    var valid = false;
                    $.ajax({
                        url: 'https://graph.facebook.com/v2.1/me/permissions?access_token='+token,
                        dataType: 'json',
                        async: false,
                        beforeSend: function(){},
                        success: function(data){
                            var publish_actions = false;
                            var user_groups = false;
                            var user_likes = false;
                            var manage_pages = false;

                            if(data) $.each(data.data, function(key, item){
                                if(item.permission == 'publish_actions' && item.status == 'granted') publish_actions = true;
                                //if(item.permission == 'user_groups' && item.status == 'granted') user_groups = true;
                                if(item.permission == 'user_likes' && item.status == 'granted') user_likes = true;
                                if(item.permission == 'manage_pages' && item.status == 'granted') manage_pages = true;
                            });

                            var error = [];
                            if(!publish_actions) error.push('publish_actions');
                            //if(!user_groups) error.push('user_groups');
                            if(!user_likes) error.push('user_likes');
                            if(!manage_pages) error.push('manage_pages');

                            if(error.length == 0){
                                valid = true;
                            }else{
                                alert( error);
                            }
                        },
                        error: function(jqXHR,textStatus,errorThrown){
                            //alert(Joomla.JText._('COM_JVSOCIAL_PUBLISH_CHANNEL_MSG_ERROR_WHEN_CHECK_ACCESS_TOKEN'));
                        }
                    });

                    return valid;
                }

                $(document).ready(function(){
                    FB.init({ appId: '<?php echo $app_id;?>', status: true, cookie: true, xfbml: true  });
                    var APICall = function(func){
                        FB.getLoginStatus(function(response){
                            if(response.status == 'connected'){
                                func(response)
                            }else{
                                FB.login(function (response) {
                                    func(response)
                                },{
                                    scope: 'publish_actions, user_likes, manage_pages'
                                });
                            }
                        });
                    };

                    APICall(function(response){
                        if(response.authResponse.accessToken){
                            $.ajax({
                                url: 'https://graph.facebook.com/oauth/access_token',
                                data: {
                                    client_id: '<?php echo $app_id;?>',
                                    client_secret: '<?php echo $app_secret;?>',
                                    grant_type: 'fb_exchange_token',
                                    fb_exchange_token: response.authResponse.accessToken
                                },
                                beforeSend: function(){},
                                success: function(data){
                                    var access_token = getQueryVariable(data,'access_token');
                                    if(access_token){
                                        //window.close();


                                        if(checkTokenPermission(access_token)){
											var str = "";
                                            //window.opener.ChannelModel.token(access_token);
                                            window.opener.document.getElementById('access_token').value = access_token;
                                            FB.api('/me?fields=id,name,picture', function(data){
                                                
												var fb_params = window.opener.document.getElementById('fb_params');
												//fb_params.innerHTML = data;
                                                var fb_target = window.opener.document.getElementById('fb_target');
                                                var ogl = fb_target.getElementsByTagName('optgroup')
                                                for (var i=ogl.length-1;i>=0;i--) fb_target.removeChild(ogl[i])
                                                for (var option in fb_target){
                                                    fb_target.remove(option);
                                                }
												var opt = document.createElement('option');
												opt.value = '';
												opt.innerHTML = data.name;
												fb_target.appendChild(opt);
												str += "@@:" + data.name;
												FB.api('/me/groups', function(groups){
												if(groups.data){
													//str += "||Groups@@";
													var groupValues = groups.data;
													var label = "Group";
													var groupList = [];											
													
													$.each(groupValues, function(i, item){
														
													});
													
												}
												

													FB.api('/me/likes', function(pages){
														if(pages.data){															
															var groupValues = pages.data;
															var groupList = [];
															str += "||Pages@@";
															var optgroup = document.createElement('optgroup');
															optgroup.label = "Pages";
															
															$.each(groupValues, function(i, item){
																//groupList.push( returnOption(item.name, item.id));
																var opt = document.createElement('option');
																opt.value = item.id
																opt.innerHTML = item.name;
																optgroup.appendChild(opt);
																str += item.id + ":" + item.name + "{+}";
															});
															str = str.substring(0,str.length-3);
															fb_target.appendChild(optgroup);
														}

														FB.api('/me/accounts', function(accounts){
															if(accounts.data){
																//window.opener.ChannelModel.pushOption('accounts', accounts.data);
																var groupValues = accounts.data;
																var groupList = [];
																str += "||Accounts@@";
																var optgroup = document.createElement('optgroup');
																optgroup.label = "Accounts";
																
																$.each(groupValues, function(i, item){
																	//groupList.push( returnOption(item.name, item.id));
																	var opt = document.createElement('option');
																	opt.value = item.id
																	opt.innerHTML = item.name;
																	optgroup.appendChild(opt);
																	str += item.id + ":" + item.name + "{+}";
																});
																str = str.substring(0,str.length-3);
																fb_target.appendChild(optgroup);
															}
															
															fb_params.innerHTML = str;
															window.close();
														});
													});
													
												});
												
                                            });
                                        }else{
                                            window.close();
                                        }

                                    }else{
                                   
                                        window.close();
                                    }
                                },
                                error: function(jqXHR,textStatus,errorThrown){
                             
                                    window.close();
                                }
                            });
                        }
                    });
                });
            });
    </script>
    <?php
    }
}
?>