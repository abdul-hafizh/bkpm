<?php

namespace SimpleCMS\Menu\Presenters\Admin;

use SimpleCMS\Menu\MenuItem;
use SimpleCMS\Menu\Presenters\Presenter;

class Adminlte3Presenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL .'<ul id="backend-sidebar" class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false" >'. PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        if (count($item->attributes) && isset($item->attributes['class']))
        {
            $item->attributes['class'] .= ' nav-link ' . $this->getActiveState($item);
        }else{
            $item->attributes['class'] = ' nav-link ' . $this->getActiveState($item);
        }
        return '<li class="nav-item ' . $this->getActiveState($item) . '"><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' <p>' . trans($item->title) . '</p></a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = ' active ')
    {
        if (isset($item->active) && is_array($item->active)){
            return ActiveRoute($item->active, $state) ?: null;
        }
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = ' active')
    {
        if (isset($item->active) && is_array($item->active)){
            return ActiveRoute($item->active, $state) ?: null;
        }
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="header">' . trans($item->title) . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li class="nav-item has-treeview' . $this->getActiveStateOnChild($item, ' menu-open') . '">
              <a class="nav-link ' . $this->getActiveStateOnChild($item, ' active') . '" href="#">
                ' . $item->getIcon() . ' <p>' . trans($item->title) . '<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                ' . $this->getChildMenuItems($item) . '
              </ul>
            </li>'
            . PHP_EOL;
   }

    public function getSubmenuWithoutDropdownWrapper($item)
    {
        return '<li class="nav-item ' . $this->getActiveState($item) . '"><a class="nav-link ' . $this->getActiveState($item) . '" href="' . $item->getUrl() . '">
            ' . $item->getIcon() . ' ' . '<p>' . trans($item->title) . '</p>
        </a></li>' . PHP_EOL;
    }

    public function getChildMenuItems(MenuItem $item)
    {
        $results = '';
        foreach ($item->getChilds() as $child) {
            if ($child->hidden()) {
                continue;
            }

            if ($child->hasSubMenu()) {
                $results .= $this->getMultiLevelDropdownWrapper($child);
            } elseif ($child->isHeader()) {
                $results .= $this->getHeaderWrapper($child);
            } elseif ($child->isDivider()) {
                $results .= $this->getDividerWrapper();
            } else {
                $results .= $this->getSubmenuWithoutDropdownWrapper($child);
            }
        }

        return $results;
    }

    public function getMultiLevelDropdownWrapper($item)
    {
        return $this->getMenuWithDropDownWrapper($item);
    }
}
