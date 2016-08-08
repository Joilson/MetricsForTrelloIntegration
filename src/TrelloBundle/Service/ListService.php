<?php

namespace TrelloBundle\Service;

class ListService
{

    public function getAllIdLists()
    {
        return [
            'homolog' => '56cde648b6815a552e5f9065',
        ];
    }

    public function getIdListBy($key)
    {
        $lists = $this->getAllIdLists();

        if ($key) {
            if (!isset($lists[$key])) {
                throw new \Exception("Lista não encontrada [{$key}]");
            }
            return [$lists[$key]];
        }
        return $lists;
    }

}
