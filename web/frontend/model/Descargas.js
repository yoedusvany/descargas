
Ext.define('Descargas.model.Descargas', {
    extend: 'Ext.data.Model',
    idProperty: 'id_file',

    fields: [
        {name: 'id_file', type: 'int'},
        {name: 'name', type: 'string'},
        {name: 'ext', type: 'string'},
        {name: 'size', type: 'int'},
        {name: 'url', type: 'string'},
        {name: 'date', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'finalized', type: 'string'},
        {name: 'desc', type: 'string'}
    ]
});