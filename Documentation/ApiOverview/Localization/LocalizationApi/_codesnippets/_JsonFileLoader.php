<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\LanguageLoader;

use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

class JsonFileLoader implements LoaderInterface
{
    public function load(mixed $resource, string $locale, string $domain = 'messages'): MessageCatalogue
    {
        $catalogue = new MessageCatalogue($locale);
        if (!is_string($resource) || !file_exists($resource)) {
            throw new \InvalidArgumentException(sprintf('Resource "%s" is not a valid file.', $resource), 1695225932);
        }
        $data = json_decode(file_get_contents($resource), true, 512, JSON_THROW_ON_ERROR);
        foreach ($data as $key => $translation) {
            $catalogue->set((string)$key, (string)$translation, $domain);
        }
        return $catalogue;
    }
}
