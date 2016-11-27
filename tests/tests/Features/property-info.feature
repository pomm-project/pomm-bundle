Feature: Entity Param Converter

    Scenario: property type
        When I am on "/app_dev.php/property/name"
        Then I should see "string"
