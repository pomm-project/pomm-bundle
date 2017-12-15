Feature: Autowire

  Scenario:
    When I am on "/app_dev.php/get_autowire/test"
    Then I should see "test => value"