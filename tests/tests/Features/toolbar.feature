Feature: Web debug toolbar

    Scenario:
        When I am on homepage
        Then the response status code should be 200
        Then I should see the debug toolbar

    Scenario: Query
        When I am on the pomm profiler
        Then the response status code should be 200
        Then I should see "Queries"

    Scenario: Timeline
        When I am on the timeline
        Then the response status code should be 200
        Then I should see "pomm"
