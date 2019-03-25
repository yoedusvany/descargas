/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.ResumenUsuarios', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'usuario', type: 'string'},
        {name: 'cantDescargas', type: 'int'},
        {name: 'size', type: 'number'},
        {name: 'nacionales', type: 'string'},
        {name: 'internacionales', type: 'string'}
    ]
    
});