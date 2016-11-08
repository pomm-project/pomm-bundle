Feature: Entity Param Converter

    Scenario:
        When I am on "/app_dev.php/get/test"
        Then I should see "test => value"

    Scenario:
        When I am on "/app_dev.php/get/"
        Then I should see "config => null"
