#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

require __DIR__ . '/../../.Build/vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    die('Script must be called from command line.' . chr(10));
}

use Symfony\Component\Finder\Finder;

/**
 * Check ReST files for integrity. If errors are found, they will be
 * output on stdout and the program will exit with exit code 1.
 *
 * Optional arguments: -d <directory>
 *
 * By default, the standard path is used. You can override this for
 * testing purposes.
 */
class validateRstFiles
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * @var bool
     */
    protected $isError;

    /**
     * @var string
     */
    protected $baseDir = 'Documentation';

    public function __construct(string $dir = '')
    {
        if ($dir) {
            $this->baseDir = $dir;
        }
    }

    public function validate()
    {
        printf('Searching for rst snippets in ' . $this->baseDir . chr(10));

        $count = 0;
        $finder = $this->findFiles();
        foreach ($finder as $file) {
            $filename = (string)$file;
            $this->clearMessages();
            $fileContent = $file->getContents();
            $this->validateContent($fileContent);

            if ($this->isError) {
                $shortPath = substr($filename, strlen($this->baseDir));
                $shortPath = ltrim($shortPath, '/\\');
                $count++;
                printf(
                    '%-10s | %-12s | %-17s | %s ' . chr(10),
                    $this->messages['include']['title'],
                    $this->messages['reference']['title'],
                    $this->messages['index']['title'],
                    $shortPath
                );
                if ($this->messages['include']['message']) {
                    printf($this->messages['include']['message'] . chr(10));
                }
                if ($this->messages['reference']['message']) {
                    printf($this->messages['reference']['message'] . chr(10));
                }
                if ($this->messages['index']['message']) {
                    printf($this->messages['index']['message'] . chr(10));
                }
            }
        }

        if ($count > 0) {
            fwrite(STDERR, 'Found ' . $count . ' rst files with errors, check full log for details.' . chr(10));
            exit(1);
        }
        exit(0);
    }

    public function findFiles(): Finder
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in($this->baseDir)
            ->name('/\.rst$/');

        return $finder;
    }

    protected function clearMessages()
    {
        $this->messages = [
            'include' => [
                'title' => '',
                'message' => '',
            ],
            'reference' => [
                'title' => '',
                'message' => '',
            ],
            'index' => [
                'title' => '',
                'message' => '',
            ],
        ];

        $this->isError = false;
    }

    protected function validateContent(string $fileContent)
    {
        $checkForRequired = [
            [
                'type' => 'include',
                'regex' => '#^\\.\\.\s+include::\s+\/Includes.rst.txt|\:orphan\:#m',
                'title' => 'no include',
                'message' => 'insert \'..  include:: /Includes.rst.txt\' in first line of the file',
            ],
            [
                'type' => 'include',
                'regex' => '#\={2,}\n.*\n\={2,}#m',
                'title' => 'no title',
                'message' => 'Each document must have a title with multiple === above and below',
            ],
        ];

        foreach ($checkForRequired as $values) {
            if (preg_match($values['regex'], $fileContent) !== 1) {
                $this->messages[$values['type']]['title'] = $values['title'];
                $this->messages[$values['type']]['message'] = $values['message'];
                $this->isError = true;
            }
        }

        $checkForForbidden = [
            [
                'type' => 'include',
                'regex' => '#\.\. *important::#m',
                'title' => 'admonition warning forbidden',
                'message' => 'use ".. attention" instead of ".. important"',
            ],
        ];

        foreach ($checkForForbidden as $values) {
            if (preg_match($values['regex'], $fileContent) > 0) {
                $this->messages[$values['type']]['title'] = $values['title'];
                $this->messages[$values['type']]['message'] = $values['message'];
                $this->isError = true;
            }
        }
    }
}

$dir = '';
$args = getopt('d:');
if (isset($args['d'])) {
    $dir = $args['d'];
}
$validator = new validateRstFiles($dir);
$validator->validate();
