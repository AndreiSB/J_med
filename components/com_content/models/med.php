<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2014 TM, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Med Model
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.5
 */
class ContentModelMed extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_content.article';

  public function storesc($medid,$articleurl)
	{

			// Initialize variables.
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);

			// Create the base select statement.
			$query->select('urls')
				->from($db->quoteName('#__content'))
				->where($db->quoteName('id') . ' = ' . (int) $medid);

			// Set the query and load the result.
			$db->setQuery($query);
			$urlsmed = $db->loadObject();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				JError::raiseWarning(500, $db->getErrorMsg());

				return false;
			}
                        
                        
                        
                        
                        $urlsdecode=json_decode($urlsmed->urls,true);                        
                        $urlmeda=$urlsdecode["urla"];
                        
                        //если поле сцилки не заполнено- работаем
			if ($urlmeda === FALSE || $urlmeda =="")
				{
                            $urlsdecode["urla"]=$articleurl;
                            $urlsdecode["urlatext"]="Перейти к рецензии";
                            

                            
                            $urlsjson=json_encode($urlsdecode);

                            
                            
                            
					$query = $db->getQuery(true);
                                        // Create the base update statement.
					$query->update($db->quoteName('#__content'))
						->set($db->quoteName('urls') . ' = '.$db->quote($urlsjson))
						->where($db->quoteName('id') . ' = ' . (int) $medid);

					// Set the query and execute the update.
					$db->setQuery($query);

					try
					{
						$db->execute();
					}
					catch (RuntimeException $e)
					{
						JError::raiseWarning(500, $e->getMessage());

						return false;
					}
				
			}

			return true;

	}
        
              
        
        
        
 
        
        
        
}
