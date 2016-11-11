<?php

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    public function iAmOnHomepage()
    {
        $this->visitPath('/app_dev.php');
    }

    /**
     * @When I am on production homepage
     */
    public function productionHomepage()
    {
        $this->visitPath('/app.php');
    }

    /**
     * @When I am on the pomm profiler
     */
    public function iAmOnThePommProfiler()
    {
        $this->visitPath('/app_dev.php/_profiler/latest?panel=pomm');
    }

    /**
     * @When I am on the timeline
     */
    public function iAmOnTheTimeline()
    {
        $this->visitPath('/app_dev.php/_profiler/latest?panel=time');
    }

    /**
     * @Then I should see the debug toolbar
     */
    public function debugToolbar()
    {
        $this->assertElementOnPage('.sf-toolbar');
    }
}
