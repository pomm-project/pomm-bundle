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

    /**
     * @@Then /^the response status code should be (?P<code>\d+)$/
     */
    public function assertResponseStatus($code)
    {
        // Add curl function for support sf2.8 to Sf5 because goutte-driver doesn't support.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getSession()->getCurrentUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code !== $responseCode) {
            throw new \Exception('The HTTP response is not correct');
        }

    }

}
