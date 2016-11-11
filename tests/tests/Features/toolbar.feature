Feature: Web debug toolbar

    Scenario:
        When I am on homepage
        Then I should see the debug toolbar

    Scenario: Query
        When I am on the pomm profiler
        Then I should see "Queries"

    Scenario: Timeline
        When I am on the timeline
        Then I should see "pomm"
