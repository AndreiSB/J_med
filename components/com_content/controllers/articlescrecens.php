<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');
require_once 'components/com_content/controllers/article.php';
class ContentControllerArticlescrecens extends ContentControllerArticle
{
    

protected $view_item = 'formrecens';

//вызывается ядром во время сохранения материала
public function postSaveHook($model, $validData)
{
        global $idrecens;
        $idrecens=$model->getState("form.id");


} 


        public function save($key = null, $urlVar = 'a_id')
	{
                    global $idrecens;
                    $medid	= $this->input->getInt('medid');
                    $model = $this->getModel('med');
                    
                    $result = parent::save($key, $urlVar);

       
		if ($result)
		{
			$this->setRedirect($this->getReturnPage());
                        $articleurl='index.php?option=com_content&view=article&id='.$idrecens.'&catid='.''.'&Itemid='.'';
                        $model->storesc($medid,$articleurl);
		}


		return $result;
	}
        
        
        




}
