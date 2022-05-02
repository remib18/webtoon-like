<?php

namespace WebtoonLike\tests;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\utils\DataTesting\DataField;
use WebtoonLike\Site\utils\DataTesting\DataType;
use WebtoonLike\Site\utils\DataTesting\DataVerification;
use WebtoonLike\Site\utils\DataTesting\Regex;

/* Tests for strings */

$a = new DataField('test', DataType::string, false, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField('', DataType::string, false, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField('aaa', DataType::string, false, 1, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField('aaa', DataType::string, false, 4, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField('aaaaa', DataType::string, false, 2, 3, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField('aaaaa', DataType::string, false, 2, 16, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField("<www>", DataType::string, false, 2, 16, '/^[a-zA-Z0-9_\-]/');
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';

$a = new DataField("Tester", DataType::string, false, 2, 16, '/^[a-zA-Z0-9_\-]/');
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


/* Tests for emails */

echo "<hr>";

$a = new DataField("test@test.com", DataType::email, false, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';


$a = new DataField("testtest.com", DataType::email, false, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';

$a = new DataField("", DataType::email, true, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';

$a = new DataField("", DataType::email, false, null, null, null);
$res = DataVerification::verify($a);

echo '<pre>' . var_dump($res) . '</pre>';
