<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\RulesSkeleton\TestsConfiguration();
$testsConfiguration->setHasTables(false);
$testsConfiguration->setHasAuthors(false);
$testsConfiguration->setHasProtectedAccess(false);
$testsConfiguration->setCanBeBoughtOnEshop(false);
$testsConfiguration->setHasCharacterSheet(false);
$testsConfiguration->setHasLinksToJournals(false);
$testsConfiguration->setHasLinkToSingleJournal(false);
$testsConfiguration->setHasDebugContacts(false);
$testsConfiguration->setHasIntroduction(false);
$testsConfiguration->setBlockNamesToExpectedContent([]);