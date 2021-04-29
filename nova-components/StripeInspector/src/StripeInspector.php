<?php

namespace Acme\StripeInspector;

use Laravel\Nova\ResourceTool;

class StripeInspector extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Stripe Inspector';
    }
    public function issuesRefunds()
    {
        return $this->withMeta(['issuesRefunds' => true]);
    }


    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'stripe-inspector';
    }
}
