<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BackofficeTextExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('backoffice_text', [$this, 'formatBackofficeText'], ['is_safe' => ['html']]),
        ];
    }

    public function formatBackofficeText(?string $text): string
    {
        if (!$text) {
            return '';
        }

        $blocks = preg_split('/\R{2,}/', trim($text));
        $html = [];

        foreach ($blocks as $block) {
            $block = trim($block);

            if ($block === '') {
                continue;
            }

            $block = htmlspecialchars($block, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

            $block = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $block);

            if (str_starts_with($block, '### ')) {
                $html[] = '<h3>' . trim(substr($block, 4)) . '</h3>';
            } elseif (str_starts_with($block, '## ')) {
                $html[] = '<h2>' . trim(substr($block, 3)) . '</h2>';
            } elseif (str_starts_with($block, '-&gt; ') && str_ends_with($block, ' &lt;-')) {
                $centeredText = trim(substr($block, 6, -5));
                $html[] = '<p class="text-center">' . nl2br($centeredText) . '</p>';
            } else {
                $html[] = '<p>' . nl2br($block) . '</p>';
            }
        }

        return implode("\n", $html);
    }
}