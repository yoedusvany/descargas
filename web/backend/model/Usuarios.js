/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.Usuarios', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'username', type: 'string'},
        {name: 'email', type: 'string'},
        {name: 'rol', type: 'string'}
    ]
});