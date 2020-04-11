<?php
/**
 * Created by PhpStorm.
 * User: aoxiang
 * Date: 2020-04-11
 * Time: 11:51
 */
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/YingYan.php';

use Aoxiang\YingYan\YingYan;

$ak        = 'y7FOLqnxqIqZMjLLU1QNK2dF';
$server_id = '220271';
$yingyan   = new YingYan($ak, $server_id);
//$res = $yingyan->addEntity('aoxiang-test');
//$res = $yingyan->addEntity('aoxiang-test-' . rand(100, 999));
//$res = $yingyan->deleteEntity('aoxiang-test-165');
//$res = $yingyan->updateEntity('123456', '测试修改描述','');
//$res = $yingyan->getEntityList();
$list = [];
$item = [
    'entity_name'      => '123456',
    'latitude'         => 28.691794,
    'longitude'        => 115.860935,
    'loc_time'         => 1586574000,
    'coord_type_input' => 'bd09ll',
    'speed'            => 100,
    'direction'        => '23',
    'height'           => 300,
];
for ($i = 0; $i < 20; $i++) {
    $item   = [
        'entity_name'      => '123456',
        'latitude'         => $item['latitude'] + $i * 0.0001 * rand(1, 100),
        'longitude'        => $item['longitude'] + $i * 0.0001 * rand(1, 100),
        'loc_time'         => strval($item['loc_time'] + $i * rand(1, 60)),
        'coord_type_input' => 'bd09ll',
        'speed'            => 100,
        'direction'        => '23',
        'height'           => 300,
    ];
    $list[] = $item;
}
//foreach($list as $item)
//{
//    var_dump(date('Y-m-d H:i:s',$item['loc_time']));
//}
//var_dump($list);
//exit;
//$res = $yingyan->addTrack('123456', 39.220121, 116.46365, 1586586922, 'bd09ll',
//    ['speed'     => 100,
//     'direction' => '23',
//     'height'    => 300,
//    ]);
$res = $yingyan->addTrackList( $list);
var_dump($res);