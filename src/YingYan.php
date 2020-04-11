<?php
/**
 * Created by PhpStorm.
 * User: aoxiang
 * Date: 2020-04-11
 * Time: 11:36
 */

namespace Aoxiang\YingYan;

use GuzzleHttp\Client;

class YingYan
{
    protected $ak, $serviceId, $params, $response;
    protected $guzzleOptions = [];

    public function __construct($ak, $serviceId)
    {
        $this->ak        = $ak;
        $this->serviceId = $serviceId;
    }

    /**
     * @param $entityName
     * @param string $entityDesc
     * @param string $fields 用户自定义字段
     * @return mixed
     * @throws \Exception
     */
    public function addEntity($entityName, $entityDesc = '', array $fields = [])
    {
        $url   = 'http://yingyan.baidu.com/api/v3/entity/add';
        $query = $this->buildParams(array_filter(array_merge([
            'entity_name' => $entityName,
            'entity_desc' => $entityDesc,
        ], array_filter($fields))));
        return $this->post($url, $query)->getResponse();
    }

    /**
     * @param $entityName
     * @param string $entityDesc
     * @param string $fields 用户自定义字段
     * @return mixed
     * @throws \Exception
     */
    public function updateEntity($entityName, $entityDesc = '', array $fields = [])
    {
        $url   = 'http://yingyan.baidu.com/api/v3/entity/update';
        $query = $this->buildParams(array_filter(array_merge([
            'entity_name' => $entityName,
            'entity_desc' => $entityDesc,
        ], array_filter($fields))));
        return $this->post($url, $query)->getResponse();
    }

    /**
     * @param string $filter
     * @param string $coord_type_output
     * @param int $page_index
     * @param int $page_size
     * @return mixed
     * @throws \Exception
     */
    public function getEntityList($filter = '', $coord_type_output = '', $page_index = 1, $page_size = 10)
    {
        $url   = 'http://yingyan.baidu.com/api/v3/entity/list';
        $query = $this->buildParams(array_filter([
            'fitler'            => $filter,
            'coord_type_output' => $coord_type_output,
            'page_index'        => $page_index,
            'page_size'         => $page_size,
        ]));
        return $this->get($url, $query)->getResponse();
    }

    public function deleteEntity($entityName)
    {
        $url   = 'http://yingyan.baidu.com/api/v3/entity/delete';
        $query = $this->buildParams(array_filter([
            'entity_name' => $entityName,
        ]));
        return $this->post($url, $query)->getResponse();
    }


    /**
     * http://lbsyun.baidu.com/index.php?title=yingyan/api/v3/trackupload
     * @param $entityName
     * @param $latitude
     * @param $longitude
     * @param $loc_time
     * @param $coord_type_input
     * @param $fields 速度，方向，高度，精度以及其他自定义字段
     * @return mixed
     * @throws \Exception
     */
    public function addTrack($entityName, $latitude, $longitude, $loc_time, $coord_type_input = 'bd09ll', array $fields = [])
    {
        $url    = 'http://yingyan.baidu.com/api/v3/track/addpoint';
        $params = array_merge([
            'entity_name'      => $entityName,
            'latitude'         => $latitude,
            'longitude'        => $longitude,
            'loc_time'         => $loc_time,
            'coord_type_input' => $coord_type_input,
        ], array_filter($fields));
        $query  = $this->buildParams(array_filter($params));
        return $this->post($url, $query)->getResponse();
    }

    /**http://lbsyun.baidu.com/index.php?title=yingyan/api/v3/trackupload
     * @param array $pointList
     * @return mixed
     * @throws \Exception
     */
    public function addTrackList($pointList = [])
    {
        $url = 'http://yingyan.baidu.com/api/v3/track/addpoints';

        $query = $this->buildParams([
            'point_list' => json_encode($pointList),
        ]);
        return $this->post($url, $query)->getResponse();
    }


    /**
     * @param $url
     * @param array $query
     * @return $this
     * @throws \Exception
     */
    protected function get($url, array $query)
    {
        try {
            $this->response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();
            return $this;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }


    protected function post($url, array $query)
    {
        try {
            $this->response = $this->getHttpClient()->post($url, [
                'form_params' => $query,
            ])->getBody()->getContents();
            return $this;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }


    protected function getResponse()
    {
        try {
            $response = json_decode($this->response, true);
            if (is_array($response)) {
                return $response;
            } else {
                //解析非json，肯定出毛病了
                throw new \Exception('返回数据非JSON格式');
            }
            return $response;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }


    }

    protected function buildParams(array $params)
    {
        return array_merge([
            'ak'         => $this->ak,
            'service_id' => $this->serviceId,
        ], $params);
    }

    protected function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    protected function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

}