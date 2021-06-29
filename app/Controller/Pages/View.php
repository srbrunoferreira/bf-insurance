<?php

namespace App\Controller\Pages;

use  App\Http\Routing\Request;

abstract class View
{
    private static string $defaultPageMetaRobots = 'index, follow';
    private static string $defaultPageMetaKeywords = 'gerenciamento, sistema';

    /**
     * Returns the view with its elements renderized.
     * @param string $title
     * @param array $customFields
     * @param bool $useDefaultHeaderAndFooter
     * @return string
     */
    protected static function getPage(string $title, array $customFields, bool $useDefaultHeaderAndFooter = true): string
    {
        if ($useDefaultHeaderAndFooter) {
            $customFields['pageHeader'] = self::getHeader();
            $customFields['pageFooter'] = self::getFooter();
        } else if (!isset($customFields['pageHeader']) && !isset($customFields['pageFooter'])) {
            $customFields['pageHeader'] = '';
            $customFields['pageFooter'] = '';
        }

        $customFields['pageTitle'] = $title;
        $customFields['pageRobots'] = $customFields['pageRobots'] ?? self::$defaultPageMetaRobots;
        $customFields['pageKeywords'] = $customFields['pageKeywords'] ?? self::$defaultPageMetaKeywords;
        $customFields['pageCanonical'] = Request::getCompleteUrl();

        return self::render('template/layout', $customFields);
    }

    /**
     * Replaces the short tags {{ tag }} for their values in the view.
     * @param string $view
     * @param array $customFields
     * @return string
     */
    protected static function render(string $view, array $customFields = []): string
    {
        $viewContent = self::getViewContent($view);
        $customFieldNames = array_keys($customFields);

        $customFieldNames = array_map(function($customFieldName) {
            return '{{' . $customFieldName . '}}';
        }, $customFieldNames);

        return str_replace($customFieldNames, array_values($customFields), $viewContent);
    }

    /**
     * Returns the template view.
     * @param string $viewPath
     * @return string
     */
    private static function getViewContent(string $viewPath): string
    {
        $file = '../resources/views/' . $viewPath . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    private static function getHeader()
    {
    }

    private static function getContent()
    {
    }

    private static function getFooter()
    {
    }
}
