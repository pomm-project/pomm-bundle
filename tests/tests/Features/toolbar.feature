Feature: Web debug toolbar

    Scenario:
        When I am on homepage
        Then I should see the debug toolbar

    @javascript
    Scenario:
        When I am on homepage
        Then I should see the pomm profiler toolbar

    @javascript
    Scenario: Query
        When I am on homepage
        And I click on the pomm toolbar icon
        Then I should see "Queries"

    @javascript
    Scenario: Timeline
        When I am on homepage
        And I click on the time toolbar icon
        Then I should see "pomm"
