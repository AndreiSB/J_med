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
			<?php
                        echo $this->form->getField('articletext')->save();
                         ?>
			Joomla.submitform(task);
		}
	}
        



</script>

<?php    
jimport('joomla.filesystem.file');

//не работает. надо преобразовывать суффикс. пример 200M
//$max = ini_get('upload_max_filesize');
$max=4000;

//$module_dir = $params->get( 'dir' );
$module_dir = 'scmedfls';

//$file_type = $params->get( 'type' );
$file_type = "*";

//$user_names = $params->get( 'user_names' );

//Наличие файла статьи
$tf=0;
function fileUpload($max, $module_dir, $file_type,&$tf){

	
        $app = JFactory::getApplication();
        $userf =JFactory::getUser();
        $usernamef = $userf->get('username');

	//Retrieve file details from uploaded file, sent from upload form
	$file = JRequest::getVar('file_upload', null, 'files', 'array'); 
	// Retorna: Array ( [name] => mod_simpleupload_1.2.1.zip [type] => application/zip 
	// [tmp_name] => /tmp/phpo3VG9F [error] => 0 [size] => 4463 ) 

	if(isset($file)){ 
		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);

		//if($file['size'] > $max) {

			//Set up the source and destination of the file
			$src = $file['tmp_name'];
			//$dest = $module_dir.'/'.$filename;
                        $frs1=explode( '.', $file['name']);
                        $frs2=array_pop($frs1);
                        $dest = $module_dir.'/'.date("Ymd_H_i_s_").$usernamef.'.'.$frs2;
                        

			//First check if the file has the right extension, we need jpg only
			//if ($file['type'] == $file_type || $file_type == '*') {
                        if ($file['type'] == "application/msword"||$file['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"||$file['type'] == "application/vnd.oasis.opendocument.text"||$file['type'] == "text/plain"||$file['type'] == "application/pdf"||$file['type'] == "application/zip"||$file['type'] == "application/rar") {

			   if ( JFile::upload($src, $dest) ) {
				  //Redirect to a page of your choice
					//$app->enqueueMessage( JText::_('FILE_SAVE_AS').' '.$dest,'message');
                                          $app->enqueueMessage('Файл сохранён на сервере');
                                          $tf='<a href=\"'.$dest .'\">'.'Файл статьи'.'</a>';
                                                              
                                          
			   } else {
				  //Redirect and throw an error message
					$app->enqueueMessage( JText::_('ERROR_IN_UPLOAD'),'error');
			   }

			} else {
			   //Redirect and notify user file is not right extension
				$app->enqueueMessage( JText::_('FILE_TYPE_INVALID'),'error');
			}
		//}else{
		//	$app->enqueueMessage( JText::_('ONLY_FILES_UNDER').' '.$max, 'error' );
		//}
	}
}

$acc = 0;
if(isset($usernamef) && isset($user_names)) {  // User logged and textbox with user to upload
	$more = strpos($user_names, ',',0);

	if($more >0){
		$user_names = explode(',',$user_names);

		foreach($user_names as $un){
			if($un == $usernamef) {
				$acc=1;
			}
		}
	}else{
		if ($user_names == $usernamef) {
			$acc=1;
		}
	}
}

if(isset($usernamef)){
	$acc=1;
}
        //if($acc == 1){
                      ?>
	<form name="imgform" id="imgform" method="post" action="" enctype="multipart/form-data" onSubmit="if(file_upload.value=='') {alert('Choose a file!');return false;}">

	</form>
	<?php
		print fileUpload($max, $module_dir, $file_type,$tf);
//}

// Adaptação de http://docs.joomla.org/How_to_use_the_filesystem_package
?>
    


<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
	<form action="<?php echo JRoute::_('index.php?option=com_content&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
		<div class="btn-toolbar">
			<div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('article.save')">
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
				<li class="active"><a href="#mfile" data-toggle="tab">Файл статьи</a></li>
                                <li><a href="#editor" data-toggle="tab">Контент</a></li>	
				<li><a href="#publishing" data-toggle="tab">Публикация</a></li>
				<li><a href="#metadata" data-toggle="tab"><?php echo JText::_('COM_CONTENT_METADATA') ?></a></li>
			</ul>

			<div class="tab-content">
                            
<div class="tab-pane active" id="mfile"> 
		
                <?php
                if ($tf===0){                    
                echo 'Возможны два варианта загрузки статьи на сайт. Статья может быть загружена в виде файла или набрана во вкладке "Контент". Внимание! При загрузке файла текст вкладки "Контент" теряется!<br/><br/><br/><br/>';
                ?>
                <input form="imgform" type="file" name="file_upload" size="10" />
		<input form="imgform" name="submit" type="submit" value="Upload" />   
    <?php
               }
               else{
                   echo 'Файл загружен.';
               }
                        ?>                            
   </div>                         
				<div class="tab-pane" id="editor">
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('title'); ?>
						</div>
						<div class="controls">
                                                    
                                                    <?php $this->form->setFieldAttribute('title', 'size','1530'); ?>
							<?php echo $this->form->getInput('title'); ?>
						</div>
					</div>
                                    
            <?php if (is_null($this->item->id)) : ?>
            <input type="hidden" name="jform[urls][urla]" value="" />
            <input type="hidden" name="jform[urls][urlatext]" value="" />
            <input type="hidden" name="jform[urls][targeta]" value="" />
            
            <input type="hidden" name="jform[urls][urlb]" value="" />
            <input type="hidden" name="jform[urls][urlbtext]" value="" />
            <input type="hidden" name="jform[urls][targetb]" value="" />

            <input type="hidden" name="jform[urls][urlc]" value="" />
            <input type="hidden" name="jform[urls][urlctext]" value="" />
            <input type="hidden" name="jform[urls][targetc]" value="" />
            
            <input type="hidden" name="jform[alias]" value="" />
            
					<?php endif; ?>
            <input type="hidden" name="jform[catid]" value="<?php echo $params->get('num_cat_scarticle'); ?>" />
            <input type="hidden" name="jform[tags]" value="" />
            <input type="hidden" name="jform[access]" value="<?php echo $params->get('num_access'); ?>" />
            <input type="hidden" name="jform[language]" value="*" />
                                    
           
                                    <?php $this->form->setFieldAttribute('articletext', 'buttons', 'false'); ?>
                                    <?php if ($tf===0) : ?>
                                    <div>
                             <?php echo $this->form->getInput('articletext'); ?>
                                    </div>
                                    <?php else : ?>
                                   <div style="display:none;">
                             <?php echo $this->form->getInput('articletext'); ?>
                                    </div>
                                    
                             <script type="text/javascript">
                                window.onload = function () {                                    
                                //jInsertEditorText('<?php //echo $tf; ?>','jform_articletext');
                                    if (isBrowserIE())
                                    {
                                        if (window.parent.tinyMCE)
                                        {
                                        window.parent.tinyMCE.selectedInstance.selection.moveToBookmark(window.parent.global_ie_bookmark);
                                        }
                                    }                                    
                                    tinyMCE.execCommand('mceSetContent', false, '<?php echo $tf; ?>');
                                }                      
                             </script>
            
                                    <?php endif; ?>
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
                   

				<div class="tab-pane" id="metadata">
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('metadesc'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('metadesc'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('metakey'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('metakey'); ?>
						</div>
					</div>
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />			
				</div>
			
                    

                    </div>
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>
            
	</form>
    </div>
