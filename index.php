<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/Lab7/';

$data = checkPost();
if ($data['is_ok']) {
    $file_text = serialize($data);
    var_dump($file_text);
}
function checkPost()
{
    $is_ok = true;
    $required = ['last_name', 'first_name', 'birth_date', 'birth_place', 'doc_serial', 'doc_num',
        'issue_date', 'doc_giver', 'edu_city', 'edu_serial', 'edu_place_name'];
    $data = [];

    foreach ($required as $name) {
        if (empty($_POST[$name])) {
            $is_ok = false;
            $data['bads'][$name] = true;
        }
        $data['all'][$name] = $_POST[$name];
    }

    $names = ['last_name', 'first_name'];
    foreach ($names as $name)
        if (preg_match('/^[\p{L}-]+$/u', $_POST[$name])
            != 1 || ucfirst($_POST[$name]) != $_POST[$name]) {
            $data['bads'][$name] = true;
            $is_ok = false;
        }

    if (preg_match('/^[\p{Latin}(0-9)]+$/u', $_POST['doc_serial']) != 1) {
        $data['bads']['doc_serial'] = true;
        $is_ok = false;
    }

    if (preg_match('/^[0-9]+$/u', $_POST['doc_num']) != 1) {
        $data['bads']['doc_num'] = true;
        $is_ok = false;
    }

    $data['is_ok'] = $is_ok;
    return $data;
}

function checkColor($name)
{
    if (!empty($_POST)) {
        global $data;
        if ($data['bads'][$name])
            echo 'background-color: #f49797';
    }
}

require($root . 'body.php');

