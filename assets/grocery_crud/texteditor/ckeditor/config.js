/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = "youtube"; 
	config.toolbar = 'toolbar_Full';
	// added code for ckfinder ------>
	
	 config.filebrowserBrowseUrl = 'http://localhost/platinum/assets/grocery_crud/texteditor/ckfinder/ckfinder.html';
	 config.filebrowserImageBrowseUrl = '/platinum/assets/grocery_crud/texteditor/ckfinder/ckfinder.html?type=Images';
	 config.filebrowserFlashBrowseUrl = '/platinum/assets/grocery_crud/texteditor/ckfinder/ckfinder.html?type=Flash';
	 config.filebrowserUploadUrl = '/platinum/assets/grocery_crud/texteditor/ckfinder/core/connector /php/connector.php?command=QuickUpload&type=Files';
	 config.filebrowserImageUploadUrl = '/platinum/assets/grocery_crud/texteditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	 config.filebrowserFlashUploadUrl = '/platinum/assets/grocery_crud/texteditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	// end: code for ckfinder ------>
	
	config.removePlugins = 'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar,horizontalrule,wsc' ;
	config.toolbar_Full = [
		['Format','Bold','Italic','Underline','StrikeThrough'],
		['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Image','-','Link','Flash','Source'],
		 { name: 'colors', items : ['Youtube' ] },
	] ;
	//force paste as plain text 
	config.forcePasteAsPlainText = true;

	config.font_names = '';

	config.fontSize_sizes ='';

	config.styles='Format';
};
/* for future reference 
CKEDITOR.editorConfig = function( config )
{
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  //config.uiColor = '#AADC6E';
  config.removePlugins = 'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar,horizontalrule,wsc' ;
  config.toolbar_Full = [
  ['Styles','Format','Font','FontSize'],
  '/',
  ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
  '/',
  ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
  ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
  ] ;
 
};
*/