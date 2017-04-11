<?php

namespace KnackRestApi\Record;

use KnackRestApi\KnackClient;

class RecordService extends KnackClient
{
    /**
     * @param integer $objId id of Knack object
     * @param array $data post data params
     *
     * get all records list for object.
     *
     * @return array of Std class
     */
    public function getAllObjectRecords($objId, $data = null)
    {
        if (is_array($data) && isset($data['filters'])){
            $data['filters'] = json_encode($data['filters']);
        }

        $ret = $this->exec("objects/object_$objId/records", $data);

        $rkrds = json_decode($ret);

        return $rkrds;
    }

    /**
     * @param integer $objId id of Knack object
     * @param integer $rkrdId id of Knack record for $objId object
     *
     * get one record for object.
     *
     * @return array of Std class
     */
    public function getObjectRecord($objId, $rkrdId)
    {
        $ret = $this->exec("objects/object_$objId/records/{$rkrdId}", null);

        $rkrds = json_decode($ret);

        return $rkrds;
    }

    /**
     * @param integer $objId id of Knack object
     * @param array $data post data params
     *
     * Create new record for object.
     *
     * @return array of Std class
     */
    public function createObjectRecord($objId, $data){
        $data = json_encode($data);

        $ret = $this->exec("objects/object_$objId/records", $data, 'POST');

        $rkrds = json_decode($ret);

        return $rkrds;
    }

    /**
     * @param integer $objId id of Knack object
     * @param integer $rkrdId id of Knack record for $objId object
     * @param array $data post data params
     *
     * Update record for object.
     *
     * @return array of Std class
     */
    public function updateObjectRecord($objId, $rkrdId, $data){
        $data = json_encode($data);

        $ret = $this->exec("objects/object_$objId/records/{$rkrdId}", $data, 'PUT');

        $rkrds = json_decode($ret);

        return $rkrds;
    }

    /**
     * @param integer $objId id of Knack object
     * @param integer $rkrdId id of Knack record for $objId object
     *
     * Delete record for object.
     *
     * @return array of Std class
     */
    public function deleteObjectRecord($objId, $rkrdId){
        $ret = $this->exec("objects/object_$objId/records/{$rkrdId}", array(), 'DELETE');

        $rkrds = json_decode($ret);

        return $rkrds;
    }
}