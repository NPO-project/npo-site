<?php
namespace Npo\Model;

class Tribes
    extends RankingModelAbstract 
{
    protected $_entity = '\Npo\Entity\Tribe';

    protected function _migrateRecord($data_line)
    {
        $em = $this->getEntityManager();
        list($id, $name, $tag, $members, $villages, $points, $all_points, $rank) = array_map('urldecode', explode(',', $data_line));

        if (!$tribe = $this->get($id)) 
            $tribe = new \Npo\Entity\Tribe;

        $tribe->id = $id;
        $tribe->name = $name;
        $tribe->tag = $tag;
        $tribe->points = $points;
        $tribe->rank = $rank;

        return $tribe;
    }
}
