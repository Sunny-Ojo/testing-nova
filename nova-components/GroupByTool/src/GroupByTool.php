<?php

namespace Workdoneright\GroupByTool;

use Laravel\Nova\ResourceTool;

class GroupByTool extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Group_By_Tool';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'group_by_tool';
    }
}
