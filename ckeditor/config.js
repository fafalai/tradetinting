/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.height = 500;
	config.toolbarCanCollapse = true;
	config.extraPlugins = "base64image";
	config.removeButtons = 'Save,About,Image';
	//config.skin = 'moono_blue';
	//config.skin = 'office2013';
};
