<?php
/**
* Описание дополнительного функционала:
*
* Созданы дополнительные формы для создания научных статей и рецензий на статьи.
* Предварительно должны быть созданы две категории. Для статей и для рецензий.
* Создать два пункта меню для создания статей и рецензий 
* (тип- articles-com_content_formmed_view_default_title и articles-com_content_formrecens_view_default_title)
* 
* Статьи и рецензии добавляются в базу как обычные материалы.
* Могут быть отредактированы как обычные материалы в админразделе.
* Из фронтенда эти материалы редактируются через собственные формы.
* 
* Статья и рецензия связаны взаимными ссылками. 
* Ссылки автоматически прописываются в поле refA при создании рецензии на статью.
*
* Статья может быть загружена в виде файла. На сервере файл переименовывается по шаблону 
* ГГГГММДД_ЧЧ_ММ_СС_authorname.xxx
* Проверяется MIME-тип файла. Разрешены документы MSWord, OpenOffice text, текстовые, архивы zip, rar.
* Ссылка на загруженный файл перезаписывает текст материала.
*
* В административном разделе задаются параметры во вкладке настроек материала:
* (system-global configuration-articles-параметры для научных статей и рецензий)
* ID категории статей, ID категории рецензий, ID доступа создаваемых материалов.
*
*
*
* Описание изменений стандартной установки Joomla (v.3.3.0):
*
* Изменён файл. добавлены параметры для изменения в админпанели категорий создаваемых статей,
* рецензий и уровня доступа создаваемого материала. Строки 899-928
* \administrator\components\com_content\config.xml
*
* Изменён файл. добавлены точки входа для редактирования статей и рецензий. Строки 164-176
* \components\com_content\helpers\icon.php
* 
* Добавлены файлы
* \components\com_content\controllers\articlesc.php
* \components\com_content\controllers\articlescrecens.php
* \components\com_content\models\formmed.php
* \components\com_content\models\formrecens.php
* \components\com_content\models\med.php
*
* Добавлены папки с файлами
* \components\com_content\views\formmed
* \components\com_content\views\formrecens
*
* Папка для файлов статей
* \scmedfls
*
* template.css
* стр.915 ширина поля название статьи
*
* \language\ru-RU\ru-RU.ini
* стр.180 181 псевдоним автора
* стр 139-142 аннотация, ключевые слова
*
* \components\com_content\models\forms\article.xml 
*		<field
*			id="created_by_alias"
*			name="created_by_alias"
*			type="textarea"
*			label="JGLOBAL_FIELD_CREATED_BY_ALIAS_LABEL"
*			description="JGLOBAL_FIELD_CREATED_BY_ALIAS_DESC"
*			class="inputbox"
*                        rows="5"
*			cols="50" />
*
 * 
 * Изменён , чтобы автор видел свои неопубликованные материалы
 * /components/com_content/models/articles.php
 * 
 * 
 * 
 * 
*/
?>