<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\RulesSkeleton\TestsConfiguration('https://drdplus.info');
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
$testsConfiguration->setExpectedWebName('DrD+ pravidla a odkazy');
$testsConfiguration->setExpectedPageTitle('📚 DrD+ pravidla a odkazy');
$testsConfiguration->disableHasMoreVersions();