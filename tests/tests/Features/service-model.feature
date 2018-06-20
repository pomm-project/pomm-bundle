Feature: Model as service

    Scenario:
        When I am on "/app_dev.php/serviceModel"
        Then the response status code should be 200
        Then I should see "Created model as service. Sum:2"

    Scenario:
        When I am on "/app_dev.php/serviceContainer"
        Then the response status code should be 200
        Then I should see "Model from container as service. Sum:2"
