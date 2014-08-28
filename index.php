<?php
require_once 'lib/consolelog.class.php';

$foo = 'bar';
$bar = 123;
$var_array = array(
    1,
    2,
    array(
        'key_a' => 'val_a',
        'key_b' => 'val_b',
        array(
            'b3',
            'c4'
        )
    )
);

$log = new ConsoleLog();

$log->log($foo, $bar);
$log->log(1, 0.123, 'foo');
$log->log(true, false, null);
$log->log($var_array, array(
    'a' => 'A',
    'b' => 'B'
));

$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
$log->log($json);

$book = new stdClass();
$book->title = "Some Book Title";
$book->author = "Author Name";
$book->publication = 1978;
$log->log($book);

$log->obj($var_array);
$log->obj($book);
$log->obj($json);
$log->obj($foo, 1);

class JustTest
{

    public function __construct()
    {
        $new_log = new ConsoleLog();
        $new_log->log('test', 36481723);
    }
}

$test = new JustTest();