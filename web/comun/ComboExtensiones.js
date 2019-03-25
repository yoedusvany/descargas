/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Comun.ComboExtensiones',{
    extend : 'Ext.form.ComboBox',
    alias: 'widget.comboExtensiones',
    
    //store: 'Descargas.store.descargas.Extensiones',
    store: 'Extensiones',
    displayField: 'ext',
    valueField: 'ext',
    fieldLabel : 'Extensi&oacute;n',
    labelWidth : 65,
    
    initComponent: function () {
        var me = this;
        var s = me.createExtStore();
        me.store = s;
        
        me.callParent();
    },
    
    createExtStore: function () {
        return Ext.create('Descargas.store.descargas.Extensiones');
    }
});