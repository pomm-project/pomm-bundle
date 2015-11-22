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
     * @Then I should see the debug toolbar
     */
    public function debugToolbar()
    {
        $this->assertElementOnPage('.sf-toolbar');
    }

    /**
     * @Then I should see the :name profiler toolbar
     */
    public function pommToolbar($name)
    {
        sleep(2);
        $selector = sprintf('a[href$="?panel=%s"]', $name);
        return $this->assertSession()
            ->elementExists('css', $selector);
    }

    /**
     * @When I click on the :name toolbar icon
     */
    public function clickPommToolbar($name)
    {
        $link = $this->pommToolbar($name);
        $link->click();
    }
}
