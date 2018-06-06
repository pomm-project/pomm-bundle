Feature: Entity Param Converter

    Scenario: property list
        When I am on "/app_dev.php/property"
        Then the response status code should be 200
        Then I should see "name/value"

    Scenario: property type
        When I am on "/app_dev.php/property/name"
        Then the response status code should be 200
        Then I should see "string"

    Scenario: property type boolean
        When I am on "/app_dev.php/property/global"
        Then the response status code should be 200
        Then I should see "bool"