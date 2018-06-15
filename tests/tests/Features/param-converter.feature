Feature: Entity Param Converter

    Scenario:
        When I am on "/app_dev.php/get/test"
        Then the response status code should be 200
        Then I should see "test => value"

    Scenario:
        When I am on "/app_dev.php/get"
        Then the response status code should be 200
        Then I should see "config => null"

    Scenario:
        When I am on "/app_dev.php/get_session_default/test"
        Then the response status code should be 200
        Then I should see "test => value"

    Scenario:
        When I am on "/app_dev.php/get_session_1/test"
        Then the response status code should be 200
        Then I should see "test => value"

    Scenario:
        When I am on "/app_dev.php/get_session_2/test"
        Then the response status code should be 200
        Then I should see "test => value_db2"
