<?php
global $testsConfiguration;
$testsConfiguration = new \DrdPlus\Tests\RulesSkeleton\TestsConfiguration('https://drdplus.info');
$testsConfiguration->disableHasTables()
    ->setSomeExpectedTableIds([])
    ->disableHasAuthors()
    ->disableHasProtectedAccess()
    ->disableCanBeBoughtOnEshop()
    ->disableHasCharacterSheet()
    ->disableHasLinksToJournals()
    ->disableHasLinkToSingleJournal()
    ->disableHasDebugContacts()
    ->disableHasCustomBodyContent()
    ->disableHasTableOfContents()
    ->disableHasHeadings()
    ->setBlockNamesToExpectedContent([])
    ->setExpectedWebName('DrD+ pravidla a odkazy')
    ->setExpectedPageTitle('📚 DrD+ pravidla a odkazy')
    ->disableHasLocalLinks()
    ->setExpectedGoogleAnalyticsId('UA-121206931-1')
    ->disableHasMoreVersions()
    ->setExpectedLastVersion('master');
