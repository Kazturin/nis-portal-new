<?php

namespace App\Services;

class TiptapConverter
{
    public function asHTML($content)
    {
        if (is_string($content)) {
            $content = json_decode($content, true);
        }

        if (!$content || !isset($content['type']) || $content['type'] !== 'doc') {
            return $content ?: '';
        }

        return $this->renderNodes($content['content'] ?? []);
    }

    protected function renderNodes($nodes)
    {
        $html = '';
        foreach ($nodes as $node) {
            $html .= $this->renderNode($node);
        }
        return $html;
    }

    protected function renderNode($node)
    {
        $type = $node['type'] ?? '';
        $attrs = $node['attrs'] ?? [];
        $content = $node['content'] ?? [];

        switch ($type) {
            case 'text':
                $text = e($node['text'] ?? '');
                if (isset($node['marks'])) {
                    foreach ($node['marks'] as $mark) {
                        $text = $this->applyMark($text, $mark);
                    }
                }
                return $text;

            case 'heading':
                $level = $attrs['level'] ?? 1;
                $textAlign = $attrs['textAlign'] ?? 'start';
                $class = $this->combineClasses($attrs['class'] ?? '', "text-{$textAlign}");
                $style = $attrs['style'] ?? '';
                $inner = $this->renderNodes($content);
                return "<h{$level} class=\"{$class}\" style=\"{$style}\">{$inner}</h{$level}>";

            case 'paragraph':
                $textAlign = $attrs['textAlign'] ?? 'start';
                $class = $this->combineClasses($attrs['class'] ?? '', "text-{$textAlign}");
                $style = $attrs['style'] ?? '';
                $inner = $this->renderNodes($content);
                return "<p class=\"{$class}\" style=\"{$style}\">{$inner}</p>";

            case 'gridBuilder':
                $cols = $attrs['data-cols'] ?? '12';
                $stackAt = $attrs['data-stack-at'] ?? 'md';
                $inner = $this->renderNodes($content);
                return "<div class=\"filament-tiptap-grid-builder grid grid-cols-1 {$stackAt}:grid-cols-{$cols} gap-4 my-4\" data-stack-at=\"{$stackAt}\">{$inner}</div>";

            case 'gridBuilderColumn':
                $span = $attrs['data-col-span'] ?? '1';
                $inner = $this->renderNodes($content);
                $spanClass = $span ? "md:col-span-{$span}" : "";
                return "<div class=\"filament-tiptap-grid-builder__column {$spanClass}\">{$inner}</div>";

            case 'tiptapBlock':
                $blockType = $attrs['type'] ?? '';
                $data = $attrs['data'] ?? [];
                
                $viewMap = [
                    'advantageCard' => 'blocks.rendered.advantage',
                    'cardBlock' => 'blocks.rendered.card',
                    'horizontalCard' => 'blocks.rendered.horizontal',
                    'sliderBlock' => 'blocks.rendered.slider',
                    'bannerBlock' => 'blocks.rendered.banner',
                ];

                $view = $viewMap[$blockType] ?? null;
                if ($view && view()->exists($view)) {
                    return view($view, $data)->render();
                }
                return "<!-- Unknown Block: {$blockType} -->";

            case 'image':
                $src = $attrs['src'] ?? '';
                $alt = $attrs['alt'] ?? '';
                $width = $attrs['width'] ?? '100%';
                $style = $attrs['style'] ?? '';
                return "<img src=\"{$src}\" alt=\"{$alt}\" style=\"width:{$width}; {$style}\" />";

            case 'hardBreak':
                return "<br />";

            case 'bulletList':
                $inner = $this->renderNodes($content);
                return "<ul>{$inner}</ul>";

            case 'orderedList':
                $inner = $this->renderNodes($content);
                return "<ol>{$inner}</ol>";

            case 'listItem':
                $inner = $this->renderNodes($content);
                return "<li>{$inner}</li>";

            case 'blockquote':
                $inner = $this->renderNodes($content);
                return "<blockquote>{$inner}</blockquote>";

            case 'horizontalRule':
                return "<hr />";

            default:
                if (!empty($content)) {
                    return $this->renderNodes($content);
                }
                return '';
        }
    }

    protected function applyMark($text, $mark)
    {
        $type = $mark['type'] ?? '';
        $attrs = $mark['attrs'] ?? [];

        switch ($type) {
            case 'bold':
                return "<strong>{$text}</strong>";
            case 'italic':
                return "<em>{$text}</em>";
            case 'underline':
                return "<u>{$text}</u>";
            case 'strike':
                return "<s>{$text}</s>";
            case 'link':
                $href = e($attrs['href'] ?? '#');
                $target = e($attrs['target'] ?? '_blank');
                return "<a href=\"{$href}\" target=\"{$target}\">{$text}</a>";
            case 'textStyle':
                $color = $attrs['color'] ?? '';
                if ($color) {
                    return "<span style=\"color: {$color}\">{$text}</span>";
                }
                return $text;
            default:
                return $text;
        }
    }

    protected function combineClasses($original, $new)
    {
        $classes = array_filter(explode(' ', $original . ' ' . $new));
        return implode(' ', array_unique($classes));
    }
}
