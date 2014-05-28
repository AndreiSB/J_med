<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.modal', 'a.modal_jform_contenthistory');

// Create shortcut to parameters.
$params = $this->state->get('params');
//$images = json_decode($this->item->images);
//$urls = json_decode($this->item->urls);

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);
//if (!$editoroptions)
//{
	$params->show_urls_images_frontend = '0';
//}
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'article.cancel' || document.formvalidator.isValid(document.getElementById('adminForm')))
		{
			<?php echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task);
		}
	}
</script>

   <?php
    JHtml::_('behavior.modal', 'a.modal');
    $tmp2=JURI::base();
   $script = array();             
    $script[] = 'function jSelectArticleMed(id, title, catid, object, link) {';
    //$script[] = 'link=\"'.$tmp2.'\".concat(link);';
   //задать сцылку
    $script[] = 'document.getElementsByName("jform[urls][urla]")[0].value = "'.JURI::base().'"+link;'; 

    //задать титл
   $script[] = 'document.getElementsByName("jform[title]")[0].value="Рецензия на статью "+title;';

    //задать метку
   $script[] = 'document.getElementsByName("jform[tags][]")[0].value="#new#"+title;';

   //задать id рецензируемого материала
   $script[] = 'document.getElementsByName("medid")[0].value=id;';

   //лабел поменять
    $script[] = 'document.getElementById("jform_urls_urla-lbl").innerHTML = "Рецензия на: "+title;';


    $script[] = '           SqueezeBox.close();'; 
    $script[] = '   }';

    JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

   // $link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1';
   // $link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticleMed&amp;' . JSession::getFormToken() . '=1';
 // $link   = 'index.php?option=com_content&view=articles&layout=modal&tmpl=component&function=jSelectArticle_'.$this->id; 

 ?>	





<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">


	<form action="<?php echo JRoute::_('index.php?option=com_content&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
            
            <input type="hidden" name="medid" value="" />
            <div style="display:none;">            
            <?php echo $this->form->getInput('urla', 'urls'); ?>
            </div>
                

            <input type="hidden" name="jform[urls][urlatext]" value="Перейти к статье" />
            <input type="hidden" name="jform[urls][targeta]" value="" />

            <input type="hidden" name="jform[urls][urlb]" value="" />
            <input type="hidden" name="jform[urls][urlbtext]" value="" />
            <input type="hidden" name="jform[urls][targetb]" value="" />

            <input type="hidden" name="jform[urls][urlc]" value="" />
            <input type="hidden" name="jform[urls][urlctext]" value="" />
            <input type="hidden" name="jform[urls][targetc]" value="" />
            
            <input type="hidden" name="jform[catid]" value="<?php echo $params->get('num_cat_screcarticle'); ?>" />
            <input type="hidden" name="jform[tags][]" value="" />
            <input type="hidden" name="jform[access]" value="<?php echo $params->get('num_access'); ?>" />
            <input type="hidden" name="jform[language]" value="*" />
            
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
            
		
            
            
            
            <div class="btn-toolbar">
			<div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('articlescrecens.save')">
					<span class="icon-ok"></span>&#160;<?php echo JText::_('JSAVE') ?>
				</button>
			</div>
			<div class="btn-group">
				<button type="button" class="btn" onclick="Joomla.submitbutton('article.cancel')">
					<span class="icon-cancel"></span>&#160;<?php echo JText::_('JCANCEL') ?>
				</button>
			</div>
			<?php if ($params->get('save_history', 0)) : ?>
			<div class="btn-group">
				<?php echo $this->form->getInput('contenthistory'); ?>
			</div>
			<?php endif; ?>
		</div>
            
            
            
            
		<fieldset>
			<ul class="nav nav-tabs">
                        
                                <li class="active"><a href="#editor" data-toggle="tab"><?php echo JText::_('COM_CONTENT_ARTICLE_CONTENT') ?></a></li>
                		<li><a href="#publishing" data-toggle="tab"><?php echo JText::_('COM_CONTENT_PUBLISHING') ?></a></li>
				
			</ul>
                    <div class="tab-content">
	                        
                            		<div class="tab-pane active" id="editor">           
                                            <?php if (is_null($this->item->id)): ?>
                                            
                                            		<div  class="control-group">
                                       <div class="control-label">                             
                                                 <?php $this->form->setFieldAttribute('urla','label','Выбор статьи для рецензирования','urls'); ?>
							<?php echo $this->form->getLabel('urla', 'urls'); ?>
                                                </div>
                                                            
                                                            
                                                                  <div class="controls">                             
                                                <?php $link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticleMed&amp;' . JSession::getFormToken() . '=1'; ?>
						<a href=<?php echo $link?> class="modal" rel="{size: {x: 700, y: 500}, handler:'iframe'}" >Выбрать статью</a>
                                                </div>          
                                                            
                      
					</div>
                                            
                                            
                                            <?php endif; ?>
                                            
                                            
                                            
                                        <?php if (is_null($this->item->id)) : ?>
					
                                                        <input type="hidden" name="jform[title]" value="" />
                                                        <input type="hidden" name="jform[alias]" value="" />
                                        
                                        <?php else:?>     
                                            	<div style="display:none;">
							<?php echo $this->form->getInput('title');?>
						</div>
					
                                        <?php endif; ?>
                                         <?php  $this->form->setFieldAttribute('articletext', 'buttons', 'false'); ?>
					<?php echo $this->form->getInput('articletext'); ?>
				</div>
                            
                            
                      
                            
				<div class="tab-pane" id="publishing">

					<?php if ($params->get('save_history', 0)) : ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('version_note'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('version_note'); ?>
						</div>
					</div>
					<?php endif; ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('created_by_alias'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('created_by_alias'); ?>
						</div>
					</div>
					<?php if ($this->item->params->get('access-change')) : ?>
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('state'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('state'); ?>
							</div>
						</div>
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('featured'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('featured'); ?>
							</div>
						</div>
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('publish_up'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('publish_up'); ?>
							</div>
						</div>
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('publish_down'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('publish_down'); ?>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>	

			
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>
	</form>
</div>
