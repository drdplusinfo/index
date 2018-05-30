<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\RulesSkeleton\TestsConfiguration();
$testsConfiguration->disableHasTables();
$testsConfiguration->disableHasAuthors();
$testsConfiguration->disableHasProtectedAccess();
$testsConfiguration->disableCanBeBoughtOnEshop();
$testsConfiguration->disableHasCharacterSheet();
$testsConfiguration->disableHasLinksToJournals();
$testsConfiguration->disableHasLinkToSingleJournal();
$testsConfiguration->disableHasDebugContacts();
$testsConfiguration->disableHasIntroduction();
$testsConfiguration->disableHasCustomBodyContent();
$testsConfiguration->setBlockNamesToExpectedContent([]);