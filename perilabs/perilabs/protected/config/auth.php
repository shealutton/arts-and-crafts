<?php
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'guest',
        'bizRule' => null,
        'data' => null
    ),

    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'user',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'manager',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'admin',
        'children' => array(
            'manager',
        ),
        'bizRule' => null,
        'data' => null
    )
);
?>
