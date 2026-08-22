@block @block_oerexchangecontributors @javascript
Feature: Add the OER Exchange contributors block to the Dashboard
  In order to discover and recognise the people sharing to the Exchange
  As a user
  I need to be able to add the block to my Dashboard

  Scenario: An admin adds the block to their Dashboard and it renders correctly
    Given I log in as "admin"
    And I visit "/my/"
    And I turn editing mode on
    When I add the "OER Exchange: contributors" block
    Then I should see "No one has published to this Exchange yet." in the "OER Exchange: contributors" "block"
    And "See all contributors" "link" should exist in the "OER Exchange: contributors" "block"

  Scenario: The sort control offers every sort order
    Given I log in as "admin"
    And I visit "/my/"
    And I turn editing mode on
    And I add the "OER Exchange: contributors" block
    Then "Sort by" "select" should exist in the "OER Exchange: contributors" "block"
    And the "Sort by" select box should contain "Most resources shared"
    And the "Sort by" select box should contain "Most courses shared"
    And the "Sort by" select box should contain "Recently shared"
