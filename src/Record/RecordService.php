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
        $ret = $this->exec("objects/object_$objId/records/$rkrdId", null);

        $rkrds = json_decode($ret);

        return $rkrds;
    }
}