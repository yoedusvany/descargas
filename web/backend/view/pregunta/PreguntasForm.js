/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.pregunta.PreguntasForm', {
    extend: 'Ext.form.Panel',
    alias: 'widget.preguntasForm',
    requires: [
        'DescargasBackend.view.pregunta.PreguntasFormController'
    ],
    controller: 'preguntasFormController',  
    
    url: BASE_PATH + "preguntas/insertar",
    //title : 'Insertar nueva pregunta',
    layout: 'anchor',
    defaults: {
        anchor: '100%',
        labelWidth: 160,
        selectOnFocus: true,
        msgTarget: 'side'
    },
    bodyPadding: 10,

    initComponent: function() {
        Ext.apply(this, {
            defaults: {
                anchor: '95%',
                allowBlank: false,
                selectOnFocus: true,
                msgTarget: 'side'
            },
            items: [{
                    xtype: 'textarea',
                    fieldLabel: 'Pregunta:',
                    name: 'pregunta',
                    allowBlank: false
                }],
            buttons: [{
                    text: 'Reset',
                    icon: BASE_PATH + 'web/images/reset.png',
                    handler: function() {
                        this.up('form').getForm().reset();
                    }
                }, {
                    text: 'Insertar',
                    icon: BASE_PATH + 'web/images/add.png',
                    formBind: true, //only enabled once the form is valid
                    disabled: true,
                    listeners: {
                        click: {fn: 'onSubmit'}
                    }
                }]
        });

        this.callParent(arguments);
    }

});