<?php

namespace SimpleCMS\Widget;

use SimpleCMS\Widget\Contracts\ApplicationWrapperContract;

class WidgetGroupCollection
{
    /**
     * The array of widget groups.
     *
     * @var array
     */
    protected $groups;

    /**
     * Constructor.
     *
     * @param ApplicationWrapperContract $app
     */
    public function __construct(ApplicationWrapperContract $app)
    {
        $this->app = $app;
    }

    /**
     * Get the widget group object.
     *
     * @param $sidebar_id
     *
     * @return WidgetGroup
     */
    public function group($sidebar_id)
    {
        if (isset($this->groups[$sidebar_id])) {
            return $this->groups[$sidebar_id];
        }
        $this->groups[$sidebar_id] = new WidgetGroup(['id' => $sidebar_id, 'name' => $sidebar_id], $this->app);
        return $this->groups[$sidebar_id];
    }

    /**
     * @param $args
     * @return $this|mixed
     *
     */
    public function setGroup($args)
    {
        if (isset($this->groups[$args['id']])) {
            return $this->groups[$args['id']];
        }

        $this->groups[$args['id']] = new WidgetGroup($args, $this->app);
        return $this;
    }

    /**
     * @param $group_id
     * @return $this
     *
     */
    public function removeGroup($group_id)
    {
        if (isset($this->groups[$group_id])) {
            unset($this->groups[$group_id]);
        }
        return $this;
    }

    /**
     * @return array
     *
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
