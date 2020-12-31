<?php

// TODO: Might be worthwhile extracting all common trans and putting them ina global/generic file
return [
    'title'     => 'Menus',
    'sub_title' => 'Menus List',
    'archived'  => 'Archived',
    'empty'     => 'No Menus Found.',
    'required'  => 'required',
    'actions'   => [
        'create'  => 'Add Menu',
        'edit'    => 'Edit Menu',
        'show'    => 'Show',
        'delete'  => 'Delete',
        'restore' => 'Restore',
        'save'    => 'Save',
    ],
    'fields'    => [
        'name'          => 'Name',
        'description'   => 'Description',
        'status'        => 'Status',
        'type'          => 'Type',
        'currency'      => 'Currency',
        'layout'        => 'Menu Layout',
        'order'         => 'Order',
        'header_text'   => 'Header Text',
        'footer_text'   => 'Footer Text',
        'publish_at'    => 'Publish Date',
        'notes'         => 'Notes',
        'internal_only' => 'Internal only',
        'author'        => 'Created By',
        'created_at'    => 'Created At',
        'actions'       => 'Actions',
    ],
    'filter'    => [
        'title'  => 'Filter',
        'action' => 'Filter Menus',
        'clear'  => 'Clear Filter',
    ],
    'headings'  => [
        'basic_card' => 'Basic Details',
        'extra_card' => 'Extra Details',
    ],
];
