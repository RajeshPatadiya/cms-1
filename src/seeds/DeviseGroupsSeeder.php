<?php

class DeviseGroupsSeeder extends DeviseSeeder
{
    /**
     * [run description]
     * @return [type]
     */
    public function run()
    {
        $groups = $this->createGroups();
    }

    /**
     * [createGroups description]
     * @return [type]
     */
    public function createGroups()
    {
        return $this->findOrCreateRows('groups', 'name',
        [
            [ 'name' => 'Developer' ],
            [ 'name' => 'Administrator' ],
        ]);
    }

}