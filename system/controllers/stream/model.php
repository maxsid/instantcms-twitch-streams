<?php

class modelStream extends cmsModel {

    const TABLE_AUTH = "stream_auth";
    const TABLE_CHANNEL = "stream_channels";
    const TABLE_BANNED_CHANNEL = "stream_banned_channels";

    public function setChannel($channel){
        $this->resetFilters();
        return $this->insertOrUpdate($this::TABLE_CHANNEL, $channel);
    }
    
    public function getChannel($id){
        $this->resetFilters();
        return $this->getItemById($this::TABLE_CHANNEL, $id);
    }

    public function getPinnedChannels(){
        $this->resetFilters();
        $this->filterGt('pinned', 0);
        $this->orderBy('pinned');
        return $this->get($this::TABLE_CHANNEL, false, false);
    }

    public function getUserChannelsCount($user_id){
        $this->resetFilters();
        $this->filterEqual('owner',$user_id);
        return $this->getCount($this::TABLE_CHANNEL);
    }

    public function getPinnedChannelsCount(){
        $this->resetFilters();
        $this->filterGt('pinned', 0);
        return $this->getCount($this::TABLE_CHANNEL);
    }

    public function reorderChannelsPositions($data){
        $this->resetFilters();
        $tagged = $this->getPinnedChannels();
        $length = count($data);
        if ($length != count($tagged)) return false;

        for ($i = 0; $i < $length; $i++){ $this->resetFilters();
            if ($i + 1 != $tagged[$data[$i]-1]['pinned']){ $this->resetFilters();
                $this->setPinnedChannel($tagged[$data[$i]-1]['id'], $i + 1);
            }
        }

        return true;
    }

    public function setPinnedChannel($id, $newPosition = false){
        $this->resetFilters();
        if (is_bool($newPosition) && !$newPosition) {
            $newPosition = $this->getPinnedChannelsCount() + 1;
        } else if (is_int($newPosition) && $newPosition == 0){
            $oldPosition = $this->getChannel($id)['pinned'];
            $query = 'update {#}'.$this::TABLE_CHANNEL.' set pinned = pinned - 1 where pinned > '.$oldPosition;
            $this->db->query($query);
        }
        $this->update($this::TABLE_CHANNEL, $id, array('pinned' => $newPosition));
        return $newPosition;
    }

    public function getAllChannels(){
        $this->resetFilters();
        return $this->get($this::TABLE_CHANNEL,false,false);
    }

    public function getAllChannelsCount(){
        $this->resetFilters();
        return $this->getCount($this::TABLE_CHANNEL,false);
    }

    public function getChannelForName($name){
        $this->resetFilters();
        return $this->getItemByField($this::TABLE_CHANNEL, 'name', $name);
    }

    public function getChannelForPined($pinned){
        $this->resetFilters();
        return $this->getItem($this::TABLE_CHANNEL, 'pinned', $pinned);
    }

    public function getBannedChannel($name){
        $this->resetFilters();
        return $this->getItemByField($this::TABLE_BANNED_CHANNEL, 'name', $name);
    }

    public function banChannel($name, $reason){
        $this->resetFilters();
        if ($this->getBannedChannel($name)) return false;
        $send_array = array(
            'name' => $name,
            'owner' => cmsUser::get('id'),
            'reason' => $reason
        );
        return $this->insert($this::TABLE_BANNED_CHANNEL, $send_array);
    }

    public function unbanChannel($name){
        $this->resetFilters();
        if (($ch = $this->getBannedChannel($name))){ $this->resetFilters();
            return $this->delete($this::TABLE_BANNED_CHANNEL, $ch['id']);
        }
        return false;
    }

    public function deleteChannel($id){
        $this->resetFilters();
        return $this->delete($this::TABLE_CHANNEL, $id);
    }

    public function deleteInactive($time = false){
        if (!$time || !is_numeric($time)) return false;
        $this->resetFilters();
        $this->filterEqual('active',0);
        $this->filterAnd();
        $this->filterDateOlder('added_time',$time,'MINUTE');
        return $this->deleteFiltered($this::TABLE_CHANNEL);
    }

    public function getInactiveCount(){
        $this->resetFilters();
        $this->joinLeftOuter($this::TABLE_BANNED_CHANNEL, 'b', 'i.name = b.name');
        $this->filterIsNull('b.id');
        $this->filterEqual('i.active',0);
        return $this->getCount($this::TABLE_CHANNEL, false);
    }


    public function getAllBannedChannels(){
        $this->resetFilters();
        return $this->get($this::TABLE_BANNED_CHANNEL, function($ch, $model){ $this->resetFilters();
            return array_merge($ch, $this->getBannedChannel($ch['name']));
        });
    }

    public function getBannedChannels(){
        $this->resetFilters();
        return $this->get($this::TABLE_BANNED_CHANNEL, false, false);
    }

    public function getChannelForOwner($user_id){
        $this->resetFilters();
        return $this->getItemByField($this::TABLE_CHANNEL, 'owner', $user_id);
    }


    public function getChannelsForOwner($user_id){
        $this->resetFilters();
        $this->filter('owner = '.$user_id);
        return $this->get($this::TABLE_CHANNEL, false, false);
    }

    public function setTwitchAuthItem($item){
        $this->resetFilters();
        return $this->insertOrUpdate($this::TABLE_AUTH, $item);
    }

    public function getTwitchAuthItem($user_id){
        $this->resetFilters();
        return $this->getItemById($this::TABLE_AUTH, $user_id);
    }

    public function isAuthenticated($user_id){
        $this->resetFilters();
        $this->filterEqual('id',$user_id);
        return $this->getCount($this::TABLE_AUTH);
    }

    public function getActiveChannels(){
        $this->resetFilters();
        $this->joinLeftOuter($this::TABLE_BANNED_CHANNEL, 'b', 'i.name = b.name');
        $this->filterIsNull('b.id');
        $this->filterEqual('i.active',1);
        $this->orderBy('pinned');
        return $this->get($this::TABLE_CHANNEL, false, false);
    }

    public function getActiveChannelsCount(){
        $this->resetFilters();
        $this->joinLeftOuter($this::TABLE_BANNED_CHANNEL, 'b', 'i.name = b.name');
        $this->filterIsNull('b.id');
        $this->filterEqual('i.active',1);
        return $this->getCount($this::TABLE_CHANNEL, false);
    }

    ///Все что ниже, не делает запросов к БД
    public function quick_sort(&$array,$path_to_num = false, $min_to_first = false, $left = false, $right = false)
    {
        if (!$left) $left = 0;
        if (!$right) $right = count($array) - 1;
        if ($right < 1) return;
        $l = $left;
        $r = $right;

        $center = $this->getElementForPath($array[(int)($left + $right) / 2], $path_to_num);
        do {
            if ($min_to_first) {
                while ($this->getElementForPath($array[$r], $path_to_num) > $center) {
                    $r--;
                }
                while ($this->getElementForPath($array[$l], $path_to_num) < $center) {
                    $l++;
                }
            } else {
                while ($this->getElementForPath($array[$r], $path_to_num) < $center) {
                    $r--;
                }
                while ($this->getElementForPath($array[$l], $path_to_num) > $center) {
                    $l++;
                }
            }
            if ($l <= $r) {
                $this->swap($array, $l, $r);
                $l++;
                $r--;
            }
        } while ($l <= $r);

        if ($r > $left) {
           $this->quick_sort($array,$path_to_num,$min_to_first, $left, $r);
        }

        if ($l < $right) {
            $this->quick_sort($array,$path_to_num, $min_to_first, $l, $right);
        }
    }

    private function swap(&$array, $i1, $i2){
        $j = $array[$i2];
        $array[$i2] = $array[$i1];
        $array[$i1] = $j;
    }

    public function getElementForPath($array, $path){
        if (!$path) return $array;
        $cur_el = $array;
        foreach($path as $el){ $this->resetFilters();
            $cur_el = $cur_el[$el];
        }
        return $cur_el;
    }
}