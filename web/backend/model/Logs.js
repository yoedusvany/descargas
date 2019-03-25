/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.Logs', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'hora', type: 'string'},
        {name: 'ip', type: 'string'},
        {name: 'usuario', type: 'string'},
        {name: 'mensaje', type: 'string'}
    ]
    
});