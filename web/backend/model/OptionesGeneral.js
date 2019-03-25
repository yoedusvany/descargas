/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.OptionesGeneral', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'path_to_save', type: 'string'},
        {name: 'size_permitido', type: 'string'},
        {name: 'cant_desc_x_user', type: 'string'},
        {name: 'proxy', type: 'string'},
        {name: 'proxy_port', type: 'string'},
        {name: 'proxy_user', type: 'string'},
        {name: 'proxy_pass', type: 'string'},
        {name: 'proxy_use', type: 'boolean'}
    ]
});