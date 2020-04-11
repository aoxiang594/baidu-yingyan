## 百度鹰眼轨迹Web服务API

百度接口总览[http://lbsyun.baidu.com/index.php?title=yingyan/api/v3/all](http://lbsyun.baidu.com/index.php?title=yingyan/api/v3/all)

![StyleCI build status](https://github.styleci.io/repos/254778255/shield) 

**注意**这个package只对接了`终端管理`、`轨迹上传`接口，其他围栏、轨迹纠偏等没有对接。

#### 使用方法

通过composer安装

```shell
composer require aoxiang/baidu-yingyan
```



传入对应的service_id\AK

```php
$ak        = 'yU1QNKOLqn7FqZMjLLxqI2dF';
$server_id = '220271';
$yingyan   = new YingYan($ak, $server_id);
//添加终端
$res = $yingyan->addEntity('aoxiang-test');
//删除终端
$res = $yingyan->deleteEntity('aoxiang-test-165');
//修改终端
$res = $yingyan->updateEntity('123456', '测试修改描述','');
//获取终端列表
$res = $yingyan->getEntityList();
//为终端名为123456中终端，上传轨迹点
$res = $yingyan->addTrack('123456', 39.220121, 116.46365, 1586586922, 'bd09ll',
    ['speed'     => 100,
     'direction' => '23',
     'height'    => 300,
    ]);
//批量上传轨迹点
//先造一些假数据
$item = [
    'entity_name'      => '123456',
    'latitude'         => 30.691794,
    'longitude'        => 117.860935,
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
$res = $yingyan->addTrackList( $list);
```
更多内容、详细参数等请参考官方文档及这个鬼源码，这源码简直是整个GitHub最简单的package



