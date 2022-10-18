<?php

return [
    [
        'action' => 'createCodeSnippet',
        'caption' => 'EXT:examples/Classes/Command/DoSomethingCommand.php',
        'sourceFile' => 'EXT:examples/Classes/Command/DoSomethingCommand.php',
        'targetFileName' => 'Tutorials/Command/Classes/DoSomethingCommand.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => T3docs\Examples\Command\CreateWizardCommand::class,
        'members' => [
            'configure'
        ],
        'targetFileName' => 'Tutorials/Command/Classes/CreateWizardCommandConfiguration.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => T3docs\Examples\Command\CreateWizardCommand::class,
        'members' => [
            'execute'
        ],
        'targetFileName' => 'Tutorials/Command/Classes/CreateWizardCommandExecute.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => T3docs\Examples\Command\CreateWizardCommand::class,
        'members' => [
            'doMagic'
        ],
        'targetFileName' => 'Tutorials/Command/Classes/CreateWizardCommandIo.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => T3docs\Examples\Command\MeowInformationCommand::class,
        'members' => [
            '__construct'
        ],
        'targetFileName' => 'Tutorials/Command/Classes/DependencyInjection.rst.txt',
    ],
];
