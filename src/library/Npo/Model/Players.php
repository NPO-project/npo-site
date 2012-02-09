<?php
namespace Npo\Model;

class Players
    extends RankingModelAbstract 
{
    protected $_entity = '\Npo\Entity\Player';
    protected $_join = 'LEFT JOIN o.tribe t';
     
    protected function _migrateRecord($data_line)
    {
        $em = $this->getEntityManager();
        $player = new \Npo\Entity\Player;
        $tribe = null;
        list($id, $name, $ally, $villages, $points, $rank) = array_map('urldecode', explode(',', $data_line));

        if ($ally !== 0)
            $tribe = $em->find('\Npo\Entity\Tribe', $ally);

        $player->id = $id;
        $player->name = $name;
        $player->points = $points;
        $player->rank = $rank;
        $player->tribe = $tribe;

        return $player;
    }
}
