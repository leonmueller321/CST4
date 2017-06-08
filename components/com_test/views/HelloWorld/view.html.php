<?php

defined(('_JEXEC') or die('no Permissions'));

jimport('joomla.application.component.view');

class HelloWorldViewHelloWorld extends JView{
    
    public function display($tpl = null) {
        //JToolbarHelper::title('Hello World Administration page');
        //JToolbarHelper::cancel('helloworld.cancel');
        parent::display($tpl);
    }
}

?>

