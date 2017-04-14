Feature: Entity Param Converter

    Scenario: property list
        When I am on "/app_dev.php/property"
        Then I should see "name/value"

    Scenario: property type
        When I am on "/app_dev.php/property/name"
        Then I should see "string"
