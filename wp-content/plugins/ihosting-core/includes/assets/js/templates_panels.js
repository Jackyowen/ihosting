/* global vc */
var template_editor;
(function ( $ ) {
	'use strict';
	var templateOptions, templatePanelSelector, TemplatePanelEditorBackend, TemplatePanelEditorFrontend;
	templateOptions = {
		save_template_action: 'vc_template_save_template',
		appendedClass: 'template_manager',
		appendedTemplateType: 'template_manager',
		delete_template_action: 'vc_template_delete_template'
	};
	if ( window.vc && window.vc.TemplateWindowUIPanelBackendEditor ) {
		TemplatePanelEditorBackend = vc.TemplateWindowUIPanelBackendEditor.extend( templateOptions );
		TemplatePanelEditorFrontend = vc.TemplateWindowUIPanelFrontendEditor.extend( templateOptions );
		templatePanelSelector = '#vc_ui-panel-templates';
	} else {
		TemplatePanelEditorBackend = vc.TemplatesPanelViewBackend.extend( templateOptions );
		TemplatePanelEditorFrontend = vc.TemplatesPanelViewFrontend.extend( templateOptions );
		templatePanelSelector = '#vc_templates-panel';
	}
	if ( window.pagenow && 'template_manager' === window.pagenow ) {
		if ( window.vc_user_access && window.vc &&  window.vc.visualComposerView ) {
			window.vc.visualComposerView.prototype.initializeAccessPolicy = function () {
				this.accessPolicy = {
					be_editor: vc_user_access().editor( 'backend_editor' ),
					fe_editor: false,
					classic_editor: ! vc_user_access().check( 'backend_editor', 'disabled_ce_editor', undefined, true )
				};
			}
		}
	}
	$( document ).ready( function () {
		// we need to update currect template panel to new one (extend functionality)
		if ( window.vc_mode && window.vc_mode === 'admin_page' ) {
			if ( vc.templates_panel_view ) {
				vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
				vc.templates_panel_view = template_editor = new TemplatePanelEditorBackend( { el: templatePanelSelector } );

				$( '#vc-template-editor-button' ).click( function ( e ) {
					e && e.preventDefault && e.preventDefault();
					vc.templates_panel_view.render().show(); // make sure we show our window :)
				} );
			}
		}
	} );

	$( window ).on( 'vc_build', function () {
		if ( window.vc && window.vc.templates_panel_view ) {
			vc.templates_panel_view.undelegateEvents(); // remove is required to detach event listeners and clear memory
			vc.templates_panel_view = template_editor = new TemplatePanelEditorFrontend( { el: templatePanelSelector } );

			$( '#vc-template-editor-button' ).click( function ( e ) {
				e && e.preventDefault && e.preventDefault();
				vc.templates_panel_view.render().show(); // make sure we show our window :)
			} );
		}
	} );
})( window.jQuery );
