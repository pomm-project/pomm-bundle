Feature: Entity Serialization

    Scenario:
        When I am on "/app_dev.php/serialize/test"
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
