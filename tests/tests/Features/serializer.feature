Feature: Entity Serialization

    Scenario:
        When I am on "/app_dev.php/serialize"
        Then the response status code should be 200
        Then the response should be in JSON
        And the JSON should be equal to:
        """
        [
            {
                "point": {
                    "x": 1,
                    "y": 2
                }
            }
        ]
        """

    Scenario:
        When I am on "/app_dev.php/deserialize"
        Then the response status code should be 200
        Then I should see "AppBundle\Model\MyDb1\PublicSchema\Config"
        And I should see "'name' => 'test'"
        And I should see "'value' => 'ok'"
