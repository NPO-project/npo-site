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
        list($id, $name, $ally, $villages, $points, $rank) = array_map('urldecode', explode(',', $data_line));

        if (!$player = $this->get($id))
            $player = new \Npo\Entity\Player;

        $player->id = $id;
        $player->name = $name;
        $player->points = $points;
        $player->rank = $rank;

        return $player;
    }
}
